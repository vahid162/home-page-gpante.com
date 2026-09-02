# Homepage Integration Architecture

**Baseline:** Visual v0.3  
**Architecture status:** Approved for implementation planning  
**Scope:** Main Content only  
**Header/Footer:** Out of scope  
**Production changes:** None in this phase

---

# 1. Objective

هدف این Architecture اتصال Visual Baseline v0.3 به داده‌های واقعی WordPress/WooCommerce/wpForo است، بدون بازسازی Header و Footer و بدون باقی‌گذاشتن وابستگی Main Content به Elementor.

اصل اصلی:

```text
Existing Theme Shell
(Header / Footer / global navigation)
        │
        ▼
Custom Homepage Main Content
        │
        ├── WordPress
        ├── WooCommerce
        ├── wpForo
        └── Native WordPress form handler
```

---

# 2. Architecture principles

1. Initial page content باید Server-side Render شود.
2. Main Content نباید SPA شود.
3. Product/business data نباید در Template Hard-code شود.
4. Template Partها نباید Query مستقیم اجرا کنند.
5. تمام Queryها پشت Data Adapter function قرار می‌گیرند.
6. Direct SQL ممنوع است مگر اینکه بعداً دلیل فنی مستند و تأییدشده وجود داشته باشد.
7. برای Products، WooCommerce APIs اولویت دارند.
8. برای Articles، WordPress APIs استفاده می‌شوند.
9. برای Q&A، API داخلی wpForo استفاده می‌شود.
10. JavaScript فقط برای Interactionهایی مانند Tabs و Form enhancement استفاده می‌شود.
11. Header/Footer assetها نباید برای کاهش Elementor payload به‌صورت کورکورانه dequeue شوند.
12. Performance improvement فقط بعد از Benchmark اعلام می‌شود.

---

# 3. Deployment boundary

Production فعلی Woodmart و `woodmart-child` asset بارگذاری می‌کند.

Implementation باید در **Child Theme boundary** قرار گیرد؛ Parent Theme نباید تغییر کند.

## Preferred integration

پس از Read-only theme audit، یکی از این دو روش انتخاب شود:

### Option A — Assigned custom page template

ترجیح اول، اگر Woodmart template hierarchy اجازه دهد.

مزیت:

- Rollback ساده با تغییر Page Template.
- Elementor page/revision قبلی باقی می‌ماند.
- Main Content جدید فقط برای Homepage فعال می‌شود.

### Option B — Child-theme front-page override

فقط اگر Theme hierarchy یا Woodmart behavior باعث شود Assigned Page Template مناسب نباشد.

در این حالت:

- `get_header()` حفظ می‌شود.
- فقط Main Content custom render می‌شود.
- `get_footer()` حفظ می‌شود.

**قبل از انتخاب A/B باید Parent/Child theme files read-only بررسی شوند.**

---

# 4. Proposed code organization

این ساختار Target است و هنوز ایجاد نشده:

```text
src/homepage/
├── bootstrap.php
├── config.php
├── data/
│   ├── products.php
│   ├── categories.php
│   ├── posts.php
│   ├── wpforo.php
│   └── editorial.php
├── forms/
│   └── callback-request.php
├── template-parts/
│   ├── hero.php
│   ├── categories.php
│   ├── special-offers.php
│   ├── products.php
│   ├── value-props.php
│   ├── knowledge.php
│   ├── support.php
│   ├── testimonials.php
│   ├── contact.php
│   └── community.php
└── assets/
    ├── homepage.css
    └── homepage.js
```

در Deployment واقعی pathها با ساختار `woodmart-child` هماهنگ می‌شوند.

---

# 5. Data Adapter rule

Templateها فقط normalized view-model دریافت می‌کنند.

مثال:

```php
$products = gpante_home_get_new_products( 4 );
```

Template نباید خودش `wc_get_products()` یا `WP_Query` اجرا کند.

مزیت:

- Testability
- امکان تغییر Query بدون تغییر HTML
- جلوگیری از coupling
- ساده‌شدن Mock/fixture tests

---

# 6. Section-to-source matrix

