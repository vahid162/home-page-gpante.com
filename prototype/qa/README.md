# Prototype Visual QA

این پوشه برای تست خودکار Prototype صفحه اصلی است.

## چرا این روش اضافه شد؟

محیط‌های اجرایی مختلف ممکن است دسترسی مستقیم Browser به GitHub یا اینترنت را محدود کنند. Visual QA نباید به آن دسترسی وابسته باشد.

Workflow فایل‌های Repository را داخل GitHub Actions Checkout می‌کند و همان نسخه Commit‌شده را به‌صورت Local با Chromium Render می‌کند.

## چه چیزهایی بررسی می‌شوند؟

در سه Viewport:

- Desktop: 1440×1000
- Tablet: 820×1180
- Mobile: 390×844

تست‌های پایه:

- نبود Horizontal Overflow در کل صفحه.
- وجود H1.
- نبود Header و Footer در Scope Prototype.
- نبود JavaScript error ثبت‌شده.
- عملکرد Tab جدیدترین/پرفروش‌ترین.
- Validation نمایشی فرم تماس.
- عملکرد نمایش دسته‌های بیشتر در Mobile.
- حذف Visual تزئینی Hero در Mobile.

## خروجی

Workflow یک Artifact با نام زیر تولید می‌کند:

`prototype-visual-qa`

شامل:

- `desktop.png`
- `tablet.png`
- `mobile.png`
- `report.json`

Screenshotها Full-page هستند.

## نکته

Playwright فقط Dependency محیط CI است. هیچ Dependency جدیدی به Prototype یا Production اضافه نمی‌شود.
