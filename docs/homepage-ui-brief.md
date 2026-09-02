# UI Brief — Main Content صفحه اصلی gpante.com

**نسخه:** 0.1  
**وضعیت:** Draft for design review  
**محدوده:** فقط Main Content صفحه اصلی  
**خارج از محدوده:** Header و Footer

---

## 1. هدف این سند

این سند مشخص می‌کند Main Content صفحه اصلی `gpante.com` در بازطراحی جدید چگونه باید سازمان‌دهی و طراحی شود.

هدف، ساخت یک نسخه صرفاً زیباتر نیست. نسخه جدید باید:

- از نسخه فعلی مدرن‌تر و منظم‌تر باشد.
- برای فارسی و RTL طراحی شود.
- در Desktop، Tablet و Mobile یک Design System هماهنگ داشته باشد.
- مسیر پیدا کردن و خرید فایل را ساده‌تر کند.
- محتوای پویا را از WordPress و WooCommerce دریافت کند.
- برای Performance، SEO، Accessibility و نگهداری بهتر آماده باشد.
- بدون وابستگی Main Content به Elementor قابل پیاده‌سازی باشد.

این سند هنوز Specification نهایی کدنویسی نیست. قبل از Implementation باید Data Source واقعی و رفتار فنی هر بخش تأیید شود.

---

# 2. Design Direction

## 2.1 شخصیت بصری پیشنهادی

جهت بصری پیشنهادی:

- Modern
- Minimal
- Industrial
- Precise
- Professional
- Trustworthy
- Lightweight

صفحه نباید بیش از حد شلوغ، تزئینی یا شبیه Marketplaceهای عمومی باشد.

پانته یک سایت تخصصی برای فایل‌های طراحی، برش لیزری، CNC، تولید و آموزش است. بنابراین طراحی باید حس «ابزار حرفه‌ای و تخصصی» بدهد، نه فقط فروشگاه عمومی.

---

## 2.2 اصول بصری

- فضای خالی کافی بین Sectionها.
- Cardهای ساده با Radius کنترل‌شده.
- Shadow بسیار ملایم یا بدون Shadow سنگین.
- Borderهای ظریف برای تفکیک Componentها.
- Typography واضح و خوانا.
- Heading hierarchy مشخص.
- استفاده محدود و هدفمند از Accent Color برند.
- Backgroundهای خنثی برای جلوگیری از شلوغی.
- آیکون‌های ساده و یک‌دست.
- تصاویر محصولات باید نقش اصلی را داشته باشند.
- CTA اصلی باید از CTA ثانویه واضح‌تر باشد.

---

# 3. Responsive Strategy

سه Layout نباید سه طراحی مستقل باشند.

یک Component باید در هر سه اندازه همان هویت، محتوا و رفتار اصلی را حفظ کند و فقط Layout آن تغییر کند.

## Desktop

هدف:

- استفاده مناسب از عرض صفحه.
- نمایش چند محصول یا دسته هم‌زمان.
- کاهش Scroll عمودی غیرضروری.
- استفاده از Gridهای چندستونه.

پیشنهاد پایه:

- Content container حداکثر حدود 1200 تا 1320px.
- Section spacing بزرگ‌تر.
- Product Grid حدود 4 تا 5 ستون، بسته به عرض واقعی Card.
- Category Grid حدود 4 تا 6 ستون.
- Q&A و Articles می‌توانند کنار هم نمایش داده شوند.

## Tablet

هدف:

- حفظ ساختار Desktop با تراکم کمتر.
- جلوگیری از کوچک‌شدن بیش از حد Cardها.

پیشنهاد پایه:

- Product Grid حدود 2 تا 3 ستون.
- Category Grid حدود 3 تا 4 ستون.
- Hero فشرده‌تر.
- Q&A و Articles بسته به عرض می‌توانند دو ستون محدود یا Stack شوند.

## Mobile

هدف:

- خوانایی.
- لمس آسان.
- تصمیم‌گیری سریع.
- حداقل پیچیدگی.

پیشنهاد پایه:

