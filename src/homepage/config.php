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
            'title'    => 'طرح و فایل آماده برش لیزری و CNC از ایده تا تولید',
            'lead'     => 'طرح‌های آماده، فایل‌های رایگان، آموزش‌های تخصصی و خدمات طراحی اختصاصی را در پانته پیدا کنید؛ مجموعه‌ای برای طراحان، تولیدکنندگان و فعالان صنعت برش و ساخت.',
            'micro'    => [
                'دسترسی سریع به فایل‌ها',
                'دسته‌بندی تخصصی',
                'طراحی اختصاصی',
            ],
        ],

        // Keep the same editorial category order as the current public Homepage.
        'category_selection' => [
            [ 'slug' => 'laser-cut-stand-design' ],
            [ 'slug' => 'laser-cut-game-and-puzzle-file' ],
            [ 'slug' => 'box' ],
            [ 'slug' => 'light-and-lamp' ],
            [ 'slug' => 'قاب' ],
            [ 'slug' => 'laser-cut-office-organizer-design' ],
            [ 'slug' => 'home-and-office-decor' ],
            [ 'slug' => 'laser-cutting-vector' ],
        ],

        'promo_banners' => [
            [
                'kicker' => 'ویژه همکاران لیزرکار',
                'title'  => 'استعلام تعرفه و قیمت خدمات برش لیزری در سال 1405',
                'body'   => 'قیمت و اجرت خدمات برش لیزری فلزات و غیرفلزات',
                'url'    => home_url( '/تعرفه-و-هزینه-هر-دقیقه-برش-لیزری/' ),
                'tone'   => 'warm',
            ],
            [
                'kicker' => 'دانلود و راه‌اندازی',
                'title'  => 'نرم‌افزار مورد نیاز برای دستگاه برش لیزری',
                'body'   => 'نرم‌افزارهای مادربورد، درایورها، دیتاشیت و نقشه‌های مربوط به دستگاه‌ها',
                'url'    => home_url( '/required-software-laser-cutting-machine/' ),
                'tone'   => 'cool',
            ],
        ],

        'support' => [
            'title'     => 'با خیال راحت پشتیبانی دریافت کنید',
            'body'      => 'بعد از دریافت فایل اختصاصی یا خرید از سایت، مسیر دریافت راهنمایی و پشتیبانی برای شما باز است.',
            'image_url' => content_url( '/uploads/2019/12/home-page7.png' ),
        ],

        // Current public Homepage testimonial screenshots.
        // These are editorial/static media rather than generated testimonial copy.
        'testimonial_urls' => [
            'https://gpante.com/wp-content/uploads/elementor/thumbs/%D8%B1%D8%B6%D8%A7%DB%8C%D8%AA-%D9%85%D8%B4%D8%AA%D8%B1%DB%8C%D8%A7%D9%86-%DA%AF%D8%B1%D9%88%D9%87-%D9%BE%D8%A7%D9%86%D8%AA%D9%87-gpante.com-1-qaaewdtmtut8nh47upiej2967zbmeg7b69lwb6ql8g.jpg',
            'https://gpante.com/wp-content/uploads/elementor/thumbs/%D8%B1%D8%B6%D8%A7%DB%8C%D8%AA-%D9%85%D8%B4%D8%AA%D8%B1%DB%8C%D8%A7%D9%86-%DA%AF%D8%B1%D9%88%D9%87-%D9%BE%D8%A7%D9%86%D8%AA%D9%87-gpante.com-2-qaaewdtmtut8nh47upiej2967zbmeg7b69lwb6ql8g.jpg',
            'https://gpante.com/wp-content/uploads/elementor/thumbs/%D8%B1%D8%B6%D8%A7%DB%8C%D8%AA-%D9%85%D8%B4%D8%AA%D8%B1%DB%8C%D8%A7%D9%86-%DA%AF%D8%B1%D9%88%D9%87-%D9%BE%D8%A7%D9%86%D8%AA%D9%87-gpante.com-3-qaaewdtmtut8nh47upiej2967zbmeg7b69lwb6ql8g.jpg',
            'https://gpante.com/wp-content/uploads/elementor/thumbs/%D8%B1%D8%B6%D8%A7%DB%8C%D8%AA-%D9%85%D8%B4%D8%AA%D8%B1%DB%8C%D8%A7%D9%86-%DA%AF%D8%B1%D9%88%D9%87-%D9%BE%D8%A7%D9%86%D8%AA%D9%87-gpante.com-4-qaaewcvsn0rybv5l073rykhpmlg96r3ku4yetwrzeo.jpg',
            'https://gpante.com/wp-content/uploads/elementor/thumbs/%D8%B1%D8%B6%D8%A7%DB%8C%D8%AA-%D9%85%D8%B4%D8%AA%D8%B1%DB%8C-1-1-qaaewp3p3v8oisnu0udxczepcls0ytg37tfq2i9v5s.jpg',
            'https://gpante.com/wp-content/uploads/elementor/thumbs/%D8%B1%D8%B6%D8%A7%DB%8C%D8%AA-%D9%85%D8%B4%D8%AA%D8%B1%DB%8C-3-1-qaaewp3p3v8oisnu0udxczepcls0ytg37tfq2i9v5s.jpg',
            'https://gpante.com/wp-content/uploads/elementor/thumbs/%D8%B1%D8%B6%D8%A7%DB%8C%D8%AA-%D9%85%D8%B4%D8%AA%D8%B1%DB%8C-2-1-qaaewp3p3v8oisnu0udxczepcls0ytg37tfq2i9v5s.jpg',
        ],

        'contact' => [
            'eyebrow'   => 'و اگه به طراحی نیاز دارید..',
            'title'     => 'کافیه شماره موبایل خودتون رو وارد کنید تا باهاتون تماس بگیریم',
            'body'      => '',
            'image_url' => content_url( '/uploads/2019/12/home-page2-1024x1024.jpg' ),
        ],

        'telegram' => [
            'eyebrow'     => 'جامعه تخصصی پانته',
            'title'       => 'در تلگرام همراه پانته باشید',
            'body'        => 'در کانال پانته، تازه‌ترین آموزش‌ها، طرح‌ها، فایل‌ها و اطلاع‌رسانی‌های مرتبط با طراحی و برش لیزری را دنبال کنید. همچنین برای طرح پرسش، تبادل تجربه و گفت‌وگو با طراحان، تولیدکنندگان و فعالان این حوزه، به گروه تخصصی پانته بپیوندید.',
            'channel_url' => 'https://t.me/GPante_ir',
            'group_url'   => 'https://t.me/pante_group',
        ],
    ];

    return apply_filters( 'gpante_home_config', $config );
}