| Section | Current confirmed source | Target source | Render |
|---|---|---|---|
| Hero copy | Elementor/static page content | Editorial config | SSR |
| Hero search | WordPress product search | همان Contract فعلی | Native GET |
| Categories | WooCommerce product_cat | WooCommerce taxonomy | SSR |
| Special Offers | WooCommerce products | WooCommerce product API | SSR |
| Newest Products | WooCommerce products | WC_Product_Query | SSR |
| Best-selling | WooCommerce popularity | WooCommerce Store API popularity | Deferred JS / progressive |
| Value Propositions | Static editorial content | Editorial config | SSR |
| Q&A | wpForo Recent Activity | wpForo PHP API | SSR |
| Articles | WordPress Posts | WP_Query / get_posts | SSR |
| Support | Static Elementor content | Editorial config | SSR |
| Testimonials | Media Library images | Curated Media Library attachments | SSR |
| Contact | Elementor Pro Form | Native WP handler after parity audit | POST |
| Telegram | Static links | Editorial config | SSR |

---

# 7. Hero architecture

## 7.1 Copy

Data source:

```text
src/homepage/config.php
```

Phase 1 باید Copy را به‌صورت explicit editorial configuration نگه دارد.

دلیل اینکه فعلاً Admin UI جدید ایجاد نمی‌کنیم:

- Requirement برای ویرایش مکرر Hero وجود ندارد.
- اضافه‌کردن Settings framework یا ACF فقط برای چند Text field Dependency غیرضروری ایجاد می‌کند.

اگر بعداً نیاز Editorial ایجاد شد، native WordPress settings یا page meta طراحی می‌شود.

## 7.2 Search

Contract فعلی باید عیناً حفظ شود:

```html
<form method="get" action="/">
  <input name="s">
  <input type="hidden" name="post_type" value="product">
</form>
```

No AJAX is required for the baseline.

Woodmart AJAX Search نباید برای Main Content Dependency اجباری باشد.

Progressive enhancement در آینده ممکن است، ولی Native GET باید همیشه کار کند.

## 7.3 CTA

### مشاهده همه طرح‌ها

Target URL باید با WooCommerce shop page تولید شود:

```php
get_permalink( wc_get_page_id( 'shop' ) )
```

و نباید `/shop/` به‌صورت literal در Template نوشته شود.

### فایل‌های رایگان

Contract فعلی search-based است:

```text
/?post_type=product&s=رایگان
```

URL باید با `add_query_arg()` تولید شود.

---

# 8. Categories architecture

Current Homepage یک curated list دارد، نه تمام Product Categories.

بنابراین دو چیز باید جدا شوند:

1. **Selection** — کدام دسته‌ها نمایش داده شوند.
2. **Data** — Name/count/permalink واقعی هر دسته.

## 8.1 Curated selection

Selection بر اساس Slugهای مستند نگهداری می‌شود، نه numeric ID:

```text
laser-cut-stand-design
laser-cut-game-and-puzzle-file
box
light-and-lamp
قاب
laser-cut-office-organizer-design
home-and-office-decor
laser-cutting-vector
```

Slug list یک editorial configuration است و Hard-coded business data محسوب نمی‌شود؛ این list عمداً Selection صفحه را تعریف می‌کند.

## 8.2 Dynamic fields

برای هر Slug از `product_cat` دریافت شود:

- term_id
- name
- count
- permalink

Preferred API:

```php
get_term_by()
get_term_link()
```

Count از `WP_Term->count` می‌آید.

قبل از Implementation باید Slug فارسی `قاب` روی Production با `sanitize_title()` / actual stored slug تأیید شود.

## 8.3 View model

```php
[
  'id'        => int,
  'slug'      => string,
  'name'      => string,
  'count'     => int,
  'url'       => string,
  'icon_key'  => string,
]
```

`icon_key` editorial است؛ سایر داده‌ها dynamic هستند.

---

# 9. Product card contract

تمام Product Sectionها باید یک Product Card view-model مشترک داشته باشند.

```php
[
  'id'              => int,
  'name'            => string,
  'url'             => string,
  'image_url'       => string,
  'image_alt'       => string,
  'image_width'     => int|null,
  'image_height'    => int|null,
  'regular_price'   => string,
  'sale_price'      => string,
  'current_price'   => string,
  'is_on_sale'      => bool,
  'sale_percent'    => int|null,
  'is_purchasable'  => bool,
  'is_in_stock'     => bool,
]
```