- Layout اصلی یک‌ستونه.
- Categoryها در 2 ستون یا Horizontal Scroll کنترل‌شده.
- Productها به Cardهای عمودی یا Horizontal Compact Cards تبدیل شوند.
- CTAها تقریباً Full-width باشند.
- Sectionهای کم‌اولویت می‌توانند خلاصه شوند.
- Touch target حداقل حدود 44px باشد.
- هیچ Horizontal Overflow ناخواسته وجود نداشته باشد.

---

# 4. Design System اولیه

این مقادیر هنوز Token نهایی نیستند و در مرحله Prototype باید تنظیم شوند.

## Spacing

پیشنهاد:

- فاصله داخلی Component کوچک: 8–12px
- فاصله داخلی Card: 16–24px
- فاصله بین Cardها: 12–24px
- فاصله بین Sectionها:
  - Mobile: حدود 40–56px
  - Tablet: حدود 56–72px
  - Desktop: حدود 64–96px

## Radius

پیشنهاد:

- Input / Button: 10–14px
- Card: 14–20px
- Hero / Major CTA panel: 20–28px

نباید Radius بیش از حد استفاده شود.

## Typography

باید از Font موجود سایت یا Font تأییدشده پروژه استفاده شود.

Hierarchy اولیه:

- H1: بزرگ، Bold و فشرده.
- H2: عنوان اصلی Section.
- H3: عنوان Card/Product.
- Body: خوانا با Line-height مناسب فارسی.
- Metadata: کوچک‌تر ولی قابل خواندن.

## Motion

- Animation فقط در صورت ایجاد ارزش UX.
- Duration کوتاه.
- بدون Motion تزئینی سنگین.
- رعایت `prefers-reduced-motion`.
- Hoverهای Desktop نباید Interaction ضروری باشند.

---

# 5. Information Architecture پیشنهادی

ترتیب اولیه پیشنهادی Main Content:

1. Hero + Search
2. Categories
3. Special Offers
4. Newest / Best-selling Products
5. Value Propositions / Service Highlights
6. Q&A + Articles
7. Support / Trust
8. Testimonials
9. Contact Request
10. Telegram Community

این ترتیب بر اساس مسیر کاربر تنظیم شده است:

**Discover → Search/Browse → Evaluate → Trust → Learn → Contact/Join**

---

# 6. Section 01 — Hero + Search

## هدف

در اولین Viewport باید کاربر سریع متوجه شود:

- پانته چه چیزی ارائه می‌کند.
- آیا فایل مورد نظر او قابل جست‌وجو است.
- قدم بعدی چیست.

## اولویت

**Critical / P0**

## محتوای لازم

- Eyebrow کوتاه.
- H1.
- Supporting text کوتاه.
- Search input.
- Primary CTA.
- Secondary CTA.
- حداکثر سه Trust/Value micro-points.

## UI پیشنهادی

Desktop:

- Hero دو ناحیه‌ای.
- متن و Search در سمت RTL اصلی.
- Illustration یا Visual مرتبط در سمت دیگر.
- Search باید عنصر غالب Section باشد.

Tablet:

- Illustration کوچک‌تر.
- Search عرض بیشتری نسبت به متن فرعی داشته باشد.

Mobile:

- Stack کامل.
- Illustration می‌تواند حذف یا بسیار کوچک شود اگر باعث طولانی‌شدن Above-the-fold شود.
- CTAها Full-width یا نزدیک به Full-width.

## Interaction

- Search submit با Enter.
- Search button.
- CTA «مشاهده همه طرح‌ها».
- CTA «فایل‌های رایگان».

## رفتار مورد انتظار

Search باید مقصد و نوع Query مشخصی داشته باشد.

**[نیاز به تأیید فنی]** آیا Search فعلی فقط Product را جست‌وجو می‌کند یا کل سایت را.

## Acceptance Criteria

- H1 واضح و تنها H1 اصلی Main Content باشد.
- Search بدون JavaScript نیز تا حد ممکن قابل استفاده باشد.
- Keyboard accessible باشد.
- Input label یا accessible name صحیح داشته باشد.
- در Mobile عنصر اصلی بدون Zoom یا Overflow قابل استفاده باشد.
- Visual باعث تأخیر غیرضروری LCP نشود.
- Hero در Viewport اولیه بیش از حد ارتفاع نگیرد.

---

# 7. Section 02 — Categories

## هدف

