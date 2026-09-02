# Custom Homepage Implementation

این پوشه Implementation واقعی Main Content صفحهٔ اصلی است.

## وضعیت

- Visual baseline: v0.3
- Data adapters: implemented
- SSR template parts: implemented
- WooCommerce Store API bestseller enhancement: implemented
- Contact persistence + email parity: implemented
- Production deployment: **not performed**

## Safe activation model

کد باید در `woodmart-child` قرار گیرد.

Bootstrap باید از `functions.php` Child Theme Load شود:

```php
require_once get_stylesheet_directory() . '/src/homepage/bootstrap.php';
```

اما Assets فقط زمانی Load می‌شوند که Homepage از این Page Template استفاده کند:

```text
templates/page-gpante-home.php
```

تا قبل از انتخاب این Template، Elementor Homepage فعلی بدون تغییر باقی می‌ماند.

## Staging file layout

فایل‌ها باید با همین ساختار داخل Child Theme قرار گیرند:

```text
woodmart-child/
├── functions.php
├── templates/
│   └── page-gpante-home.php
└── src/
    └── homepage/
        ├── bootstrap.php
        ├── config.php
        ├── render.php
        ├── data/
        ├── forms/
        ├── template-parts/
        └── assets/
```

## Private callback email configuration

مقصد Email نباید در Git ذخیره شود.

در محیط Staging/Production یکی از این روش‌ها باید استفاده شود:

```php
define( 'GPANTE_HOME_CALLBACK_EMAIL', 'PRIVATE_ADDRESS_HERE' );
```

یا Filter سمت سرور:

```php
add_filter( 'gpante_home_callback_recipient', function () {
    return 'PRIVATE_ADDRESS_HERE';
} );
```

مقدار واقعی باید از تنظیم فعلی Elementor به‌صورت خصوصی استخراج شود و در Repository Commit نشود.

## Contact storage

فرم جدید:

1. Nonce را بررسی می‌کند.
2. Honeypot دارد.
3. شماره‌های فارسی/عربی را Normalize می‌کند.
4. فرمت `09xxxxxxxxx` را Server-side Validate می‌کند.
5. Rate limit کوتاه بر اساس Hash شماره دارد.
6. Lead را در Post Type خصوصی `gpante_callback` ذخیره می‌کند.
7. Email notification را با `wp_mail()` می‌فرستد.
8. وضعیت ارسال Email را کنار Lead ذخیره می‌کند.

فقط Administrator به لیست درخواست‌ها در Tools دسترسی دارد.

## Testimonials

هیچ Testimonial ساختگی Render نمی‌شود.

در Staging باید Attachment ID تصاویر واقعی رضایت مشتریان در:

```php
testimonial_attachment_ids
```

داخل `config.php` یا از طریق Filter اضافه شود.

تا آن زمان Section Testimonials عمداً Render نمی‌شود.

## Rollback

Rollback اولیه:

1. Page Template صفحه اصلی را به `default` برگردان.
2. Elementor Main Content قبلی دوباره مسیر فعال صفحه می‌شود.
3. فایل‌ها و داده Elementor حذف نمی‌شوند.

در مرحله اول Deployment هیچ داده Elementor پاک نمی‌شود.

## Elementor assets

این Implementation هیچ Elementor asset را Dequeue نمی‌کند.

پس از Staging باید Network/visual regression بررسی کند Header/Footer به کدام assetهای Elementor وابسته‌اند. فقط assetهای اثبات‌شدهٔ غیرضروری می‌توانند در مرحله Performance optimization حذف شوند.
