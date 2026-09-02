#!/usr/bin/env bash
set -euo pipefail

# gpante.com Homepage — authenticated read-only WordPress preflight
#
# Purpose:
# - Confirm the active parent/child theme.
# - Confirm the Homepage template state.
# - Find Elementor widget b25d804 inside Page ID 10.
# - Extract only the form settings needed to reproduce current submit behavior.
#
# WordPress/database safety:
# - READ-ONLY WP-CLI commands only.
# - No option update, post update, plugin/theme change, cache purge, SQL write,
#   search-replace, delete, activate, deactivate, or form submission.
#
# Usage:
#   bash tools/wp-cli-readonly-preflight.sh /path/to/wordpress
#
# If already inside the WordPress root:
#   bash tools/wp-cli-readonly-preflight.sh .
#
# Output:
#   ./gpante-preflight-output/share-with-chatgpt.json
#   ./gpante-preflight-output/form-b25d804-private.json
#
# Send ONLY share-with-chatgpt.json back to ChatGPT.
# Keep form-b25d804-private.json on the server. It may contain private
# destinations such as email addresses or webhook URLs.

PAGE_ID=10
WIDGET_ID="b25d804"
WP_PATH="${1:-.}"
OUTPUT_DIR="${2:-./gpante-preflight-output}"

if ! command -v wp >/dev/null 2>&1; then
  echo "ERROR: wp-cli was not found in PATH." >&2
  exit 1
fi

if ! command -v php >/dev/null 2>&1; then
  echo "ERROR: php CLI was not found in PATH." >&2
  exit 1
fi

mkdir -p "$OUTPUT_DIR"
chmod 700 "$OUTPUT_DIR"

TMP_DIR="$(mktemp -d)"
trap 'rm -rf "$TMP_DIR"' EXIT

WP_ARGS=(--path="$WP_PATH")
if [ "$(id -u)" -eq 0 ]; then
  WP_ARGS+=(--allow-root)
fi

wp_ro() {
  wp "${WP_ARGS[@]}" "$@"
}

echo "== 1/6 WordPress installation check =="
wp_ro core is-installed
echo "OK: WordPress detected at: $WP_PATH"

echo
echo "== 2/6 Active theme =="
STYLESHEET="$(wp_ro option get stylesheet)"
TEMPLATE="$(wp_ro option get template)"
ACTIVE_THEME_JSON="$(wp_ro theme list --status=active --fields=name,status,version --format=json)"

echo "stylesheet: $STYLESHEET"
echo "template:   $TEMPLATE"
echo "$ACTIVE_THEME_JSON"

echo
echo "== 3/6 Homepage template state =="
PAGE_TEMPLATE="$(wp_ro post meta get "$PAGE_ID" _wp_page_template 2>/dev/null || true)"
if [ -z "$PAGE_TEMPLATE" ]; then
  PAGE_TEMPLATE="default"
fi
echo "Page ID:   $PAGE_ID"
echo "Template:  $PAGE_TEMPLATE"

echo
echo "== 4/6 Elementor versions =="
ELEMENTOR_VERSION="$(wp_ro plugin get elementor --field=version 2>/dev/null || true)"
ELEMENTOR_PRO_VERSION="$(wp_ro plugin get elementor-pro --field=version 2>/dev/null || true)"
echo "Elementor:     ${ELEMENTOR_VERSION:-not-detected}"
echo "Elementor Pro: ${ELEMENTOR_PRO_VERSION:-not-detected}"

echo
echo "== 5/6 Reading Elementor page data (read-only) =="
RAW_JSON="$TMP_DIR/elementor-data.json"
wp_ro post meta get "$PAGE_ID" _elementor_data > "$RAW_JSON"

if [ ! -s "$RAW_JSON" ]; then
  echo "ERROR: _elementor_data for Page $PAGE_ID is empty." >&2
  exit 2
fi

PARSER="$TMP_DIR/extract-form.php"
cat > "$PARSER" <<'PHP'
<?php

if ($argc < 8) {
    fwrite(STDERR, "Parser arguments missing.\n");
    exit(10);
}

$rawPath      = $argv[1];
$privatePath  = $argv[2];
$summaryPath  = $argv[3];
$pageId       = (int) $argv[4];
$widgetId     = (string) $argv[5];
$stylesheet   = (string) $argv[6];
$template     = (string) $argv[7];
$pageTemplate = (string) ($argv[8] ?? 'default');
$elementor    = (string) ($argv[9] ?? '');
$elementorPro = (string) ($argv[10] ?? '');

$raw = file_get_contents($rawPath);
if ($raw === false || trim($raw) === '') {
    fwrite(STDERR, "Cannot read Elementor data.\n");
    exit(11);
}

$data = json_decode($raw, true);

// Be tolerant if a WP-CLI/environment layer returned a JSON-encoded JSON string.
if (is_string($data)) {
    $data = json_decode($data, true);
}

if (!is_array($data)) {
    fwrite(STDERR, "Elementor data is not valid JSON.\n");
    exit(12);
}

function find_widget_by_id(array $nodes, string $targetId): ?array {
    foreach ($nodes as $node) {
        if (!is_array($node)) {
            continue;
        }

        if (($node['id'] ?? null) === $targetId) {
            return $node;
        }

        if (!empty($node['elements']) && is_array($node['elements'])) {
            $found = find_widget_by_id($node['elements'], $targetId);
            if ($found !== null) {
                return $found;
            }
        }
    }

    return null;
}

