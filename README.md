# بازطراحی محتوای صفحه اصلی gpante.com

این مخزن برای بازطراحی و پیاده‌سازی **محتوای اصلی صفحهٔ اول gpante.com** با کدنویسی اختصاصی ایجاد شده است.

هدف پروژه حذف وابستگی محتوای صفحهٔ اصلی به Elementor و جایگزینی آن با یک پیاده‌سازی سبک‌تر، قابل‌کنترل‌تر و قابل‌نگهداری‌تر است؛ در عین حال WordPress و WooCommerce به‌عنوان هستهٔ مدیریت محتوا و فروشگاه حفظ می‌شوند.

## محدوده پروژه

### داخل محدوده

- فقط Main Content صفحهٔ اصلی.
- طراحی و پیاده‌سازی بخش‌های محتوایی صفحهٔ اصلی.
- اتصال بخش‌های پویا به WordPress و WooCommerce.
- طراحی Responsive برای موبایل، تبلت و دسکتاپ.
- رعایت RTL و زبان فارسی.
- بهینه‌سازی Performance.
- حفظ یا بهبود SEO.
- رعایت Accessibility.
- کاهش وابستگی صفحهٔ اصلی به Elementor.
- استفاده از PHP، HTML، CSS و JavaScript اختصاصی و حداقلی.

### خارج از محدوده

موارد زیر در این پروژه نباید تغییر کنند، مگر اینکه بعداً به‌صورت صریح به Scope اضافه شوند:

- Header سایت.
- Footer سایت.
- منوی اصلی و ساختار Navigation.
- صفحات محصول.
- صفحات دسته‌بندی محصولات.
- صفحات فروشگاه WooCommerce.
- صفحات وبلاگ و مقالات.
- حذف Elementor از کل سایت.
- تغییر WordPress یا WooCommerce.
- تغییر مستقیم سایت Production بدون مرحلهٔ تست و تأیید.

**Header و Footer باید دقیقاً خارج از محدودهٔ این پروژه باقی بمانند.**

## هدف معماری

معماری موردنظر به این شکل است:

WordPress و WooCommerce همچنان مسئول مدیریت داده‌ها هستند و فقط لایهٔ نمایش محتوای صفحهٔ اصلی از Elementor جدا می‌شود.

ساختار هدف:

- WordPress: حفظ می‌شود.
- WooCommerce: حفظ می‌شود.
- محصولات و دسته‌بندی‌ها: همچنان از پنل مدیریت می‌شوند.
- قیمت و تخفیف: از WooCommerce خوانده می‌شود.
- مقالات: از WordPress خوانده می‌شوند.
- اطلاعات پویا: Hard-code نمی‌شوند.
- Elementor: فقط از Main Content صفحهٔ اصلی حذف می‌شود.
- Header و Footer فعلی: بدون تغییر باقی می‌مانند.

هدف این نیست که یک نسخهٔ HTML ثابت از صفحه بسازیم.

## وضعیت فعلی

در زمان ایجاد مستندات اولیه، صفحهٔ اصلی سایت با WordPress، WooCommerce و Elementor کار می‌کند.

این مخزن فعلاً در مرحلهٔ:

1. مستندسازی
2. Inventory
3. بررسی معماری
4. تعیین Requirement
5. تعیین Baseline
6. طراحی مرحله‌ای

قرار دارد.

هنوز پیاده‌سازی نهایی صفحهٔ اصلی آغاز نشده است.

## Inventory اولیه محتوای صفحهٔ اصلی

بر اساس بررسی نسخهٔ فعلی سایت، Main Content شامل بخش‌هایی مانند موارد زیر است:

1. Hero و معرفی اصلی.
2. جست‌وجوی صفحهٔ اصلی.
3. دسته‌بندی طرح‌ها و محصولات برش لیزری.
4. محصولات دارای تخفیف.
5. محصولات جدید.
6. محصولات پرفروش.
7. Calloutها و بخش‌های خدماتی.
8. جدیدترین پرسش و پاسخ‌ها.
9. جدیدترین مقالات.
10. بخش پشتیبانی.
11. نظرات و رضایت مشتریان.
12. فرم درخواست تماس.
13. معرفی جامعه و کانال تلگرام.

این فهرست یک Inventory اولیه است و قبل از پیاده‌سازی هر Section باید رفتار، منبع داده و Requirement دقیق آن بررسی شود.