کاربری که نام دقیق فایل را نمی‌داند بتواند با Browse کردن دسته‌ها سریع وارد مسیر مناسب شود.

## اولویت

**High / P1**

## محتوای لازم برای هر Category

- Icon یا Thumbnail.
- نام دسته.
- تعداد محصولات، در صورت قابل اعتماد بودن Query.
- Link.

## UI پیشنهادی

Desktop:

- Grid چندستونه.
- Cardهای هم‌اندازه.
- Icon ساده + عنوان + Count.

Tablet:

- Grid 3 یا 4 ستونه.

Mobile:

- Grid دو ستونه.
- فقط تعداد محدودی در ابتدا نمایش داده شود، اگر تعداد Categoryها زیاد است.
- دکمه «مشاهده همه دسته‌بندی‌ها» برای بقیه.

## Interaction

کل Card قابل کلیک باشد.

## رفتار مورد انتظار

Category count باید از WooCommerce بیاید و Hard-code نشود.

## Acceptance Criteria

- Category title و link درست باشند.
- Count در صورت نمایش با داده واقعی برابر باشد.
- Long title باعث شکستن Card نشود.
- Keyboard focus واضح باشد.
- Iconها Style یکسان داشته باشند.
- هیچ Category مهمی فقط به خاطر محدودیت Layout حذف نشود.

---

# 8. Section 03 — Special Offers

## هدف

نمایش فرصت‌های خرید دارای تخفیف و افزایش Conversion.

## اولویت

**High / P1**

## محتوای هر Product Card

- Product image.
- Sale badge.
- Product title.
- Regular price.
- Sale price.
- Optional short metadata.
- CTA یا clickable card.

## UI پیشنهادی

Desktop:

- 4 یا 5 Card در یک Row.
- امکان نمایش Slider فقط در صورت نیاز واقعی.

Tablet:

- 2 یا 3 Card.

Mobile:

ترجیح اولیه:

- یک Card برجسته + Horizontal swipe برای محصولات دیگر

یا

- Compact vertical cards.

انتخاب نهایی بعد از Prototype انجام شود.

## Interaction

- Product link.
- Optional Add-to-cart فقط اگر با نوع محصول فعلی سازگار باشد.
- Slider navigation در صورت استفاده.

## رفتار مورد انتظار

فقط محصولات واقعاً On Sale نمایش داده شوند.

## Acceptance Criteria

- Regular/Sale price با WooCommerce برابر باشد.
- Badge درصد تخفیف در صورت محاسبه، از داده واقعی تولید شود.
- Product image نسبت ثابت داشته باشد.
- Card بدون تصویر نیز Layout را خراب نکند.
- Slider در صورت وجود با Keyboard و Touch قابل استفاده باشد.
- CLS ناشی از Load تصویر حداقل باشد.

---

# 9. Section 04 — Newest / Best-selling Products

## هدف

کمک به Discovery از دو مسیر مهم:

- تازه‌ترین محتوا.
- محبوب‌ترین محصولات.

## اولویت

**Critical / P0**

## محتوای لازم

- Section heading.
- Segmented control / Tabs.
- Product cards.
- «مشاهده همه».

## UI پیشنهادی

Tabs:

- جدیدترین‌ها
- پرفروش‌ترین‌ها

Active state باید کاملاً مشخص باشد.

Desktop:

- Product grid چندستونه.

Tablet:

- 2 تا 3 ستون.

Mobile:

- Compact vertical list یا Horizontal card carousel.

## Interaction

- Switch بین Tabs.
- Product card link.
- View all.

## رفتار مورد انتظار

**Newest:** Query بر اساس تاریخ انتشار یا معیار مورد توافق.

**Best-selling:** Query واقعی WooCommerce بر اساس فروش، نه فهرست Hard-coded.

## Acceptance Criteria

- Tab با Keyboard قابل تغییر باشد.
- Tab semantics صحیح باشد.
- بدون JavaScript حداقل یک Dataset قابل نمایش باشد.
- Loading state در صورت AJAX مشخص باشد.
- Layout هنگام تغییر Tab جهش شدید نداشته باشد.
- قیمت، تصویر و عنوان Product از WooCommerce بیاید.

---

