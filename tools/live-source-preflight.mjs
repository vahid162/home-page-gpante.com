import fs from "node:fs";
import path from "node:path";

const base = "https://gpante.com";
const outDir = path.join(process.cwd(), "preflight-output");
fs.mkdirSync(outDir, { recursive: true });

async function fetchText(url) {
  const res = await fetch(url, {
    headers: {
      "user-agent": "gpante-homepage-readonly-preflight/1.0"
    },
    redirect: "follow"
  });
  return {
    url,
    status: res.status,
    ok: res.ok,
    contentType: res.headers.get("content-type") || "",
    text: await res.text()
  };
}

function unique(list) {
  return [...new Set(list)].sort();
}

const report = {
  generatedAt: new Date().toISOString(),
  mode: "read-only public GET",
  base,
  endpoints: {},
  homepage: {},
  wordpress: {},
  notes: []
};

const homepage = await fetchText(base + "/");
report.endpoints.homepage = {
  status: homepage.status,
  contentType: homepage.contentType
};

const pluginMatches = [...homepage.text.matchAll(/\/wp-content\/plugins\/([^\/"'?]+)/g)].map(m => m[1]);
const themeMatches = [...homepage.text.matchAll(/\/wp-content\/themes\/([^\/"'?]+)/g)].map(m => m[1]);
report.homepage.pluginAssetSlugs = unique(pluginMatches);
report.homepage.themeAssetSlugs = unique(themeMatches);
report.homepage.hasElementorAssets = pluginMatches.some(x => x.includes("elementor"));

const formSnippets = [];
for (const match of homepage.text.matchAll(/<form\b[\s\S]*?<\/form>/gi)) {
  const raw = match[0];
  const plain = raw.replace(/<[^>]+>/g, " ").replace(/\s+/g, " ").trim();
  if (/09|موبایل|تماس|contact|phone|tel/i.test(raw + " " + plain)) {
    formSnippets.push({
      action: (raw.match(/action=["']([^"']*)/i) || [])[1] || "",
      method: ((raw.match(/method=["']([^"']*)/i) || [])[1] || "GET").toUpperCase(),
      classes: (raw.match(/class=["']([^"']*)/i) || [])[1] || "",
      ids: unique([...raw.matchAll(/id=["']([^"']+)/gi)].map(m => m[1])),
      names: unique([...raw.matchAll(/name=["']([^"']+)/gi)].map(m => m[1])),
      text: plain.slice(0, 600)
    });
  }
}
report.homepage.contactLikeForms = formSnippets;

const allForms = [];
for (const match of homepage.text.matchAll(/<form\b[\s\S]*?<\/form>/gi)) {
  const raw = match[0];
  const plain = raw.replace(/<[^>]+>/g, " ").replace(/\s+/g, " ").trim();
  const inputs = [...raw.matchAll(/<input\b[^>]*>/gi)].map(inputMatch => {
    const tag = inputMatch[0];
    const attr = name => (tag.match(new RegExp(name + '=["\\\']([^"\\\']*)', 'i')) || [])[1] || "";
    return {
      type: attr("type") || "text",
      name: attr("name"),
      id: attr("id"),
      value: attr("value"),
      placeholder: attr("placeholder")
    };
  });
  const action = (raw.match(/action=["']([^"']*)/i) || [])[1] || "";
  const method = ((raw.match(/method=["']([^"']*)/i) || [])[1] || "GET").toUpperCase();
  const classes = (raw.match(/class=["']([^"']*)/i) || [])[1] || "";

  allForms.push({
    action,
    method,
    classes,
    text: plain.slice(0, 500),
    inputs
  });
}
report.homepage.forms = allForms;

const urls = {
  wpJsonRoot: base + "/wp-json/",
  wpTypes: base + "/wp-json/wp/v2/types",
  wpPosts: base + "/wp-json/wp/v2/posts?per_page=1&_fields=id,slug,date,title,link,excerpt,featured_media",
  wcProducts: base + "/wp-json/wc/store/v1/products?per_page=1",
  wcCategories: base + "/wp-json/wc/store/v1/products/categories?per_page=100"
};

for (const [key, url] of Object.entries(urls)) {
  try {
    const result = await fetchText(url);
    report.endpoints[key] = {
      status: result.status,
      ok: result.ok,
      contentType: result.contentType
    };

    if (/json/i.test(result.contentType) && result.text) {
      try {
        const data = JSON.parse(result.text);
        if (key === "wpJsonRoot") {
          report.wordpress.namespaces = data.namespaces || [];
          const routes = Object.keys(data.routes || {});
          report.wordpress.relevantRoutes = routes.filter(route =>
            /anspress|question|answer|contact|form|woocommerce|wc\/store|wp\/v2\/posts|product/i.test(route)
          ).slice(0, 300);
        } else if (key === "wpTypes") {
          report.wordpress.types = Object.fromEntries(
            Object.entries(data).map(([slug, value]) => [slug, {
              name: value?.name,
              rest_base: value?.rest_base,
              hierarchical: value?.hierarchical
            }])
          );
        } else {
          report[key] = Array.isArray(data) ? data.slice(0, 3) : data;
        }
      } catch (error) {
        report.notes.push(`${key}: JSON parse failed: ${error.message}`);
      }
    }
  } catch (error) {
    report.endpoints[key] = { error: error.message };
  }
}

const qnaUrls = [
  base + "/community/questions/",
  base + "/community/questions/?ap_page=ask"
];

for (const url of qnaUrls) {
  try {
    const result = await fetchText(url);
    const plugins = unique([...result.text.matchAll(/\/wp-content\/plugins\/([^\/"'?]+)/g)].map(m => m[1]));
    report.endpoints[url] = {
      status: result.status,
      contentType: result.contentType,
      pluginAssetSlugs: plugins
    };
  } catch (error) {
    report.endpoints[url] = { error: error.message };
  }
}

fs.writeFileSync(
  path.join(outDir, "live-source-report.json"),
  JSON.stringify(report, null, 2),
  "utf8"
);

console.log(JSON.stringify(report, null, 2));

