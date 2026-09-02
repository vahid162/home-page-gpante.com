# Live Source Preflight — gpante.com Homepage

**Date:** 2026-09-02  
**Mode:** Public, read-only GET requests only  
**Production writes:** None  
**Authentication:** None

این سند فقط Factهای تأییدشده از سایت زنده را ثبت می‌کند. تصمیم‌های معماری در سند `homepage-integration-architecture.md` قرار دارند.

## 1. Scope

بررسی فقط برای تعیین Data Source و Integration Boundary صفحهٔ اصلی انجام شده است.

Header و Footer خارج از Scope پروژه هستند.

## 2. Confirmed platform signals

از HTML و REST public surface فعلی:

- WordPress فعال است.
- WooCommerce فعال است.
- WooCommerce Store API فعال و عمومی است.
- Elementor و Elementor Pro روی Homepage asset بارگذاری می‌کنند.
- wpForo روی بخش Community / Q&A فعال است.
- Theme assetهای `woodmart` و `woodmart-child` روی Homepage وجود دارند.
- WordPress REST API `wp/v2` فعال است.

Homepage plugin asset slugs مشاهده‌شده:

- `elementor`
- `elementor-pro`
- `woocommerce`
- `wpforo`
- `woo-wallet`
- `learn-soogh`

## 3. Homepage identity

فرم فعلی Elementor این مقادیر را از صفحه ارسال می‌کند:

- `post_id = 10`
- `queried_id = 10`

بنابراین Page ID فعلی Homepage در این Preflight برابر 10 مشاهده شد.

## 4. Hero product search — exact current contract

Search اصلی داخل Main Content:

- Method: `GET`
- Action: `https://gpante.com/`
- Query field: `s`
- Hidden field: `post_type=product`
- Input type: `search`
- Input id: `gpante-home-search`

پس رفتار فعلی Hero Search یک WordPress product search استاندارد است:

```text
/?s=<query>&post_type=product
```

این Contract در Migration باید حفظ شود مگر اینکه Requirement جدیدی صریحاً تصویب شود.

## 5. Current Hero CTA targets

### مشاهده همه طرح‌ها

مقصد فعلی:

```text
https://gpante.com/shop/
```

### فایل‌های رایگان

مقصد فعلی عملاً یک Product Search برای عبارت «رایگان» است:

```text
/?post_type=product&s=رایگان
```

## 6. Product category sources

Category Cardهای فعلی به WooCommerce `product_cat` متصل‌اند.

Route pattern:

```text
/product-category/laser-cutting-design/<category-slug>/
```

Slug/Pathهای تأییدشده از لینک‌های فعلی:

- استند لیزری → `laser-cut-stand-design`
- بازی و سرگرمی و پازل → `laser-cut-game-and-puzzle-file`
- جعبه و باکس → `box`
- روشنایی → `light-and-lamp`
- مجموعه قاب‌ها → `قاب` (URL-encoded in permalink)
- لوازم اداری، تبلیغاتی و تحریر → `laser-cut-office-organizer-design`
- مجموعه دکوری خانه و اداره → `home-and-office-decor`
- وکتور برش لیزری → `laser-cutting-vector`

تعدادهای نمایش‌داده‌شده نباید Static تلقی شوند. Count باید در زمان Render از WooCommerce taxonomy data گرفته شود.

## 7. WooCommerce public product data

این Endpoint روی Production با HTTP 200 تأیید شد:

```text
/wp-json/wc/store/v1/products
```

و Category endpoint نیز فعال است:

```text
/wp-json/wc/store/v1/products/categories
```

Store API product response فعلی شامل داده‌هایی مانند این‌ها است:

- id
- name
- slug
- permalink
- short_description
- on_sale
- prices
- price_html
- images
- categories
- tags
- attributes
- purchasability / stock flags
- add-to-cart metadata

این Endpoint public و بدون API key است.

## 8. Latest articles

WordPress REST endpoint فعال است:

```text
/wp-json/wp/v2/posts
```

اولین Post در Read-only Preflight همان مقاله‌ای بود که در بخش «جدیدترین مقاله‌ها» Homepage نمایش داده می‌شود.

پس منبع بخش Articles، WordPress Posts استاندارد است.

## 9. Q&A / Community

مسیر فعلی:

```text
/community/questions/
```

Assetهای این صفحه حضور `wpforo` را تأیید می‌کنند.

در public REST namespace list، namespace اختصاصی wpForo مشاهده نشد.

بنابراین Q&A نباید بر مبنای یک REST endpoint فرضی wpForo طراحی شود.

صفحهٔ فعلی Homepage در این بخش هم Question و هم Answer/Reply نمایش می‌دهد؛ بنابراین رفتار فعلی بیشتر شبیه **Recent Forum Activity / Recent Posts** است تا فقط Latest Topics.

## 10. Contact / callback form — exact current contract

فرم فعلی:

- Provider: Elementor Pro Form
- CSS class: `elementor-form`
- Method: `POST`
- HTML action: empty
- Homepage post id: `10`
- Form id: `b25d804`
- Visible field type: `tel`
- Visible field name: `form_fields[name]`
- Visible field id: `form-field-name`
- Placeholder: `09`

Hidden fields observed:

- `post_id`
- `form_id`
- `referer_title`
- `queried_id`

Public HTML does **not** reveal all Elementor Form Actions configured in the editor (for example email, webhook, submissions, etc.).

قبل از جایگزینی Backend این فرم، یک authenticated read-only admin inspection لازم است.

## 11. Testimonials

در Homepage فعلی Testimonials به‌صورت Image asset نمایش داده می‌شوند.

در exposed WordPress post types فعلی، Testimonial CPT اختصاصی مشاهده نشد.

بنابراین Source فعلی به احتمال بسیار بالا Media Library images / Elementor content است، نه یک structured testimonial content type.

برای Implementation نباید نام یا متن Testimonial جدید ساخته شود.

## 12. Telegram CTA

لینک‌های فعلی تأییدشده:

- Channel: `https://t.me/GPante_ir`
- Group: `https://t.me/pante_group`

## 13. Items not confirmed by public preflight

موارد زیر هنوز به Read-only inspection داخل WordPress/Admin یا server files نیاز دارند:

- Active child-theme template hierarchy و اینکه Woodmart دقیقاً Homepage shell را چگونه Render می‌کند.
- اینکه Header یا Footer به Elementor/Elementor Pro asset نیاز دارند یا خیر.
- Elementor Form Actions برای form id `b25d804`.
- مقصد Email/Webhook/Submission storage فرم فعلی.
- Plugin/theme code فعلی که Recent wpForo activity را روی Homepage Render می‌کند.
- روش فعلی دقیق query برای Special Offers و Best-selling products.

این موارد نباید حدس زده شوند.