Template نباید WooCommerce object methods را پراکنده صدا بزند.

Normalization در Product Adapter انجام می‌شود.

---

# 10. Special Offers

## Source

WooCommerce.

Preferred server-side source:

```php
wc_get_product_ids_on_sale()
wc_get_products()
```

WooCommerce خود `wc_get_product_ids_on_sale()` را به‌عنوان API برای Productهای On Sale ارائه می‌کند.

## Query contract

Baseline:

- status: publish
- visible catalog products
- on sale only
- limit: 4
- order: newest sale-capable products first

در Mobile CSS فقط subset نمایش می‌دهد؛ Data query می‌تواند همچنان 4 Item برگرداند.

## Fallback

اگر محصول Sale وجود نداشت:

- Section کامل Render نشود.
- Empty decorative block نشان داده نشود.

---

# 11. Newest Products

Preferred API:

```php
wc_get_products()
```

Query contract:

```text
status      = publish
visibility  = visible
limit       = 4
orderby     = date
order       = DESC
```

WooCommerce documentation صراحتاً `wc_get_products()` / `WC_Product_Query` را مسیر استاندارد و future-safe برای Product query معرفی می‌کند.

---

# 12. Best-selling Products

این Section یک نکته مهم دارد:

WooCommerce Store API رسماً:

```text
orderby=popularity
```

را پشتیبانی می‌کند و Production فعلی نیز Store API را public expose می‌کند.

## Chosen baseline architecture

برای جلوگیری از Custom SQL و query بر اساس private meta:

- Newest tab در HTML اولیه SSR می‌شود.
- Best-selling data در اولین activation Tab از Store API دریافت می‌شود.
- اگر JS در دسترس نباشد، Newest همچنان usable است.
- Tab یا fallback link می‌تواند به:
  `/shop/?orderby=popularity`
  هدایت شود.

Request concept:

```text
/wp-json/wc/store/v1/products
  ?orderby=popularity
  &order=desc
  &per_page=4
  &catalog_visibility=visible
```

## Security rule

Store API response در Client با `textContent` و DOM APIs Render شود.

Raw API HTML نباید بدون نیاز با `innerHTML` تزریق شود.

---

# 13. Value Proposition

Data source:

Editorial configuration.

این Section یک Business Claim layer است.

هر claim باید قبل از Production با خدمات واقعی تطبیق داده شود.

View model:

```php
[
  'icon_key' => string,
  'title'    => string,
  'body'     => string,
]
```

No database query.

---

# 14. Q&A / wpForo architecture

## Confirmed behavior

Live Homepage currently displays mixed activity including Reply/Answer entries.

پس Data Contract باید **Recent Public Forum Activity** باشد، نه صرفاً Latest Topics.

## Source

wpForo PHP API.

Direct SQL ممنوع.

Public REST namespace اختصاصی wpForo در Production مشاهده نشد.

## Query strategy

بعد از initialization wpForo:

```php
WPF()->post->get_posts([
    'orderby'   => 'created',
    'order'     => 'DESC',
    'row_count' => 3,
    'status'    => 0,
]);
```

برای هر post:

- author → wpForo member API
- topic → `WPF()->topic->get_topic()`
- forum → `WPF()->forum->get_forum()`
- URL → از wpForo object/permalink helpers، نه manual DB URL در صورت وجود helper مناسب
- excerpt → body sanitize + trim

## Initialization rule

Adapter باید فقط بعد از `wpforo_core_inited` یا زمانی که wpForo objectها آماده‌اند اجرا شود.

## Privacy

قبل از Render باید wpForo view access روی Forum/Topic/Post رعایت شود.

Public Homepage نباید Private Forum activity را leak کند.

## Fallback

اگر wpForo unavailable بود:

- Section silently omit شود یا یک fallback link ساده به Community نشان داده شود.
- Homepage نباید Fatal Error دهد.

---

# 15. Latest Articles

Source:

WordPress Posts.

Preferred API:

```php
WP_Query
```

یا `get_posts()` برای Query ساده.

Query contract:

```text
post_type      = post
post_status    = publish
posts_per_page = 3
orderby        = date
order          = DESC
```

Fields:

