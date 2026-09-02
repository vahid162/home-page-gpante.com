#!/usr/bin/env bash
set -euo pipefail

# gpante.com Homepage — authenticated read-only WordPress preflight
#
# This script performs read-only WP-CLI commands only.
# It does not update options, posts, themes, plugins, caches, or database rows.

echo "== Active theme options =="
wp option get stylesheet
wp option get template

echo
echo "== Active theme list =="
wp theme list --status=active --fields=name,status,version --format=json

echo
echo "== Homepage Elementor data for page 10 =="
echo "The next command reads _elementor_data only. Pipe/store its output securely."
wp post meta get 10 _elementor_data --format=json
