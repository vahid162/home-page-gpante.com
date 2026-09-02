# Homepage Prototype

این پوشه Prototype مستقل Main Content صفحه اصلی gpante.com است.

## Scope

- فقط Main Content.
- Header و Footer در این Prototype وجود ندارند.
- هیچ اتصال واقعی به WordPress یا WooCommerce وجود ندارد.
- هیچ فرم یا داده‌ای به Production ارسال نمی‌شود.

## اجرا

فایل `index.html` را در مرورگر باز کنید.

برای رفتار قابل‌اعتمادتر می‌توان از یک HTTP server محلی استفاده کرد، برای مثال:

```bash
python -m http.server 8080 -d prototype
```

سپس:

```text
http://localhost:8080/
```

## فایل‌ها

- `index.html`: ساختار Semantic و محتوای Mock.
- `styles.css`: Design tokens، Layout، RTL و Responsive.
- `app.js`: رفتار Tabها، نمایش بیشتر دسته‌ها و Validation نمایشی فرم تماس.

## نکته

تمام قیمت‌ها، تعدادها، نام محصولات، پرسش‌ها، مقاله‌ها و Testimonials این Prototype نمونه طراحی هستند و نباید به‌عنوان داده واقعی Production استفاده شوند.

پس از تأیید Visual Direction، مرحله بعد اتصال Componentها به WordPress/WooCommerce و جایگزینی Mock Data با داده واقعی است.


## Visual review v0.2

در بازبینی دوم Prototype این اصلاح‌ها اعمال شدند:

- Hero کوتاه‌تر و Focus بیشتر روی H1 و Search.
- حذف Visual تزئینی Hero در Mobile برای کاهش ارتفاع Above-the-fold.
- اصلاح H1 و CTAها برای نزدیکی بیشتر به محتوای واقعی سایت.
- فارسی‌سازی Labelهای انگلیسی داخل Sectionها.
- کاهش فاصله عمودی Sectionها.
- یک‌ستونه شدن Value Proposition در Mobile.
- فشرده‌تر شدن Product Cardها در Mobile.
- یک‌دست شدن ارتفاع و ساختار Product Cardها در Desktop.
- بهبود Typography و text wrapping.
- کاهش شلوغی Community CTA در Mobile.

این مرحله هنوز Visual Prototype است و Data Source واقعی متصل نشده است.


## Visual review v0.3

این نسخه بر اساس Screenshot واقعی Desktop / Tablet / Mobile اصلاح شد.

اصلاح‌های اصلی:

- Hero در Tablet از حالت دو ستونه فشرده خارج شد و به Layout خواناتر تبدیل شد.
- متن‌های توسعه‌ای داخل UI با Copy واقعی‌تر و مناسب Visual Review جایگزین شدند.
- Special Offers در Mobile از Carousel نیمه‌بریده به دو Card فشرده و عمودی تبدیل شد.
- Testimonials در Mobile از Carousel به Cardهای عمودی محدود تبدیل شد.
- ریتم عمودی و تراکم اطلاعات در Mobile کاهش یافت.
- Header و Footer همچنان خارج از Scope هستند.
- هیچ اتصال WordPress/WooCommerce اضافه نشده است.
