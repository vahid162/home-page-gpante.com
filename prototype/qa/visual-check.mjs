import { chromium } from "playwright";
import fs from "node:fs";
import path from "node:path";
import { pathToFileURL } from "node:url";

const root = process.cwd();
const prototypePath = path.join(root, "prototype", "index.html");
const outputDir = path.join(root, "prototype", "qa", "output");

fs.mkdirSync(outputDir, { recursive: true });

const viewports = [
  { name: "desktop", width: 1440, height: 1000 },
  { name: "tablet", width: 820, height: 1180 },
  { name: "mobile", width: 390, height: 844 },
];

const browser = await chromium.launch({ headless: true });
const report = {
  generatedAt: new Date().toISOString(),
  source: "prototype/index.html",
  checks: [],
  viewports: {},
};

let failed = false;

function record(name, passed, details = "") {
  report.checks.push({ name, passed, details });
  if (!passed) failed = true;
  console.log(`${passed ? "PASS" : "FAIL"}: ${name}${details ? " — " + details : ""}`);
}

for (const viewport of viewports) {
  const page = await browser.newPage({
    viewport: { width: viewport.width, height: viewport.height },
    locale: "fa-IR",
  });

  const errors = [];
  page.on("pageerror", (error) => errors.push(String(error)));

  await page.goto(pathToFileURL(prototypePath).href, { waitUntil: "load" });

  const metrics = await page.evaluate(() => ({
    scrollWidth: document.documentElement.scrollWidth,
    clientWidth: document.documentElement.clientWidth,
    scrollHeight: document.documentElement.scrollHeight,
    h1: document.querySelector("h1")?.textContent?.trim() || "",
    headerCount: document.querySelectorAll("header").length,
    footerCount: document.querySelectorAll("body > footer, main + footer").length,
  }));

  report.viewports[viewport.name] = {
    ...viewport,
    ...metrics,
    pageErrors: errors,
  };

  record(
    `${viewport.name}: no horizontal page overflow`,
    metrics.scrollWidth <= metrics.clientWidth + 1,
    `scrollWidth=${metrics.scrollWidth}, clientWidth=${metrics.clientWidth}`
  );

  record(`${viewport.name}: H1 is present`, Boolean(metrics.h1), metrics.h1);
  record(`${viewport.name}: header remains out of scope`, metrics.headerCount === 0);
  record(`${viewport.name}: footer remains out of scope`, metrics.footerCount === 0);
  record(`${viewport.name}: no uncaught JavaScript errors`, errors.length === 0, errors.join(" | "));

  await page.screenshot({
    path: path.join(outputDir, `${viewport.name}.png`),
    fullPage: true,
  });

  if (viewport.name === "desktop") {
    await page.getByRole("tab", { name: "پرفروش‌ترین‌ها" }).click();
    record(
      "desktop: product tabs switch correctly",
      await page.locator("#best-products").isVisible()
    );

    await page.getByLabel("شماره موبایل").fill("09123456789");
    await page.getByRole("button", { name: "درخواست تماس" }).click();
    const status = await page.locator("#mobile-status").textContent();
    record(
      "desktop: prototype contact validation accepts valid Iranian mobile format",
      Boolean(status?.includes("شماره معتبر است")),
      status?.trim() || ""
    );
  }

  if (viewport.name === "mobile") {
    const toggle = page.locator("[data-category-toggle]");
    record("mobile: category expansion control is visible", await toggle.isVisible());

    if (await toggle.isVisible()) {
      await toggle.click();
      record(
        "mobile: hidden category cards can be expanded",
        await page.locator(".hp-category-card--extra").first().isVisible()
      );
    }

    const heroVisualDisplay = await page
      .locator(".hp-hero__visual")
      .evaluate((el) => getComputedStyle(el).display);
    record(
      "mobile: decorative hero visual is removed from above-the-fold",
      heroVisualDisplay === "none",
      `display=${heroVisualDisplay}`
    );
  }

  await page.close();
}

await browser.close();

fs.writeFileSync(
  path.join(outputDir, "report.json"),
  JSON.stringify(report, null, 2),
  "utf8"
);

if (failed) {
  process.exitCode = 1;
}