# 10. Section 05 — Value Proposition / Service Highlights

## هدف

پاسخ سریع به سؤال‌های اعتماد:

- فایل را سریع دریافت می‌کنم؟
- کیفیت چیست؟
- پشتیبانی وجود دارد؟
- فایل قابل استفاده/ویرایش است؟

## اولویت

**Medium / P2**

## UI پیشنهادی

4 تا 5 Item کوتاه:

- دانلود سریع.
- کیفیت فایل.
- فایل استاندارد/قابل ویرایش.
- پشتیبانی تخصصی.
- ارزش خرید / خرید امن.

این موارد فقط در صورت صحت واقعی Claimها استفاده شوند.

## Desktop

Horizontal strip.

## Tablet

2 یا 3 ستون.

## Mobile

2 ستون یا Horizontal compact row.

## Acceptance Criteria

- Claim غیرقابل اثبات نوشته نشود.
- متن هر Item کوتاه باشد.
- Icon صرفاً تزئینی `aria-hidden` باشد.
- این Section ارتفاع زیادی نگیرد.

---

# 11. Section 06 — Latest Q&A

## هدف

نمایش تخصص و Community Activity و کمک به کاربران دارای سؤال فنی.

## اولویت

**Medium / P2**

## محتوای هر Item

- Question title.
- Short excerpt.
- Author، در صورت نیاز.
- Relative/absolute date.
- Link.

## UI پیشنهادی

Desktop:

- در کنار Latest Articles.
- List card.

Mobile:

- List ساده.
- حداکثر 3 Item.
- CTA «مشاهده همه».

Accordion فقط در صورتی استفاده شود که واقعاً پاسخ داخل Homepage نمایش داده شود.

## Data Source

**[نیاز به تأیید]**

باید قبل از Implementation مشخص شود Q&A با چه Plugin/CPT/Database model مدیریت می‌شود.

## Acceptance Criteria

- Latest logic مشخص باشد.
- Title و excerpt escape شوند.
- Metadata خوانا باشد.
- Link مقصد درست داشته باشد.
- اگر Data موجود نبود، Empty State مناسب نمایش داده شود.

---

# 12. Section 07 — Latest Articles

## هدف

نمایش محتوای آموزشی و تقویت Authority و Internal Linking.

## اولویت

**Medium / P2**

## محتوای هر Article

- Featured image، در صورت وجود.
- Title.
- Short excerpt.
- Date.
- Link.

## UI پیشنهادی

Desktop:

- Q&A و Articles در یک Row دو ستونه.
- Articles به صورت 3 Item compact.

Tablet:

- دو ستون در عرض کافی.
- در عرض کمتر Stack.

Mobile:

- Vertical list.
- Thumbnail کوچک.

## Acceptance Criteria

- Query از WordPress posts باشد.
- Title، excerpt و date واقعی باشند.
- Featured image fallback وجود داشته باشد.
- Heading hierarchy صحیح باشد.
- «بیشتر بخوانید» تکراری و پرحجم نشود؛ Card title می‌تواند لینک اصلی باشد.

---

# 13. Section 08 — Support / Trust

## هدف

کاهش نگرانی کاربر بعد از خرید فایل یا سفارش طراحی.

## اولویت

**High / P1**

## محتوای پیشنهادی

- Headline.
- یک توضیح کوتاه.
- 3 تا 4 Trust point واقعی.
- Optional support visual.

## نکته مهم

محتوای این Section باید بازنویسی شود تا Claim دقیق و حرفه‌ای داشته باشد.

از عبارت‌های مبهم یا تکراری فعلی پرهیز شود.

## UI پیشنهادی

Desktop:

- Split panel.
- Text + small illustration / trust cards.

Mobile:

- متن اول.
- Trust cards زیر آن.
- Visual غیرضروری در صورت ایجاد شلوغی حذف شود.

## Acceptance Criteria

- Claims مطابق خدمات واقعی باشند.
- CTA احتمالی Support مقصد مشخص داشته باشد.
- محتوا از Testimonials تفکیک معنایی داشته باشد.

---

# 14. Section 09 — Testimonials

## هدف

ارائه Social Proof واقعی.

## اولویت

**High / P1**

## وضعیت فعلی

