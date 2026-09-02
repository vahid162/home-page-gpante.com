# AGENTS.md

## Purpose

This repository is for the custom-coded implementation of the main content area of the gpante.com homepage.

The project must replace the Elementor-built homepage content with maintainable custom WordPress code while preserving the existing WordPress and WooCommerce data model and user-facing functionality.

This file defines mandatory rules for AI coding agents and human contributors.

## 1. Scope

### In scope

- The main content of the gpante.com homepage only.
- Rebuilding homepage sections with custom WordPress/PHP, semantic HTML, CSS, and minimal JavaScript.
- Responsive behavior for desktop, tablet, and mobile.
- Dynamic WordPress and WooCommerce integrations used by homepage sections.
- Performance, accessibility, SEO, maintainability, and visual fidelity of the homepage content.

### Explicitly out of scope

- Header.
- Footer.
- Global navigation.
- Global account/cart UI that belongs to the header.
- Redesigning or rebuilding product pages.
- Redesigning or rebuilding product category/archive pages.
- Redesigning or rebuilding blog/article pages.
- Removing Elementor from the rest of the website.
- Replacing WordPress or WooCommerce.
- Making direct changes to the production website unless the user explicitly requests and approves that action.

Do not modify the header or footer to make the homepage implementation easier. Adapt the homepage content to the existing site shell.

## 2. Project objective

The target architecture is:

- WordPress remains the CMS.
- WooCommerce remains the commerce/data layer.
- Existing products, categories, prices, discounts, stock state, links, posts, and other dynamic content remain managed from WordPress/WooCommerce.
- Elementor is removed only from the homepage main-content implementation when the replacement is ready.
- The homepage main content is rendered by custom theme/template code.

Do not turn dynamic homepage content into a static HTML snapshot.

## 3. Mandatory working method

Do not jump directly into implementation when the task affects architecture, data flow, compatibility, SEO, performance, or production behavior.

Before significant implementation work:

1. Define the problem.
2. Inspect the current repository state.
3. Inspect the current live homepage when current behavior matters.
4. Separate confirmed facts from assumptions.
5. Define requirements and constraints.
6. Identify data sources and integrations for every affected section.
7. Propose the implementation approach.
8. Identify risks.
9. Define tests and measurable success criteria.
10. Define a rollback path.
11. Then implement the smallest safe change.

For risky or production-related work, start with read-only/preflight checks.

## 4. Accuracy and evidence rules

- Never invent site behavior, plugin behavior, API behavior, performance data, or WordPress/WooCommerce details.
- Do not present an assumption as a confirmed fact.
- Label uncertain statements as inference, speculation, or unverified when appropriate.
- Verify current or changeable facts from the repository, the live site, or authoritative documentation.
- Prefer official WordPress, WooCommerce, browser, and web-platform documentation for technical claims.
- Do not claim a performance improvement until it is measured.
- Do not claim visual parity until it is compared.

## 5. Existing homepage behavior

Treat the live homepage as the current behavioral reference until a new requirement explicitly replaces it.

The current homepage main content includes, among other items:

- Hero/intro content.
- Homepage search.
- Laser-cut design/product categories.
- Promotional/discounted products.
- Newest and best-selling product presentations.
- Promotional/service callouts.
- Latest questions and answers.
- Latest articles.
- Support/service messaging.
- Customer testimonials.
- Contact/callback form.
- Telegram/community promotion.

This list is an inventory aid, not permission to hard-code current content.

Before implementing a section, confirm its current data source and behavior.

## 6. WordPress and WooCommerce integration rules

- Use WordPress and WooCommerce APIs instead of duplicating business data.
- Product titles, prices, sale prices, images, URLs, badges, categories, and similar data must come from the appropriate WordPress/WooCommerce source when they are dynamic.
- Do not hard-code product IDs, category IDs, URLs, prices, counts, or copy that is expected to change unless there is a documented reason.
- Avoid direct database queries when a stable WordPress/WooCommerce API is available.
- Escape output using the appropriate WordPress escaping functions.
- Sanitize and validate all user input.
- Use nonces and permission checks for state-changing requests.
- Do not expose secrets, credentials, internal paths, or private configuration.