- title
- permalink
- excerpt
- published date
- featured image
- featured image alt

Current public REST result با اولین Article Homepage تطابق دارد.

---

# 16. Support / Trust

Source:

Editorial configuration.

Phase 1:

- static verified copy
- no new CPT
- no new dependency

اگر Support destination CTA اضافه شود، URL باید از یک مشخصه WordPress page/permalink تولید شود؛ literal URL فقط در config مجاز است.

---

# 17. Testimonials

## Current source

Media Library images embedded through Elementor.

هیچ Testimonial CPT public در current type inventory مشاهده نشد.

## Phase 1 target

Curated Media Library Attachment IDs.

Config فقط Selection را نگه می‌دارد:

```php
$testimonial_attachment_ids = [ ... ];
```

و data adapter از WordPress Media API دریافت می‌کند:

- src
- srcset
- width/height
- alt

هیچ Testimonial text/name جدید از روی Image حدس زده نمی‌شود.

## Future option

اگر کاربر بعداً structured testimonials بخواهد، یک content model جدا طراحی می‌شود؛ در این Migration ایجاد نمی‌شود.

---

# 18. Contact Request architecture

این Section تنها قسمتی است که State Change دارد.

## Current source

Elementor Pro Form:

```text
page_id = 10
form_id = b25d804
field   = form_fields[name]
type    = tel
```

## Critical precondition

قبل از جایگزینی Submission backend باید در WordPress Admin به‌صورت Read-only مشخص شود Elementor Form Actions فعلی چیست:

- Email?
- Elementor Submissions?
- Webhook?
- Redirect?
- Other integration?

تا این inspection انجام نشده، Backend جدید نباید Production-ready اعلام شود.

## Target baseline

پس از مشخص‌شدن parity:

Native WordPress form handler، ترجیحاً:

```text
POST /wp-admin/admin-post.php
action=gpante_home_callback_request
```

Hooks:

```php
admin_post_gpante_home_callback_request
admin_post_nopriv_gpante_home_callback_request
```

## Validation

Server-side mandatory:

- trim
- normalize Persian/Arabic digits if accepted
- validate Iranian mobile format according to agreed rule
- reject empty value
- honeypot / basic abuse control
- rate limiting strategy before launch
- escape output messages

## Data handling

هیچ storage/email behavior جدیدی از خودمان اختراع نمی‌کنیم.

Target behavior باید با Elementor form actions فعلی parity داشته باشد.

---

# 19. Telegram / Community

Editorial config:

```text
channel = https://t.me/GPante_ir
group   = https://t.me/pante_group
```

Links external هستند.

No API call required.

---

# 20. JavaScript architecture

Baseline JS responsibilities:

1. Product tabs.
2. Fetch/render Best-selling products on first activation.
3. Mobile category toggle.
4. Optional contact form UX enhancement.

JavaScript نباید مسئول Initial Content Rendering باشد.

Search، Categories، Sale Products، Newest Products، Articles، Support و Telegram بدون JS قابل استفاده‌اند.

---

# 21. CSS / asset loading

Homepage CSS/JS فقط روی Front Page enqueue شوند.

Target:

```php
if ( is_front_page() ) {
    wp_enqueue_style(...);
    wp_enqueue_script(...);
}
```

Versioning در Development با `filemtime()` و در Release با build/version ثابت انجام شود.

## Important Elementor rule

Elementor/Elementor Pro assetها **فعلاً dequeue نمی‌شوند**.

چرا:

Header/Footer خارج از Scope هستند و هنوز تأیید نشده آیا Site Shell از Elementor dependency دارد یا خیر.

بعد از Custom Main Content:

1. Network asset inventory بگیریم.
2. مشخص کنیم کدام Elementor assets فقط به Page Body مربوط‌اند.
3. فقط assetهای اثبات‌شدهٔ غیرضروری را حذف کنیم.

---

# 22. Caching

Phase 1:

- custom transient cache اضافه نشود.
- existing LiteSpeed/Cloudflare/page caching حفظ شود.
- query-level caching فقط در صورت Benchmark evidence اضافه شود.

دلیل:

Caching اضافه بدون اندازه‌گیری، invalidation complexity ایجاد می‌کند.

Best-selling Store API tab از page HTML cache مستقل است.

---