بخش فعلی بیشتر بر تصاویر رضایت مشتریان تکیه دارد.

## پیشنهاد طراحی

در صورت امکان Data را ساختاری کنیم:

- Name یا شناسه قابل نمایش.
- Role/business، در صورت وجود.
- Testimonial text.
- Optional avatar.
- Optional source image.

اگر فقط تصاویر موجود هستند، فعلاً می‌توان نسخه اول را با همان Assets پیاده کرد.

## Desktop

3 یا 4 Card.

## Tablet

2 Card.

## Mobile

یک Card در هر View + Swipe یا Stack محدود.

## Acceptance Criteria

- Testimonial جعلی تولید نشود.
- نام یا نقل قول ساختگی اضافه نشود.
- تصاویر متن‌دار در Mobile خوانا باشند.
- Carousel در صورت استفاده Auto-play اجباری نداشته باشد.
- کنترل دستی قابل دسترس باشد.

---

# 15. Section 10 — Contact Request

## هدف

تبدیل کاربری که فایل مناسب پیدا نکرده به Lead برای طراحی اختصاصی.

## اولویت

**Critical / P0**

## محتوای پیشنهادی

- Headline مستقیم.
- توضیح یک‌خطی.
- Mobile number input.
- CTA.
- Privacy/support microcopy کوتاه در صورت نیاز.

## UI پیشنهادی

Desktop:

CTA panel پهن.

Tablet:

Form در یک Row یا دو Row.

Mobile:

- Input Full-width.
- Button Full-width.
- حداقل متن.

## Interaction

- Input validation.
- Submit.
- Success state.
- Error state.
- Loading state.

## Data Source / Backend

**[نیاز به تأیید]**

قبل از Implementation باید فرم فعلی بررسی شود:

- Plugin چیست؟
- Data کجا ذخیره می‌شود؟
- آیا Email/SMS/Webhook ارسال می‌شود؟
- Spam protection چیست؟

## Acceptance Criteria

- شماره موبایل Validate شود.
- Error message واضح باشد.
- Success message مشخص باشد.
- Button هنگام Submit دوباره قابل ارسال نباشد.
- Form با Keyboard موبایل سازگار باشد.
- داده بدون نیاز واقعی جمع‌آوری نشود.
- Backend موجود بدون تأیید تغییر نکند.

---

# 16. Section 11 — Telegram Community

## هدف

تبدیل بازدیدکننده به عضو Community.

## اولویت

**Medium / P2**

## محتوای لازم

- Label کوتاه.
- Headline.
- توضیح حداکثر 2 خط.
- CTA کانال.
- CTA گروه گفتگو.

## UI پیشنهادی

Desktop:

CTA band پهن و متمایز.

Mobile:

Stack.
دو CTA واضح.

## Acceptance Criteria

- لینک کانال و گروه صحیح باشند.
- تفاوت «کانال» و «گروه گفتگو» واضح باشد.
- External link behavior مشخص باشد.
- Section بیش از حد شبیه Footer نشود، چون Footer خارج از Scope است.

---

# 17. Cross-section Rules

## Section Header

هر Section در صورت نیاز ساختار زیر داشته باشد:

- H2.
- Supporting text اختیاری.
- View-all link اختیاری.

از تکرار Headingهای تزئینی غیرضروری جلوگیری شود.

## Cards

تمام Cardهای محصول/مقاله/دسته باید:

- Alignment RTL صحیح داشته باشند.
- Focus state داشته باشند.
- Long title را مدیریت کنند.
- Image ratio تعریف‌شده داشته باشند.
- Layout shift ایجاد نکنند.

## Buttons

حداکثر سه سطح:

1. Primary
2. Secondary
3. Text/link action

برای هر Section چند CTA هم‌ارزش و رقابت‌کننده ایجاد نشود.

---

# 18. SEO Requirements در طراحی

طراحی جدید نباید SEO را قربانی ظاهر کند.

- H1 اصلی حفظ شود.
- H2های Section semantic باشند.
- متن‌های مهم به تصویر تبدیل نشوند.
- Product title واقعی در DOM باشد.
- Internal links Crawlable باشند.
- لینک‌ها با JavaScript-only navigation ساخته نشوند.
- تصاویر Alt مناسب داشته باشند.
- محتوای فعلی که Search intent مهم دارد بدون تصمیم آگاهانه حذف نشود.