## اصل مهم: داده‌ها Hard-code نمی‌شوند

یکی از اهداف اصلی این پروژه این است که فروشگاه همچنان از طریق WordPress و WooCommerce مدیریت شود.

برای مثال موارد زیر نباید به‌صورت ثابت در Template نوشته شوند:

- نام محصول.
- قیمت محصول.
- قیمت تخفیف‌خورده.
- تصویر محصول.
- وضعیت تخفیف.
- لینک محصول.
- تعداد محصولات یک دسته‌بندی.
- فهرست محصولات جدید.
- فهرست محصولات پرفروش.

در صورت پویا بودن این اطلاعات، داده باید از APIها و توابع استاندارد WordPress/WooCommerce دریافت شود.

## چرا Elementor را فقط از صفحهٔ اصلی حذف می‌کنیم؟

هدف فعلی حذف کامل Elementor از سایت نیست.

مهاجرت مرحله‌ای مزایای زیر را دارد:

- Risk کمتر.
- امکان مقایسه نسخهٔ فعلی و نسخهٔ جدید.
- Rollback ساده‌تر.
- امکان Benchmark واقعی.
- کاهش احتمال ایجاد Regression در سایر صفحات.
- امکان توسعه و تست Section به Section.

بنابراین در این فاز:

**Homepage Main Content = Custom Code**

و سایر بخش‌های سایت فعلاً بدون تغییر باقی می‌مانند.

## Performance

یکی از دلایل اصلی این پروژه افزایش کنترل روی Performance است.

در نسخهٔ اختصاصی تلاش می‌شود:

- DOM کوچک‌تر باشد.
- Wrapperهای غیرضروری حذف شوند.
- CSS فقط در صورت نیاز Load شود.
- JavaScript تا حد ممکن کم باشد.
- Dependencyهای غیرضروری اضافه نشوند.
- تصاویر بهینه شوند.
- Layout Shift کاهش پیدا کند.
- منابع Render Blocking کاهش پیدا کنند.
- فقط Assetهای موردنیاز صفحه بارگذاری شوند.

اما هیچ عدد یا درصدی برای افزایش سرعت از قبل تضمین نمی‌شود.

Performance باید با Benchmark قبل و بعد اندازه‌گیری شود.

Metricهای مهم:

- LCP
- CLS
- INP
- Lighthouse/PageSpeed diagnostics
- تعداد و حجم CSS و JavaScript
- اندازه و پیچیدگی DOM

## SEO

مهاجرت از Elementor نباید باعث افت SEO شود.

در طول بازطراحی باید موارد زیر حفظ یا بهبود پیدا کنند:

- URL صفحهٔ اصلی.
- محتوای قابل Crawl.
- H1 و ساختار Headingها.
- لینک‌های داخلی.
- Alt تصاویر.
- Metadata.
- Canonical.
- Schema و Structured Data موجود.
- Mobile usability.
- Core Web Vitals.

قبل از اضافه‌کردن Schema جدید باید بررسی شود که WordPress، WooCommerce یا افزونهٔ SEO فعلی آن را قبلاً تولید نمی‌کنند.

## Accessibility

صفحهٔ جدید باید حداقل الزامات زیر را رعایت کند:

- امکان استفاده با Keyboard.
- Focus قابل مشاهده.
- Label صحیح فرم‌ها.
- Contrast مناسب.
- ساختار Semantic HTML.
- استفاده صحیح از Button و Link.
- پشتیبانی از prefers-reduced-motion برای Animationهای غیرضروری.
- قابل استفاده بودن Tab، Slider و سایر Componentهای تعاملی بدون Mouse.

## Responsive و RTL

صفحه باید به‌صورت کامل برای فارسی و RTL طراحی شود.

حداقل Viewportهای مورد بررسی:

- موبایل کوچک.
- موبایل بزرگ.
- تبلت.
- دسکتاپ.
- نمایشگر عریض.

مواردی مانند Horizontal Overflow، ترتیب عناصر، فاصله‌ها، Typography، اندازه تصاویر و Touch Targetها باید در هر اندازه بررسی شوند.

## تکنولوژی‌های پیشنهادی

اصل اولیه پروژه این است که تا حد امکان از Stack موجود WordPress استفاده شود:

- PHP
- WordPress APIs
- WooCommerce APIs
- HTML5
- CSS
- JavaScript بومی مرورگر