# 23. SEO contract

Must preserve:

- Homepage URL
- H1 intent
- product search crawlable GET behavior
- category links
- shop/free CTA destinations
- Article internal links
- alt text
- no duplicate schema

SEO plugin فعلی باید مسئول metadata/schema باقی بماند مگر audit خلاف آن را ثابت کند.

---

# 24. Failure / empty states

| Data source | Failure behavior |
|---|---|
| WooCommerce unavailable | Product sections omit safely |
| No sale products | Special Offers omitted |
| Category missing | فقط همان card omit + QA warning |
| Store API bestseller failure | Newest remains visible + fallback Shop popularity link |
| wpForo unavailable | Q&A omitted/fallback link |
| No articles | Articles panel omitted |
| Missing testimonial image | Attachment omitted |
| Contact handler failure | Explicit user-safe error, no silent success |

Fatal error در هیچ Section قابل قبول نیست.

---

# 25. Security boundaries

- No direct SQL.
- No credentials in frontend.
- No authenticated WooCommerce REST keys for public Homepage data.
- Product Store API public endpoint only.
- Server output escaped with context-appropriate WordPress functions.
- Contact form state-changing request validated server-side.
- wpForo access checks respected.
- No private forum content leakage.
- No raw untrusted API HTML injection.

---

# 26. Performance budget direction

این‌ها Goal هستند، نه Result:

- no frontend framework
- no duplicate product libraries
- minimal homepage JS
- image dimensions explicit
- below-the-fold lazy loading
- no autoplay sliders
- no unnecessary loopback HTTP
- no duplicate Elementor body rendering

Actual gain فقط بعد از comparable benchmark گزارش می‌شود.

---

# 27. Implementation phases

## Phase A — Theme shell preflight

Read-only:

- inspect Woodmart parent/child templates
- confirm active theme
- check existing `front-page.php`
- check page template assignment
- determine Header/Footer Elementor dependency
- inspect current Homepage page settings

No writes.

## Phase B — Data adapters

Implement and test:

1. Hero/search config
2. Category adapter
3. Product normalizer
4. Sale products
5. Newest products
6. Articles
7. wpForo activity

Still no Production switch.

## Phase C — Static SSR components

Map v0.3 HTML/CSS to template-parts.

## Phase D — Best-selling Store API enhancement

Implement tab fetch with fallback.

## Phase E — Contact form parity audit

Authenticated read-only Admin inspection of Elementor form `b25d804`.

Then implement equivalent native handler.

## Phase F — Staging integration

- use existing Header/Footer
- run visual QA
- functional data checks
- SEO checks
- performance benchmark

## Phase G — Production migration

Only after explicit approval.

---

# 28. Rollback

Current Elementor Homepage must remain restorable.

Preferred rollback:

- revert custom page template assignment / feature switch
- restore previous Elementor body immediately
- no product/database migration is involved

Do not delete Elementor page data during initial production migration.

---

# 29. Architecture success criteria

Architecture is ready for Implementation when:

- Theme shell preflight is complete.
- All Section Data Sources are known.
- Q&A public access logic is verified.
- Product query semantics are accepted.
- Contact form side effects are known.
- No Header/Footer modification is required.
- Rollback path is tested.

At this point, all public Data Sources except Contact side effects and Theme template hierarchy are known.

---

# 30. Remaining read-only checks before coding

The public Theme/Template preflight is now substantially complete:

- Homepage Page ID 10 uses no assigned custom Page Template.
- No `front-page.php` was found in Child or Parent.
- No Child `page.php` was found.
- Parent `woodmart/page.php` exists and is the current template fallback path.
- Woodmart Parent version is 8.5.7.
- Woodmart Child version is 1.0.0 and contains live Homepage Q&A styling.

Only these authenticated read-only items remain:

1. Confirm exact active `stylesheet` / theme status.
2. Inspect Elementor Pro form `b25d804` action settings and destinations.
3. Confirm whether Header/Footer require Elementor runtime assets before any dequeue work.

Items 1 and 2 can be resolved with WP-CLI / WordPress authenticated read-only access. Item 3 can be resolved during staging asset/network validation.

The Contact backend must not be replaced before item 2 is known.

All non-contact homepage components can proceed to implementation planning from the documented public contracts.