## 7. Front-end rules

### HTML

- Use semantic HTML5.
- Keep the DOM as small and shallow as practical.
- Do not reproduce Elementor wrapper depth without a functional reason.
- Use meaningful heading hierarchy.
- Preserve a single clear page-level H1 strategy in coordination with the active theme/template.
- Use buttons for actions and links for navigation.

### CSS

- Prefer project-owned CSS over large UI frameworks.
- Keep selectors understandable and maintainable.
- Avoid unnecessary specificity and deeply nested selectors.
- Avoid global rules that can unintentionally affect the existing header, footer, WooCommerce pages, or other site areas.
- Scope homepage-specific styles clearly.
- Respect RTL layout and Persian typography.
- Use responsive layouts that do not depend on device-specific hacks.

### JavaScript

- Use JavaScript only when required for behavior.
- Prefer native browser APIs.
- Do not add a library for functionality that can be implemented safely with a small amount of native JavaScript.
- Avoid blocking scripts.
- Load scripts only where they are needed.
- Progressive enhancement is preferred.
- Core content and navigation should remain usable when JavaScript fails whenever feasible.

## 8. Performance requirements

Performance is a first-class requirement.

- Minimize DOM size.
- Minimize CSS and JavaScript payloads.
- Avoid unnecessary third-party dependencies.
- Avoid loading Elementor assets for the custom homepage content when they are not required.
- Optimize image dimensions and formats.
- Provide explicit image dimensions where possible to reduce layout shift.
- Lazy-load below-the-fold images when appropriate.
- Do not lazy-load the likely LCP image when doing so would delay it.
- Avoid unnecessary render-blocking resources.
- Reuse WordPress/LiteSpeed/Cloudflare capabilities only when they fit the final deployment architecture.
- Measure before and after changes.

Track at least:

- LCP.
- CLS.
- INP when field data is available.
- Lighthouse/PageSpeed performance diagnostics.
- Number and size of CSS/JS resources where practical.
- DOM size/complexity where practical.

Never state a percentage performance gain without benchmark evidence.

## 9. SEO requirements

The migration must not degrade SEO.

Preserve or deliberately improve:

- Existing homepage URL.
- Relevant page title and metadata managed by WordPress/SEO tooling.
- Heading structure.
- Indexable text content.
- Internal links.
- Image alt text.
- Canonical behavior.
- Structured data/schema generated by the existing stack.
- Crawlability.
- Mobile usability.
- Core Web Vitals.

Do not duplicate schema that is already generated by WordPress, WooCommerce, or the active SEO plugin without first checking the current output.

## 10. Accessibility requirements

- Use keyboard-accessible interactions.
- Provide visible focus states.
- Use accessible names for controls.
- Associate labels with form fields.
- Do not rely on color alone to communicate state.
- Maintain sufficient contrast.
- Respect reduced-motion preferences for non-essential animation.
- Ensure sliders, tabs, accordions, and other interactive components remain operable without a mouse.
- Use ARIA only when native semantic HTML cannot express the required behavior.

## 11. Responsive and RTL requirements

The homepage must work correctly in Persian RTL.

At minimum test:

- Small mobile viewport.
- Large mobile viewport.
- Tablet viewport.
- Desktop viewport.
- Wide desktop viewport.

Check:

- No horizontal overflow.
- Correct RTL alignment.
- Correct order of text, icons, controls, and cards.
- Readable typography.
- Touch-friendly controls.
- Stable image/card dimensions.
- No overlap with the existing header or footer.

Do not assume the desktop layout can simply be scaled down.

## 12. Visual implementation rules

- First reproduce the required content hierarchy and behavior.
- Keep visual decisions intentional and documented.
- Do not make broad redesign decisions without user approval.
- Reuse the existing visual identity where appropriate.
- New UI must feel consistent with the existing website shell.
- Animations must have a functional purpose and must not materially hurt performance or accessibility.

When exact visual parity is requested, compare screenshots at matching viewport sizes.

## 13. Dependencies

Before adding a dependency:

1. Explain what problem it solves.
2. Check whether WordPress, WooCommerce, the current theme, or native browser APIs already solve it.
3. Evaluate performance and maintenance cost.
4. Use the smallest stable option.
5. Obtain user approval for material new dependencies.