افزودن Framework یا Library جدید باید دلیل فنی مشخص داشته باشد.

به‌صورت پیش‌فرض قرار نیست React، Vue، Bootstrap، Tailwind یا کتابخانه‌های سنگین Front-end فقط برای ساخت صفحهٔ اصلی اضافه شوند.

## روش اجرای پروژه

پروژه به‌صورت مرحله‌ای اجرا می‌شود.

### فاز 1 — Baseline و Inventory

- ثبت ساختار فعلی صفحه.
- مشخص‌کردن Sectionها.
- مشخص‌کردن Data Source هر Section.
- ثبت رفتار Desktop/Mobile.
- ثبت Interactionها.
- Benchmark نسخه فعلی.

### فاز 2 — Architecture

- تعیین ساختار فایل‌ها.
- تعیین Template مورد استفاده.
- تعیین روش Query داده‌های WooCommerce.
- تعیین Asset loading.
- تعیین Component boundaries.
- تعیین Strategy برای CSS و JavaScript.

### فاز 3 — Prototype

ابتدا یک نسخهٔ مستقل و قابل مقایسه ساخته می‌شود.

در این مرحله صفحهٔ فعلی Production نباید حذف شود.

### فاز 4 — پیاده‌سازی Section به Section

هر Section جداگانه:

1. Requirement
2. Data source
3. HTML structure
4. CSS
5. Interaction
6. Responsive test
7. Accessibility test
8. Performance check

خواهد داشت.

### فاز 5 — Integration

Sectionها در Template نهایی Homepage ترکیب می‌شوند.

### فاز 6 — Validation

- Visual comparison.
- Functional testing.
- WooCommerce integration test.
- Responsive test.
- SEO check.
- Accessibility check.
- Performance benchmark.

### فاز 7 — Deployment

نسخه جدید تنها بعد از تأیید تست‌ها جایگزین Main Content فعلی می‌شود.

## معیار موفقیت

پروژه زمانی موفق محسوب می‌شود که:

- Header بدون تغییر باقی بماند.
- Footer بدون تغییر باقی بماند.
- قابلیت‌های ضروری Main Content حفظ شوند.
- محصولات و اطلاعات فروشگاه همچنان از WooCommerce مدیریت شوند.
- Main Content صفحهٔ اصلی برای عملکرد خود به Elementor وابسته نباشد، مگر در یک استثنای مستند و تأییدشده.
- RTL و Responsive صحیح باشند.
- SEO دچار Regression مهم نشود.
- Accessibility دچار Regression بحرانی نشود.
- Performance با شرایط قابل مقایسه اندازه‌گیری شده باشد.
- کد قابل نگهداری و توسعه باشد.
- Rollback به نسخهٔ قبلی امکان‌پذیر باشد.

## Rollback

قبل از جایگزینی نسخه فعلی باید:

- نسخه Elementor صفحهٔ اصلی حفظ شود.
- Backup یا Revision قابل بازیابی وجود داشته باشد.
- نسخه جدید ابتدا در محیط امن تست شود.
- روش بازگشت به صفحهٔ قبلی مشخص باشد.

تا زمانی که نسخه جدید Validation نشده، نسخه قبلی نباید حذف شود.

## قوانین همکاری با هوش مصنوعی

قواعد کامل AI Agentها در فایل [AGENTS.md](./AGENTS.md) قرار دارد.

مهم‌ترین اصول:

- AI نباید بدون بررسی وارد کدنویسی گسترده شود.
- Fact و Assumption باید از هم جدا شوند.
- رفتار فعلی سایت نباید حدس زده شود.
- قبل از تغییرات حساس، ابتدا بررسی Read-only انجام شود.
- تغییرات باید کوچک، قابل تست و قابل Rollback باشند.
- Header و Footer خارج از Scope هستند.
- اطلاعات پویا نباید بی‌دلیل Hard-code شوند.
- هیچ ادعای Performance بدون Benchmark پذیرفته نیست.

## لینک‌ها

- سایت اصلی: https://gpante.com/
- مخزن پروژه: https://github.com/vahid162/home-page-gpante.com

## وضعیت پروژه

**Current phase: Documentation / Discovery / Architecture**

گام بعدی پیشنهادی، تهیهٔ Inventory دقیق Section به Section از Main Content فعلی و تعیین Data Source و Acceptance Criteria برای هر بخش است.