---

# 19. Accessibility Requirements در طراحی

- Contrast حداقل مطابق WCAG AA هدف‌گذاری شود.
- Focus visible.
- Keyboard navigation.
- Form labels.
- Error messages programmatically associated.
- Slider/carousel controls accessible.
- Reduced motion.
- Link و Button از نظر نقش Semantic درست باشند.
- Touch target مناسب Mobile.

---

# 20. Performance Requirements در طراحی

Design نباید Implementation را مجبور به Assetهای سنگین کند.

محدودیت‌های طراحی:

- Hero video به‌صورت پیش‌فرض استفاده نشود.
- Background video استفاده نشود.
- Slider برای هر Section استفاده نشود.
- Animation زیاد استفاده نشود.
- Icon library سنگین فقط برای چند Icon اضافه نشود.
- تصاویر باید اندازه و aspect-ratio مشخص داشته باشند.
- Below-the-fold images قابلیت lazy-load داشته باشند.
- Main Content نباید به Elementor runtime وابسته بماند.

---

# 21. اولویت‌بندی Implementation

## P0 — ابتدا

1. Hero + Search
2. Newest / Best-selling Products
3. Contact Request

این سه Section مستقیماً با Discovery، Conversion و Lead Generation مرتبط هستند.

## P1 — بعد

4. Categories
5. Special Offers
6. Support / Trust
7. Testimonials

## P2 — سپس

8. Value Propositions
9. Q&A
10. Articles
11. Telegram Community

این اولویت به معنی حذف Sectionهای P2 نیست. فقط ترتیب Implementation و Validation را مشخص می‌کند.

---

# 22. پیشنهاد Prototype

قبل از اتصال WordPress/WooCommerce، یک Prototype Front-end سبک ساخته شود که فقط Layout و Component behavior را نشان دهد.

Prototype باید:

- از داده نمونه واضح و علامت‌گذاری‌شده استفاده کند.
- به Production وصل نشود.
- Header و Footer را بازسازی نکند.
- Desktop / Tablet / Mobile را پوشش دهد.
- RTL باشد.
- Design tokens اولیه داشته باشد.
- Component states مهم را نمایش دهد.

بعد از تأیید Visual Direction، اتصال Dynamic Data انجام شود.

---

# 23. مواردی که قبل از Implementation باید تأیید شوند

1. Search دقیقاً چه Datasetی را جست‌وجو می‌کند؟
2. لیست Categoryهای نهایی کدام است؟
3. معیار دقیق Best-selling چیست؟
4. تعداد Productهای هر Section چقدر باشد؟
5. Q&A توسط چه Plugin/CPT مدیریت می‌شود؟
6. فرم درخواست تماس با چه Plugin یا Backend کار می‌کند؟
7. Testimonials به صورت Structured Data هستند یا فقط Image؟
8. Font فعلی حفظ شود یا Font جدید انتخاب شود؟
9. Accent Color نهایی برند چیست؟
10. Product Add-to-cart مستقیم در Homepage لازم است یا فقط لینک Product کافی است؟
11. آیا Promo links فعلی باید در Value/Support structure ادغام شوند؟
12. آیا Telegram CTA هر دو لینک کانال و گروه را حفظ کند؟

هیچ‌کدام از موارد بالا نباید بدون بررسی یا تأیید، به‌عنوان Fact در کد فرض شوند.

---

# 24. Definition of Done برای مرحله Design

Design phase زمانی قابل پایان است که:

- ترتیب Sectionها تأیید شده باشد.
- Desktop layout تأیید شده باشد.
- Tablet adaptation مشخص باشد.
- Mobile adaptation مشخص باشد.
- Component behavior تعریف شده باشد.
- Data requirements هر Component مشخص باشد.
- P0/P1/P2 مورد توافق باشد.
- Visual hierarchy تأیید شده باشد.
- Header/Footer همچنان خارج از Scope باشند.
- برای بخش‌های مجهول، سؤال یا Preflight مشخص وجود داشته باشد.

پس از این مرحله، پروژه وارد Prototype و سپس Implementation می‌شود.