Do not add a front-end framework by default.

## 14. Repository and change discipline

- Read existing files before editing them.
- Keep changes limited to the requested scope.
- Do not refactor unrelated files.
- Do not change production configuration as a side effect.
- Use clear file names and predictable structure.
- Keep commits focused and describable.
- Update documentation when architecture or operating assumptions change.
- Never delete working code or assets merely because they appear unused without verifying their references.

## 15. Testing requirements

A homepage implementation is not complete until relevant tests pass.

At minimum verify:

### Functional

- Dynamic products render correctly.
- Product links are correct.
- Prices and sale states are correct.
- Category links/counts are correct where displayed.
- Search works as intended.
- Tabs/sliders/interactions work.
- Forms validate and submit correctly.
- Empty states do not break layout.

### Visual

- Desktop layout.
- Tablet layout.
- Mobile layout.
- RTL behavior.
- Long Persian titles.
- Missing/slow images.
- Sale and non-sale products.

### Compatibility

- Current supported WordPress environment.
- Current WooCommerce behavior used by the site.
- Major modern browsers.

### Regression

- Header is unchanged.
- Footer is unchanged.
- Other site pages are unchanged.
- Existing WooCommerce data remains untouched.

### Performance

Run comparable before/after measurements under documented test conditions.

## 16. Success criteria

A migration can be considered successful only when:

- Header and footer remain unchanged.
- Homepage main-content functionality is preserved or intentionally improved.
- Dynamic WordPress/WooCommerce content remains manageable from the CMS.
- No required homepage feature depends on Elementor without an explicit documented exception.
- Responsive and RTL behavior pass testing.
- SEO-critical content and links are preserved.
- Accessibility has no known critical regression.
- Performance is measured and is not materially worse than the baseline.
- The implementation is maintainable without relying on Elementor for homepage main content.

## 17. Rollback

Before replacing the live Elementor homepage content:

- Preserve the existing Elementor version.
- Keep a restorable backup or revision.
- Deploy and test the custom implementation in a safe environment first.
- Document how to switch back to the previous homepage.
- Do not remove the fallback until the replacement has passed validation.

## 18. Decision hierarchy

When requirements conflict, use this order unless the user explicitly changes it:

1. Correctness and data integrity.
2. Security.
3. Preservation of required functionality.
4. Accessibility.
5. SEO.
6. Performance.
7. Maintainability.
8. Visual polish.

Do not sacrifice correctness or dynamic behavior for a superficial visual match.

## 19. Stop conditions

Do not proceed silently when:

- A requested change would modify the header or footer.
- A change would affect the whole theme or other pages unexpectedly.
- Production credentials or destructive database actions are required.
- Current behavior cannot be verified and guessing would affect implementation.
- A dependency or architectural change materially expands project scope.

In these cases, report the constraint and propose the smallest safe next step.

## 20. Current project phase

The project is currently in documentation, inventory, architecture, and planning.

Do not treat the homepage redesign/implementation as approved merely because this repository exists.

Implementation should proceed section by section after the required behavior, data source, visual target, and acceptance criteria for that section are understood.


## 21. Automated visual QA

For changes under `prototype/`, use the repository visual QA workflow as the preferred reproducible browser-validation path.

The workflow is defined in:

- `.github/workflows/prototype-visual-qa.yml`
- `prototype/qa/visual-check.mjs`

Requirements:

- Render the committed prototype in Chromium, not a separately recreated mock.
- Test Desktop, Tablet, and Mobile viewports.
- Check for page-level horizontal overflow.
- Verify that Header and Footer remain outside prototype scope.
- Verify critical interactions such as product tabs, mobile category expansion, and contact-form validation.
- Capture full-page screenshots for all required viewports.
- Preserve the generated QA report and screenshots as a workflow artifact.
- Do not claim screenshot-based visual QA passed unless the workflow completed successfully and its outputs were inspected.
- If direct browser access to GitHub or another external host is blocked, do not treat that as a blocker. Use the repository workflow or a local checkout/file-based render path instead.
- CI-only QA dependencies must not be added to the production front-end bundle.