function listify($value): array {
    if ($value === null || $value === '' || $value === []) {
        return [];
    }

    if (is_array($value)) {
        return array_values(array_filter(array_map('strval', $value), static fn($v) => $v !== ''));
    }

    if (is_string($value)) {
        $parts = preg_split('/\s*,\s*/', $value) ?: [];
        return array_values(array_filter($parts, static fn($v) => $v !== ''));
    }

    return [(string) $value];
}

function redact_url(string $url): string {
    if ($url === '') {
        return '';
    }

    $parts = parse_url($url);
    if ($parts === false || empty($parts['host'])) {
        return '[configured:redacted-url]';
    }

    $scheme = $parts['scheme'] ?? 'https';
    $path   = $parts['path'] ?? '';

    return $scheme . '://' . $parts['host'] . $path .
        (isset($parts['query']) ? '?[query-redacted]' : '');
}

function sanitize_value(string $key, $value) {
    $lower = strtolower($key);

    if (preg_match('/password|secret|token|api[_-]?key|authorization/', $lower)) {
        return ($value === null || $value === '' || $value === []) ? '' : '[configured:redacted]';
    }

    if (preg_match('/webhook|redirect.*url|url.*redirect/', $lower)) {
        if (is_string($value)) {
            return redact_url($value);
        }
        return ($value === null || $value === [] || $value === '') ? $value : '[configured:redacted-url]';
    }

    if (preg_match('/email_to|email_from|email_reply|reply_to|recipient|to_email|from_email/', $lower)) {
        return ($value === null || $value === '' || $value === []) ? '' : '[configured:redacted-email]';
    }

    if (is_array($value)) {
        $out = [];
        foreach ($value as $k => $v) {
            $out[$k] = sanitize_value((string) $k, $v);
        }
        return $out;
    }

    return $value;
}

$widget = find_widget_by_id($data, $widgetId);

if ($widget === null) {
    $summary = [
        'ok'        => false,
        'page_id'   => $pageId,
        'widget_id' => $widgetId,
        'error'     => 'Widget ID not found in _elementor_data.',
    ];

    file_put_contents(
        $summaryPath,
        json_encode($summary, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
    );

    fwrite(STDERR, "Widget $widgetId not found.\n");
    exit(13);
}

$privateJson = json_encode(
    $widget,
    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
);
file_put_contents($privatePath, $privateJson);
chmod($privatePath, 0600);

$settings = is_array($widget['settings'] ?? null) ? $widget['settings'] : [];

$actions = [];
foreach (['submit_actions', 'actions_after_submit'] as $actionKey) {
    if (array_key_exists($actionKey, $settings)) {
        $actions = array_values(array_unique(array_merge($actions, listify($settings[$actionKey]))));
    }
}

$fields = [];
foreach (($settings['form_fields'] ?? []) as $field) {
    if (!is_array($field)) {
        continue;
    }

    $fields[] = [
        'custom_id'   => $field['custom_id'] ?? null,
        'field_type'  => $field['field_type'] ?? null,
        'field_label' => $field['field_label'] ?? null,
        'required'    => $field['required'] ?? null,
        'placeholder' => $field['placeholder'] ?? null,
        'width'       => $field['width'] ?? null,
    ];
}

$relevant = [];
foreach ($settings as $key => $value) {
    if ($key === 'form_fields') {
        continue;
    }

    if (preg_match(
        '/submit|action|email|mail|webhook|redirect|submission|success|error|message|form_name|button_text|recipient|reply/i',
        (string) $key
    )) {
        $relevant[$key] = sanitize_value((string) $key, $value);
    }
}

$summary = [
    'ok' => true,
    'wordpress' => [
        'page_id'       => $pageId,
        'stylesheet'    => $stylesheet,
        'template'      => $template,
        'page_template' => $pageTemplate,
    ],
    'plugins' => [
        'elementor'     => $elementor !== '' ? $elementor : null,
        'elementor_pro' => $elementorPro !== '' ? $elementorPro : null,
    ],
    'form' => [
        'widget_id'       => $widgetId,
        'el_type'         => $widget['elType'] ?? null,
        'widget_type'     => $widget['widgetType'] ?? null,
        'form_name'       => $settings['form_name'] ?? null,
        'button_text'     => $settings['button_text'] ?? null,
        'submit_actions'  => $actions,
        'fields'          => $fields,
        'relevant_settings_redacted' => $relevant,
    ],
    'private_file_created' => basename($privatePath),
    'note' => 'Send this summary file to ChatGPT. Do not send the private file unless you manually review/redact it first.',
];

file_put_contents(
    $summaryPath,
    json_encode($summary, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
);
chmod($summaryPath, 0600);

echo json_encode(
    $summary,
    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
), PHP_EOL;
PHP

PRIVATE_OUT="$OUTPUT_DIR/form-b25d804-private.json"
SUMMARY_OUT="$OUTPUT_DIR/share-with-chatgpt.json"

echo
echo "== 6/6 Extracting widget $WIDGET_ID =="
php "$PARSER"   "$RAW_JSON"   "$PRIVATE_OUT"   "$SUMMARY_OUT"   "$PAGE_ID"   "$WIDGET_ID"   "$STYLESHEET"   "$TEMPLATE"   "$PAGE_TEMPLATE"   "$ELEMENTOR_VERSION"   "$ELEMENTOR_PRO_VERSION"

chmod 600 "$PRIVATE_OUT" "$SUMMARY_OUT"

echo
echo "============================================================"
echo "DONE — no WordPress/database changes were made."
echo
echo "SAFE FILE TO SEND TO CHATGPT:"
echo "  $SUMMARY_OUT"
echo
echo "PRIVATE FILE — KEEP ON SERVER:"
echo "  $PRIVATE_OUT"
echo
echo "To print only the safe summary:"
echo "  cat '$SUMMARY_OUT'"
echo "============================================================"
