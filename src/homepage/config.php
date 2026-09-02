<?php
/**
 * Homepage editorial configuration.
 *
 * Dynamic product/category/post data must not be stored here.
 */

defined( 'ABSPATH' ) || exit;

function gpante_home_config(): array {
    $config = [
        'hero' => [
            'eyebrow' => 'طراحی برای تولید، نه فقط نمایش',
            'title'    => 'طرح و فایل آماده برش لیزری و CNC، از ایده تا تولید',
            'lead'     => 'طرح‌های آماده، فایل‌های رایگان، آموزش‌های تخصصی و خدمات طراحی اختصاصی را سریع‌تر پیدا کنید؛ با تمرکز بر فایل‌هایی که برای ساخت واقعی آماده شده‌اند.',
            'micro'    => [
                'دسترسی سریع به فایل‌ها',
                'دسته‌بندی تخصصی',
                'طراحی برای ساخت واقعی',
            ],
        ],
        'category_selection' => [
            [ 'slug' => 'box', 'icon' => '▣' ],
            [ 'slug' => 'laser-cut-stand-design', 'icon' => '◇' ],
            [ 'slug' => 'laser-cut-game-and-puzzle-file', 'icon' => '✦' ],
            [ 'slug' => 'home-and-office-decor', 'icon' => '⌂' ],
            [ 'slug' => 'laser-cutting-vector', 'icon' => 'A' ],
            [ 'slug' => 'light-and-lamp', 'icon' => '☼' ],
            [ 'slug' => 'laser-cut-office-organizer-design', 'icon' => '▤' ],
            [ 'slug' => 'قاب', 'icon' => '▱' ],
        ],
        'value_propositions' => [
            [ 'icon' => '↓', 'title' => 'دانلود سریع', 'body' => 'مسیر دریافت فایل کوتاه و واضح باشد.' ],
            [ 'icon' => '✓', 'title' => 'فایل‌های استاندارد', 'body' => 'فرمت و مشخصات فایل قبل از خرید شفاف باشد.' ],
            [ 'icon' => '✎', 'title' => 'طراحی اختصاصی', 'body' => 'وقتی فایل آماده کافی نیست، مسیر سفارش مشخص باشد.' ],
            [ 'icon' => '?', 'title' => 'پشتیبانی تخصصی', 'body' => 'راهنمایی بعد از خرید از بخش فروش جدا و قابل فهم باشد.' ],
        ],
        'support' => [
            'eyebrow' => 'بعد از خرید هم مسیر روشن بماند',
            'title'    => 'پشتیبانی باید بخشی از تجربه خرید باشد، نه یک بخش فراموش‌شده',
            'body'     => 'برای فایل‌های خریداری‌شده و سفارش‌های طراحی، مسیر دریافت راهنمایی باید روشن، سریع و قابل پیدا کردن باشد.',
            'points'   => [
                [ 'number' => '01', 'title' => 'مسیر دریافت فایل', 'body' => 'شفاف و بدون ابهام' ],
                [ 'number' => '02', 'title' => 'راهنمای استفاده', 'body' => 'در جای درست و قابل پیدا کردن' ],
                [ 'number' => '03', 'title' => 'تماس تخصصی', 'body' => 'برای نیازهای طراحی و تولید' ],
            ],
        ],
        // Populate with real Media Library attachment IDs during staging.
        'testimonial_attachment_ids' => [],
        'telegram' => [
            'channel_url' => 'https://t.me/GPante_ir',
            'group_url'   => 'https://t.me/pante_group',
        ],
        'contact' => [
            'title' => 'فایل مناسب پیدا نکردید؟ درباره طراحی اختصاصی صحبت کنیم',
            'body'  => 'شماره تماس خود را ثبت کنید تا برای بررسی نیاز طراحی و راهنمایی بیشتر با شما تماس گرفته شود.',
        ],
    ];

    return apply_filters( 'gpante_home_config', $config );
}
