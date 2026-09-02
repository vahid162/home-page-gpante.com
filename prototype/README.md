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
