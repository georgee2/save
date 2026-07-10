# SVEC Website — Support Tickets Catalogue

# دليل تذاكر الدعم — موقع SVEC

> A catalogue of anticipated support tickets (errors & questions) for the SmartVision UAE platform, organized for a ticketing system.
>
> دليل بالتذاكر المتوقعة (الأخطاء والاستفسارات) لمنصة سمارت فيجن الإمارات، مُنظَّم للاستخدام في نظام التذاكر.

---

## Ticket Schema | بنية التذكرة

Every ticket uses the following structure. The **Category is always `SVEC Website`**; the **Sub-category** identifies the affected functional area.

تستخدم كل تذكرة البنية التالية. **الفئة دائمًا `موقع SVEC`**، بينما تحدد **الفئة الفرعية** المنطقة الوظيفية المتأثرة.

| Field | الحقل | Value / القيمة |
|---|---|---|
| **Category** | **الفئة** | `SVEC Website` / `موقع SVEC` (fixed / ثابتة) |
| **Sub-category** | **الفئة الفرعية** | One of the areas below / إحدى المناطق أدناه |
| **Issue** | **المشكلة** | Ticket subject / موضوع التذكرة |
| **Description** | **الوصف** | Details of the error or question / تفاصيل الخطأ أو الاستفسار |

---

## Table of Contents | الفهرس

**A. Public Website | الموقع العام**
1. [Homepage | الصفحة الرئيسية](#1-homepage--الصفحة-الرئيسية)
2. [Search | البحث](#2-search--البحث)
3. [Services | الخدمات](#3-services--الخدمات)
4. [Engineering Projects | المشاريع الهندسية](#4-engineering-projects--المشاريع-الهندسية)
5. [Real-estate Offers & Pricing | العروض العقارية والأسعار](#5-real-estate-offers--pricing--العروض-العقارية-والأسعار)
6. [Portfolios & Showcases | معرض الأعمال والعروض التقديمية](#6-portfolios--showcases--معرض-الأعمال-والعروض-التقديمية)
7. [Blog / News | المدونة والأخبار](#7-blog--news--المدونة-والأخبار)
8. [Team, About, Branches & Partners | الفريق والتعريف والفروع والشركاء](#8-team-about-branches--partners--الفريق-والتعريف-والفروع-والشركاء)
9. [Contact Form | نموذج التواصل](#9-contact-form--نموذج-التواصل)
10. [Careers & Job Applications | الوظائف وطلبات التوظيف](#10-careers--job-applications--الوظائف-وطلبات-التوظيف)
11. [Interior Design Gallery | معرض التصميم الداخلي](#11-interior-design-gallery--معرض-التصميم-الداخلي)
12. [Favourites / Wishlist | المفضلة وقائمة الرغبات](#12-favourites--wishlist--المفضلة-وقائمة-الرغبات)
13. [Language / Localization (EN/AR) | اللغة والترجمة](#13-language--localization-enar--اللغة-والترجمة)
14. [SEO & Sitemap | تحسين محركات البحث وخريطة الموقع](#14-seo--sitemap--تحسين-محركات-البحث-وخريطة-الموقع)

**B. Admin / CMS | لوحة التحكم**

15. [Login & Authentication | تسجيل الدخول والمصادقة](#15-login--authentication--تسجيل-الدخول-والمصادقة)
16. [Dashboard & Integrations | لوحة القيادة والتكاملات](#16-dashboard--integrations--لوحة-القيادة-والتكاملات)
17. [Content Management (CRUD) | إدارة المحتوى](#17-content-management-crud--إدارة-المحتوى)
18. [Media & Image Upload | الوسائط ورفع الصور](#18-media--image-upload--الوسائط-ورفع-الصور)
19. [Feasibility Studies | دراسات الجدوى](#19-feasibility-studies--دراسات-الجدوى)
20. [Analytics | التحليلات](#20-analytics--التحليلات)
21. [Users, Roles & Permissions | المستخدمون والأدوار والصلاحيات](#21-users-roles--permissions--المستخدمون-والأدوار-والصلاحيات)
22. [Menus & Navigation | القوائم والتنقل](#22-menus--navigation--القوائم-والتنقل)
23. [Site Settings | إعدادات الموقع](#23-site-settings--إعدادات-الموقع)
24. [Trash / Soft Delete / Restore | سلة المحذوفات والاستعادة](#24-trash--soft-delete--restore--سلة-المحذوفات-والاستعادة)
25. [Activity Log | سجل النشاط](#25-activity-log--سجل-النشاط)

**C. CRM | إدارة علاقات العملاء**

26. [Contact Us / Leads Inbox | صندوق التواصل والعملاء المحتملون](#26-contact-us--leads-inbox--صندوق-التواصل-والعملاء-المحتملون)
27. [Favourites Management (CRM) | إدارة المفضلة](#27-favourites-management-crm--إدارة-المفضلة)
28. [Agents | الوكلاء / المندوبون](#28-agents--الوكلاء--المندوبون)
29. [Job Postings (CRM) | إعلانات الوظائف](#29-job-postings-crm--إعلانات-الوظائف)

**D. System / Technical | النظام والجوانب التقنية**

30. [Email & Notifications | البريد الإلكتروني والإشعارات](#30-email--notifications--البريد-الإلكتروني-والإشعارات)
31. [Exports (PDF / Excel) | التصدير](#31-exports-pdf--excel--التصدير)
32. [Performance & Errors | الأداء والأخطاء](#32-performance--errors--الأداء-والأخطاء)
33. [Under-Construction & Deployment | وضع الصيانة والنشر](#33-under-construction--deployment--وضع-الصيانة-والنشر)

---

# A. Public Website | الموقع العام

## 1. Homepage | الصفحة الرئيسية

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Homepage slider not showing / images broken<br>**AR:** السلايدر في الصفحة الرئيسية لا يظهر / الصور مكسورة | **EN:** Slider images fail to load or a slide is missing after publishing. Usually caused by an unpublished/inactive slider, a wrong display order, or a broken storage symlink.<br>**AR:** صور السلايدر لا تُحمَّل أو إحدى الشرائح مفقودة بعد النشر. غالبًا بسبب سلايدر غير منشور/غير مفعّل، أو ترتيب عرض خاطئ، أو رابط تخزين (storage link) مكسور. |
| 2 | **EN:** A section (services / projects / news) is empty on the homepage<br>**AR:** أحد الأقسام (الخدمات / المشاريع / الأخبار) فارغ في الصفحة الرئيسية | **EN:** A homepage section shows nothing although data exists. Check the "Home Feature" toggle on the items and the section visibility/order in Home Sections.<br>**AR:** قسم في الصفحة الرئيسية لا يعرض أي عنصر رغم وجود بيانات. تحقق من مفتاح "إظهار في الرئيسية" على العناصر ومن رؤية/ترتيب القسم في إعدادات أقسام الرئيسية. |
| 3 | **EN:** Homepage loads slowly<br>**AR:** الصفحة الرئيسية بطيئة في التحميل | **EN:** Homepage takes long to load because it aggregates many sections. Investigate HeaderComposer queries, N+1 loads, and image sizes.<br>**AR:** الصفحة الرئيسية تستغرق وقتًا طويلًا لأنها تجمع أقسامًا كثيرة. راجع استعلامات HeaderComposer ومشاكل N+1 وأحجام الصور. |
| 4 | **EN:** Facts/counters show wrong numbers<br>**AR:** الحقائق/العدّادات تعرض أرقامًا خاطئة | **EN:** The statistics/facts counters display outdated or incorrect values that need updating from the admin.<br>**AR:** عدّادات الإحصائيات/الحقائق تعرض قيمًا قديمة أو غير صحيحة تحتاج تحديثًا من لوحة التحكم. |

## 2. Search | البحث

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Live search autocomplete returns no results<br>**AR:** البحث الفوري لا يُظهر أي نتائج | **EN:** Typing in the search box shows no suggestions even for existing content. May be a JS error, an empty index, or a locale mismatch in the query.<br>**AR:** الكتابة في مربع البحث لا تُظهر أي اقتراحات حتى لمحتوى موجود. قد يكون خطأ في الجافاسكربت، أو عدم تطابق اللغة في الاستعلام. |
| 2 | **EN:** Search filters (emirate / category / type) return wrong results<br>**AR:** فلاتر البحث (الإمارة / الفئة / النوع) تُرجع نتائج خاطئة | **EN:** Applying filters returns irrelevant or missing items, or filters do not combine correctly.<br>**AR:** تطبيق الفلاتر يُرجع عناصر غير ذات صلة أو مفقودة، أو أن الفلاتر لا تعمل معًا بشكل صحيح. |
| 3 | **EN:** Arabic search does not match Arabic content<br>**AR:** البحث بالعربية لا يطابق المحتوى العربي | **EN:** Searching an Arabic keyword returns nothing although Arabic content exists — likely searching only the `_en` columns.<br>**AR:** البحث بكلمة عربية لا يُرجع نتائج رغم وجود محتوى عربي — غالبًا لأن البحث يتم في حقول `_en` فقط. |

## 3. Services | الخدمات

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Service page returns 404<br>**AR:** صفحة الخدمة تُظهر خطأ 404 | **EN:** A service or sub-service URL returns "not found", commonly due to an unpublished service or a changed/localized slug.<br>**AR:** رابط خدمة أو خدمة فرعية يُظهر "غير موجود"، غالبًا بسبب خدمة غير منشورة أو تغيّر في الـ slug المترجم. |
| 2 | **EN:** Service sections appear in the wrong order<br>**AR:** أقسام الخدمة تظهر بترتيب خاطئ | **EN:** Features/process/values/FAQs display in an unexpected order; the configurable section ordering needs adjusting.<br>**AR:** تظهر المميزات/الخطوات/القيم/الأسئلة الشائعة بترتيب غير متوقع؛ يلزم ضبط ترتيب الأقسام القابل للتهيئة. |
| 3 | **EN:** Sub-service not linked to its main service<br>**AR:** الخدمة الفرعية غير مرتبطة بالخدمة الرئيسية | **EN:** A sub-service does not appear under its parent service or links to the wrong parent.<br>**AR:** الخدمة الفرعية لا تظهر تحت الخدمة الرئيسية أو ترتبط بخدمة رئيسية خاطئة. |

## 4. Engineering Projects | المشاريع الهندسية

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Project detail page returns 404 / wrong slug<br>**AR:** صفحة تفاصيل المشروع تُظهر 404 / slug خاطئ | **EN:** Project link is broken after editing the title/slug; legacy `/engineering/{slug}` URLs may also need redirecting.<br>**AR:** رابط المشروع مكسور بعد تعديل العنوان/الـ slug؛ قد تحتاج روابط `/engineering/{slug}` القديمة إلى إعادة توجيه. |
| 2 | **EN:** Category / sub-category filter shows no projects<br>**AR:** فلتر الفئة / الفئة الفرعية لا يعرض مشاريع | **EN:** Selecting a category returns empty results although projects exist under it — check publish status and category assignment.<br>**AR:** اختيار فئة يُرجع نتائج فارغة رغم وجود مشاريع تحتها — تحقق من حالة النشر وربط الفئة. |
| 3 | **EN:** Floors / specifications / components not displayed<br>**AR:** الأدوار / المواصفات / المكوّنات لا تظهر | **EN:** Project floors, amenities, specifications, or building/income/length components are missing on the detail page.<br>**AR:** أدوار المشروع أو المرافق أو المواصفات أو مكوّنات المبنى/الدخل/الطول مفقودة في صفحة التفاصيل. |
| 4 | **EN:** Feasibility-study toggle has no effect<br>**AR:** مفتاح دراسة الجدوى لا يؤثر | **EN:** Enabling/disabling the feasibility study on a project does not reflect on the public page.<br>**AR:** تفعيل/إلغاء دراسة الجدوى للمشروع لا ينعكس على الصفحة العامة. |
| 5 | **EN:** Project image gallery not loading<br>**AR:** معرض صور المشروع لا يظهر | **EN:** Gallery thumbnails or lightbox images fail to load or are in the wrong order.<br>**AR:** الصور المصغّرة أو صور المعرض لا تُحمَّل أو تظهر بترتيب خاطئ. |

## 5. Real-estate Offers & Pricing | العروض العقارية والأسعار

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Offer price is missing or shows zero<br>**AR:** سعر العرض مفقود أو يظهر صفرًا | **EN:** An offer has no price for the selected emirate/currency, or shows 0. Prices are per Emirate × Currency and must be set for each.<br>**AR:** العرض لا يملك سعرًا للإمارة/العملة المختارة أو يظهر 0. الأسعار لكل (إمارة × عملة) ويجب ضبطها لكلٍّ منها. |
| 2 | **EN:** Wrong currency / currency symbol on offer<br>**AR:** عملة / رمز عملة خاطئ في العرض | **EN:** Offer displays the wrong currency or symbol; default should be AED for UAE-facing flows.<br>**AR:** العرض يعرض عملة أو رمزًا خاطئًا؛ يجب أن تكون الافتراضية درهم إماراتي (AED) للواجهات الموجهة للإمارات. |
| 3 | **EN:** Price differs between emirates unexpectedly<br>**AR:** السعر يختلف بين الإمارات بشكل غير متوقع | **EN:** User expects one price but sees different prices per emirate — clarify the multi-emirate pricing model or a data-entry mistake.<br>**AR:** يتوقع المستخدم سعرًا واحدًا لكنه يرى أسعارًا مختلفة حسب الإمارة — يلزم توضيح نموذج التسعير متعدد الإمارات أو تصحيح خطأ إدخال. |
| 4 | **EN:** Video / virtual-tour link not working<br>**AR:** رابط الفيديو / الجولة الافتراضية لا يعمل | **EN:** The offer's video or virtual-tour URL is broken, blank, or opens the wrong media.<br>**AR:** رابط الفيديو أو الجولة الافتراضية للعرض مكسور أو فارغ أو يفتح وسائط خاطئة. |
| 5 | **EN:** Offer not appearing under its category/subcategory<br>**AR:** العرض لا يظهر تحت فئته / فئته الفرعية | **EN:** Published offer does not show in its category listing — check category assignment and publish status.<br>**AR:** العرض المنشور لا يظهر في قائمة فئته — تحقق من ربط الفئة وحالة النشر. |

## 6. Portfolios & Showcases | معرض الأعمال والعروض التقديمية

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Portfolio item images / process steps missing<br>**AR:** صور عنصر معرض الأعمال / خطوات العملية مفقودة | **EN:** A portfolio item shows no gallery images or process steps although they were added.<br>**AR:** عنصر في معرض الأعمال لا يعرض صورًا أو خطوات رغم إضافتها. |
| 2 | **EN:** Showcase links to deleted/unpublished items<br>**AR:** العرض التقديمي يرتبط بعناصر محذوفة/غير منشورة | **EN:** A showcase references a service/project/portfolio/team member/news item that is no longer available, causing broken links.<br>**AR:** يشير العرض التقديمي إلى خدمة/مشروع/عمل/عضو فريق/خبر لم يعد متاحًا، مما يسبب روابط مكسورة. |
| 3 | **EN:** Portfolio not grouped under the right type<br>**AR:** العمل غير مصنّف تحت النوع الصحيح | **EN:** Portfolio item appears under the wrong portfolio type or with no type.<br>**AR:** يظهر عنصر العمل تحت نوع خاطئ أو بدون نوع. |

## 7. Blog / News | المدونة والأخبار

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** News article returns 404 after edit<br>**AR:** مقال الأخبار يُظهر 404 بعد التعديل | **EN:** Editing a news title regenerated the localized slug (`news_slugs`) and broke the old URL. Needs a redirect or stable slug.<br>**AR:** أدى تعديل عنوان الخبر إلى إعادة توليد الـ slug المترجم وكسر الرابط القديم. يلزم إعادة توجيه أو تثبيت الـ slug. |
| 2 | **EN:** News category empty although posts exist<br>**AR:** فئة الأخبار فارغة رغم وجود مقالات | **EN:** A news category page shows no posts — check publish status and category assignment.<br>**AR:** صفحة فئة الأخبار لا تعرض مقالات — تحقق من حالة النشر وربط الفئة. |
| 3 | **EN:** Arabic article shows English content (or vice versa)<br>**AR:** المقال العربي يعرض محتوى إنجليزي (أو العكس) | **EN:** One language field was left empty, so the page falls back to the other language.<br>**AR:** تُرك أحد حقلي اللغة فارغًا، فتعود الصفحة إلى اللغة الأخرى. |

## 8. Team, About, Branches & Partners | الفريق والتعريف والفروع والشركاء

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Team member order / board-of-directors order wrong<br>**AR:** ترتيب أعضاء الفريق / مجلس الإدارة خاطئ | **EN:** Members appear in the wrong sequence; display order and board-of-directors order need adjusting.<br>**AR:** يظهر الأعضاء بترتيب خاطئ؛ يلزم ضبط ترتيب العرض وترتيب مجلس الإدارة. |
| 2 | **EN:** About page section missing / empty<br>**AR:** قسم في صفحة "من نحن" مفقود / فارغ | **EN:** A configurable About-page section, feature, or custom block does not render.<br>**AR:** قسم قابل للتهيئة في صفحة "من نحن" أو ميزة أو بلوك مخصص لا يظهر. |
| 3 | **EN:** Branch location / map incorrect<br>**AR:** موقع الفرع / الخريطة غير صحيح | **EN:** A branch shows the wrong address or map location.<br>**AR:** يعرض الفرع عنوانًا أو موقعًا خاطئًا على الخريطة. |
| 4 | **EN:** Partner logo broken or in wrong group<br>**AR:** شعار الشريك مكسور أو في المجموعة الخاطئة | **EN:** A partner/government-client logo fails to load or appears under the wrong partner type.<br>**AR:** شعار شريك/جهة حكومية لا يُحمَّل أو يظهر تحت نوع شريك خاطئ. |

## 9. Contact Form | نموذج التواصل

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** "Too many attempts" error when submitting<br>**AR:** رسالة "محاولات كثيرة جدًا" عند الإرسال | **EN:** The contact form is throttled to 5 submissions/minute; users hitting the limit see a 429 error.<br>**AR:** نموذج التواصل محدود بـ 5 محاولات في الدقيقة؛ من يتجاوز الحد يرى الخطأ 429. |
| 2 | **EN:** Confirmation email not received<br>**AR:** لم يصل بريد التأكيد | **EN:** The visitor submits the form but receives no confirmation email (mail config, spam folder, or queue not running).<br>**AR:** يرسل الزائر النموذج لكنه لا يستلم بريد التأكيد (إعدادات البريد، مجلد الغير مرغوب، أو الطابور غير مُشغَّل). |
| 3 | **EN:** Form submission fails validation unexpectedly<br>**AR:** فشل النموذج في التحقق بشكل غير متوقع | **EN:** Valid input is rejected, or required-field errors are unclear/untranslated.<br>**AR:** يُرفض إدخال صحيح، أو رسائل الحقول المطلوبة غير واضحة/غير مترجمة. |
| 4 | **EN:** Submission not appearing in CRM inbox<br>**AR:** الرسالة لا تظهر في صندوق CRM | **EN:** A submitted contact message does not create a `ContactUs` record visible to sales/support.<br>**AR:** رسالة تواصل مُرسَلة لا تُنشئ سجلًا يظهر لفريق المبيعات/الدعم. |

## 10. Careers & Job Applications | الوظائف وطلبات التوظيف

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Job posting not visible although created<br>**AR:** إعلان الوظيفة غير ظاهر رغم إنشائه | **EN:** A job does not appear because it is outside its date-bounded registration window or not active.<br>**AR:** لا تظهر الوظيفة لأنها خارج نافذة التسجيل المحددة بالتاريخ أو غير مفعّلة. |
| 2 | **EN:** Resume upload fails<br>**AR:** فشل رفع السيرة الذاتية | **EN:** Applicant cannot upload a CV due to file type/size validation or storage permission issues.<br>**AR:** لا يستطيع المتقدم رفع السيرة الذاتية بسبب التحقق من نوع/حجم الملف أو صلاحيات التخزين. |
| 3 | **EN:** "Applications closed" shown too early/late<br>**AR:** ظهور "التقديم مغلق" مبكرًا/متأخرًا جدًا | **EN:** The apply window opens or closes at the wrong time due to a date/timezone configuration.<br>**AR:** تفتح أو تغلق نافذة التقديم في وقت خاطئ بسبب إعداد التاريخ/المنطقة الزمنية. |
| 4 | **EN:** Job application not received by HR<br>**AR:** طلب التوظيف لم يصل إلى الموارد البشرية | **EN:** A submitted `JobApplication` is not visible to staff or no notification was sent.<br>**AR:** طلب التوظيف المُرسَل غير ظاهر للموظفين أو لم يُرسَل إشعار به. |

## 11. Interior Design Gallery | معرض التصميم الداخلي

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Interior item / category page 404<br>**AR:** صفحة عنصر / فئة التصميم الداخلي تُظهر 404 | **EN:** An interior-design item or category returns not-found due to unpublished state or a changed slug.<br>**AR:** عنصر أو فئة تصميم داخلي يُظهر "غير موجود" بسبب حالة غير منشورة أو تغيّر في الـ slug. |
| 2 | **EN:** Gallery images not loading / wrong order<br>**AR:** صور المعرض لا تظهر / بترتيب خاطئ | **EN:** Interior gallery thumbnails fail to load or display out of the intended order.<br>**AR:** الصور المصغّرة لمعرض التصميم الداخلي لا تُحمَّل أو تظهر بترتيب غير مقصود. |

## 12. Favourites / Wishlist | المفضلة وقائمة الرغبات

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Favourite toggle / count not updating<br>**AR:** زر المفضلة / العدّاد لا يتحدّث | **EN:** Adding or removing a favourite does not update the count or persist after refresh.<br>**AR:** إضافة أو إزالة عنصر من المفضلة لا يحدّث العدّاد أو لا يُحفظ بعد التحديث. |
| 2 | **EN:** Shared favourites link (token) not working<br>**AR:** رابط مشاركة المفضلة (التوكن) لا يعمل | **EN:** The share-by-token URL opens empty, expired, or errors — token invalid or list cleared.<br>**AR:** رابط المشاركة عبر التوكن يفتح فارغًا أو منتهيًا أو يظهر خطأ — التوكن غير صالح أو القائمة مُفرَّغة. |
| 3 | **EN:** "Send favourites by email" not delivered<br>**AR:** "إرسال المفضلة بالبريد" لا يصل | **EN:** The email containing the wishlist is not received by the recipient.<br>**AR:** البريد الذي يحتوي على قائمة الرغبات لا يصل إلى المستلم. |
| 4 | **EN:** Mixed item types not all appearing<br>**AR:** أنواع العناصر المختلطة لا تظهر كلها | **EN:** A wishlist mixing projects, offers, and interior items does not show all item types.<br>**AR:** قائمة رغبات تجمع مشاريع وعروضًا وعناصر داخلية لا تعرض كل الأنواع. |

## 13. Language / Localization (EN/AR) | اللغة والترجمة

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Language switch loses the current page<br>**AR:** تبديل اللغة يفقد الصفحة الحالية | **EN:** Switching EN↔AR redirects to the homepage or a 404 instead of the translated version of the current page.<br>**AR:** تبديل اللغة بين الإنجليزية والعربية يعيد التوجيه إلى الرئيسية أو 404 بدل النسخة المترجمة من الصفحة الحالية. |
| 2 | **EN:** Untranslated text (shows the other language or a key)<br>**AR:** نص غير مترجم (يعرض اللغة الأخرى أو مفتاح الترجمة) | **EN:** A label or content appears in the wrong language or as a raw translation key — missing `_ar`/`_en` value or lang file entry.<br>**AR:** يظهر نص أو تسمية باللغة الخاطئة أو كمفتاح ترجمة خام — قيمة `_ar`/`_en` مفقودة أو مدخل ملف اللغة غير موجود. |
| 3 | **EN:** Arabic page layout not right-to-left (RTL)<br>**AR:** تنسيق الصفحة العربية ليس من اليمين لليسار | **EN:** Arabic pages render left-to-right or with misaligned elements — RTL styling issue.<br>**AR:** تظهر الصفحات العربية من اليسار لليمين أو بعناصر غير متوازنة — مشكلة في تنسيق RTL. |
| 4 | **EN:** Auto-translate button produces wrong text<br>**AR:** زر الترجمة التلقائية ينتج نصًا خاطئًا | **EN:** The admin auto-translate (Google Translate) fills incorrect or empty text; may be an API/key/quota issue.<br>**AR:** الترجمة التلقائية في لوحة التحكم (Google Translate) تملأ نصًا خاطئًا أو فارغًا؛ قد تكون مشكلة في الـ API/المفتاح/الحصة. |

## 14. SEO & Sitemap | تحسين محركات البحث وخريطة الموقع

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Page meta title/description not updating<br>**AR:** عنوان/وصف الميتا للصفحة لا يتحدّث | **EN:** Edited SEO meta for a page is not reflected in the page source or search preview.<br>**AR:** بيانات الميتا المعدّلة لصفحة لا تنعكس في مصدر الصفحة أو معاينة البحث. |
| 2 | **EN:** sitemap.xml missing new content<br>**AR:** ملف sitemap.xml لا يحتوي المحتوى الجديد | **EN:** Newly published projects/offers/news are not appearing in the XML sitemap.<br>**AR:** المشاريع/العروض/الأخبار المنشورة حديثًا لا تظهر في خريطة الموقع XML. |
| 3 | **EN:** Broken links / 404s reported in search console<br>**AR:** روابط مكسورة / أخطاء 404 في أدوات محركات البحث | **EN:** Search engines report 404s, usually from regenerated slugs without redirects.<br>**AR:** تُبلّغ محركات البحث عن أخطاء 404، غالبًا بسبب إعادة توليد الـ slug دون إعادة توجيه. |
| 4 | **EN:** Missing image alt-text hurting SEO<br>**AR:** غياب النص البديل للصور يضر بالـ SEO | **EN:** Content images lack `alt_text`, lowering accessibility and SEO scores.<br>**AR:** صور المحتوى تفتقر إلى `alt_text`، مما يخفض درجات الوصولية والـ SEO. |

---

# B. Admin / CMS | لوحة التحكم

## 15. Login & Authentication | تسجيل الدخول والمصادقة

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Cannot log in / "invalid credentials"<br>**AR:** تعذّر تسجيل الدخول / "بيانات غير صحيحة" | **EN:** Staff user cannot log in despite correct credentials — account disabled, wrong email, or caps/locale issue.<br>**AR:** موظف لا يستطيع تسجيل الدخول رغم صحة البيانات — الحساب معطّل، بريد خاطئ، أو مشكلة في حالة الأحرف/اللغة. |
| 2 | **EN:** Session expires too quickly / logged out randomly<br>**AR:** الجلسة تنتهي بسرعة / تسجيل خروج مفاجئ | **EN:** User is logged out unexpectedly during work — session lifetime or cookie/domain configuration.<br>**AR:** يُسجَّل خروج المستخدم فجأة أثناء العمل — عمر الجلسة أو إعداد الكوكيز/النطاق. |
| 3 | **EN:** "419 Page Expired" on login/form submit<br>**AR:** خطأ "419 انتهت صلاحية الصفحة" عند الدخول/الإرسال | **EN:** CSRF token expired (page left open too long / cache issue).<br>**AR:** انتهت صلاحية توكن CSRF (تُركت الصفحة مفتوحة طويلًا / مشكلة تخزين مؤقت). |
| 4 | **EN:** Forgot / reset password not working<br>**AR:** استعادة / إعادة تعيين كلمة المرور لا تعمل | **EN:** Password reset email not received or reset link invalid/expired.<br>**AR:** بريد إعادة التعيين لا يصل أو رابط إعادة التعيين غير صالح/منتهٍ. |

## 16. Dashboard & Integrations | لوحة القيادة والتكاملات

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Integration-health check shows a failure<br>**AR:** فحص صحة التكاملات يُظهر فشلًا | **EN:** The `/admin/check-integrations` check flags mail, storage, database, or an API as unhealthy.<br>**AR:** يُظهر فحص `/admin/check-integrations` أن البريد أو التخزين أو قاعدة البيانات أو أحد الـ APIs غير سليم. |
| 2 | **EN:** Dashboard widgets show no data / errors<br>**AR:** عناصر لوحة القيادة لا تعرض بيانات / تُظهر أخطاء | **EN:** Dashboard cards/counters fail to load or display zeros unexpectedly.<br>**AR:** بطاقات/عدّادات لوحة القيادة لا تُحمَّل أو تعرض أصفارًا بشكل غير متوقع. |

## 17. Content Management (CRUD) | إدارة المحتوى

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** "This action is unauthorized" when saving<br>**AR:** "هذا الإجراء غير مصرّح به" عند الحفظ | **EN:** Editor lacks the required permission for the route; needs a role/permission grant.<br>**AR:** لا يملك المحرّر الصلاحية المطلوبة للمسار؛ يلزم منح دور/صلاحية. |
| 2 | **EN:** Changes not appearing on the public site<br>**AR:** التعديلات لا تظهر على الموقع العام | **EN:** Saved content is not reflected publicly — item unpublished, cache not cleared, or wrong locale field.<br>**AR:** المحتوى المحفوظ لا ينعكس علنًا — العنصر غير منشور، أو التخزين المؤقت لم يُمسح، أو حقل اللغة خاطئ. |
| 3 | **EN:** Validation error blocks saving (unclear field)<br>**AR:** خطأ تحقّق يمنع الحفظ (حقل غير واضح) | **EN:** A required or invalid field prevents saving but the message is unclear or not localized.<br>**AR:** حقل مطلوب أو غير صالح يمنع الحفظ لكن الرسالة غير واضحة أو غير مترجمة. |
| 4 | **EN:** Duplicate slug / unique constraint error<br>**AR:** خطأ تكرار الـ slug / قيد التفرّد | **EN:** Saving fails because a slug or unique field collides with an existing (or soft-deleted) record.<br>**AR:** يفشل الحفظ لأن الـ slug أو حقلًا فريدًا يتعارض مع سجل موجود (أو محذوف مؤقتًا). |
| 5 | **EN:** Rich-text editor loses formatting / images<br>**AR:** محرّر النص الغني يفقد التنسيق / الصور | **EN:** WYSIWYG content loses styling or embedded images after saving.<br>**AR:** يفقد محتوى المحرّر التنسيق أو الصور المضمّنة بعد الحفظ. |

## 18. Media & Image Upload | الوسائط ورفع الصور

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Image upload fails ("file too large" / type)<br>**AR:** فشل رفع الصورة ("الملف كبير جدًا" / النوع) | **EN:** Upload rejected by MIME/size validation or exceeds PHP `upload_max_filesize`/`post_max_size`.<br>**AR:** رُفض الرفع بسبب التحقق من النوع/الحجم أو تجاوز `upload_max_filesize`/`post_max_size` في PHP. |
| 2 | **EN:** Uploaded image shows broken on the site<br>**AR:** الصورة المرفوعة تظهر مكسورة على الموقع | **EN:** Image saved but not visible — missing `storage:link` symlink or wrong disk/path.<br>**AR:** الصورة محفوظة لكنها غير ظاهرة — رابط `storage:link` مفقود أو قرص/مسار خاطئ. |
| 3 | **EN:** Image orientation / quality wrong after upload<br>**AR:** اتجاه / جودة الصورة خاطئ بعد الرفع | **EN:** Intervention/Image resizing rotates, crops, or over-compresses the image.<br>**AR:** تدوير أو قص أو ضغط زائد للصورة أثناء المعالجة عبر Intervention/Image. |

## 19. Feasibility Studies | دراسات الجدوى

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Headers not showing in the study report<br>**AR:** العناوين لا تظهر في تقرير الدراسة | **EN:** The `feasibility_study_components` table has no active records with the correct target types for the project type.<br>**AR:** جدول `feasibility_study_components` لا يحتوي سجلات مفعّلة بأنواع الهدف الصحيحة لنوع المشروع. |
| 2 | **EN:** "No project data to copy"<br>**AR:** "لا توجد بيانات مشروع للنسخ" | **EN:** The project has no floors/building/income components configured before creating the study.<br>**AR:** لا توجد أدوار/مكوّنات مبنى/دخل مهيّأة للمشروع قبل إنشاء الدراسة. |
| 3 | **EN:** Calculations showing zero / wrong totals<br>**AR:** الحسابات تظهر صفرًا / إجماليات خاطئة | **EN:** Building/length/income totals are zero or incorrect — missing values in related project tables or wrong cost overrides.<br>**AR:** إجماليات المبنى/الطول/الدخل صفر أو غير صحيحة — قيم مفقودة في جداول المشروع أو تجاوزات تكلفة خاطئة. |
| 4 | **EN:** Cannot delete a study (Master protected)<br>**AR:** تعذّر حذف الدراسة (الدراسة الرئيسية محميّة) | **EN:** Only Custom studies can be deleted; Master studies are protected by design.<br>**AR:** يمكن حذف الدراسات المخصّصة فقط؛ الدراسات الرئيسية محميّة بحكم التصميم. |
| 5 | **EN:** Payback period shows N/A or infinity<br>**AR:** فترة الاسترداد تظهر "غير متاح" أو ما لا نهاية | **EN:** Annual income is zero, so the payback period (Cost ÷ Income) cannot be computed.<br>**AR:** الدخل السنوي صفر، لذا لا يمكن حساب فترة الاسترداد (التكلفة ÷ الدخل). |
| 6 | **EN:** Duplicated study missing some values<br>**AR:** الدراسة المنسوخة تفقد بعض القيم | **EN:** After duplicating, some component overrides did not copy across to the new Custom study.<br>**AR:** بعد النسخ، لم تُنقل بعض تجاوزات المكوّنات إلى الدراسة المخصّصة الجديدة. |
| 7 | **EN:** Print / PDF report layout broken<br>**AR:** تنسيق طباعة / PDF التقرير مكسور | **EN:** The print view overflows, cuts sections, or fails to hide navigation/buttons.<br>**AR:** تجاوز في عرض الطباعة أو قص للأقسام أو فشل في إخفاء التنقل/الأزرار. |

## 20. Analytics | التحليلات

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Visitor / page-view numbers look wrong<br>**AR:** أرقام الزوار / مشاهدات الصفحات تبدو خاطئة | **EN:** Counts seem too high/low or double-counted — bot traffic, heartbeat, or session grouping.<br>**AR:** الأرقام تبدو مرتفعة/منخفضة جدًا أو مكرّرة — حركة روبوتات، أو نبضات (heartbeat)، أو تجميع الجلسات. |
| 2 | **EN:** Real-time view shows nothing<br>**AR:** العرض اللحظي لا يعرض شيئًا | **EN:** No active visitors appear in real-time although there is traffic — heartbeat endpoint failing.<br>**AR:** لا يظهر زوار نشطون في العرض اللحظي رغم وجود حركة — فشل في نقطة نهاية النبض. |
| 3 | **EN:** Country / location is "Unknown" or wrong<br>**AR:** الدولة / الموقع "غير معروف" أو خاطئ | **EN:** Geolocation shows null/incorrect country — IP API quota/fallback issue.<br>**AR:** يعرض تحديد الموقع دولة فارغة/خاطئة — مشكلة حصة/بديل في IP API. |
| 4 | **EN:** Data cleanup deleted the wrong records<br>**AR:** أداة تنظيف البيانات حذفت سجلات خاطئة | **EN:** A cleanup action (by country/URL/orphaned/null) removed more than intended.<br>**AR:** أزال إجراء تنظيف (حسب الدولة/الرابط/اليتيمة/الفارغة) أكثر مما هو مقصود. |
| 5 | **EN:** CSV export empty or malformed<br>**AR:** تصدير CSV فارغ أو تالف | **EN:** Analytics CSV export downloads empty or with broken columns/encoding (Arabic characters).<br>**AR:** تصدير CSV للتحليلات ينزّل فارغًا أو بأعمدة/ترميز تالف (الأحرف العربية). |

## 21. Users, Roles & Permissions | المستخدمون والأدوار والصلاحيات

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** User cannot access a page they should<br>**AR:** المستخدم لا يستطيع الوصول لصفحة يُفترض له الوصول إليها | **EN:** A route-level permission slug is missing from the user's role.<br>**AR:** صلاحية على مستوى المسار مفقودة من دور المستخدم. |
| 2 | **EN:** New admin route returns 403 for everyone<br>**AR:** مسار إداري جديد يُرجع 403 للجميع | **EN:** A newly added admin route has no seeded permission slug, so `CheckRoutePermission` blocks all non-super-admins.<br>**AR:** مسار إداري جديد بلا صلاحية مزروعة، فيمنع `CheckRoutePermission` جميع غير مديري النظام العام. |
| 3 | **EN:** Role changes not taking effect<br>**AR:** تغييرات الدور لا تُطبَّق | **EN:** Assigning/removing a permission does not change access until re-login or cache clear.<br>**AR:** إسناد/إزالة صلاحية لا يغيّر الوصول إلا بعد إعادة الدخول أو مسح التخزين المؤقت. |
| 4 | **EN:** Super-admin bypass working unexpectedly<br>**AR:** تجاوز مدير النظام العام يعمل بشكل غير متوقع | **EN:** A user has more access than expected because of the super-admin flag.<br>**AR:** لدى مستخدم وصول أكبر من المتوقع بسبب علامة مدير النظام العام. |
| 5 | **EN:** Cannot create/delete a user<br>**AR:** تعذّر إنشاء/حذف مستخدم | **EN:** User management action fails due to permissions, unique email, or self-delete protection.<br>**AR:** يفشل إجراء إدارة المستخدم بسبب الصلاحيات أو تكرار البريد أو حماية حذف الذات. |

## 22. Menus & Navigation | القوائم والتنقل

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Header / footer menu item missing<br>**AR:** عنصر قائمة الهيدر / الفوتر مفقود | **EN:** A menu item does not appear — inactive, wrong menu, or falling back to the primary menu.<br>**AR:** عنصر القائمة لا يظهر — غير مفعّل، أو قائمة خاطئة، أو رجوع إلى القائمة الأساسية. |
| 2 | **EN:** Menu item links to the wrong / broken URL<br>**AR:** عنصر القائمة يرتبط برابط خاطئ / مكسور | **EN:** A hierarchical menu item points to a removed page or a URL missing the locale prefix.<br>**AR:** عنصر قائمة هرمي يشير إلى صفحة محذوفة أو رابط بلا بادئة اللغة. |
| 3 | **EN:** Menu order / hierarchy wrong<br>**AR:** ترتيب / تسلسل القائمة خاطئ | **EN:** Menu items appear in the wrong order or nesting after editing.<br>**AR:** تظهر عناصر القائمة بترتيب أو تداخل خاطئ بعد التعديل. |

## 23. Site Settings | إعدادات الموقع

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Contact info (phone/email/address) outdated<br>**AR:** معلومات التواصل (الهاتف/البريد/العنوان) قديمة | **EN:** Global contact details shown in header/footer need updating in Site Settings.<br>**AR:** تفاصيل التواصل العامة في الهيدر/الفوتر تحتاج تحديثًا في إعدادات الموقع. |
| 2 | **EN:** Logo / favicon / site identity not updating<br>**AR:** الشعار / الأيقونة / هوية الموقع لا تتحدّث | **EN:** Changed branding assets still show the old version (cache or wrong asset path).<br>**AR:** أصول العلامة المعدّلة ما زالت تعرض النسخة القديمة (تخزين مؤقت أو مسار أصل خاطئ). |
| 3 | **EN:** A global toggle has no visible effect<br>**AR:** مفتاح عام دون تأثير ظاهر | **EN:** Toggling a global setting does not change front-end behaviour as expected.<br>**AR:** تبديل إعداد عام لا يغيّر سلوك الواجهة كما هو متوقع. |

## 24. Trash / Soft Delete / Restore | سلة المحذوفات والاستعادة

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Deleted item still appears somewhere<br>**AR:** عنصر محذوف ما زال يظهر في مكان ما | **EN:** A soft-deleted record still shows in a listing that queries `withTrashed()` unintentionally.<br>**AR:** سجل محذوف مؤقتًا ما زال يظهر في قائمة تستعلم `withTrashed()` دون قصد. |
| 2 | **EN:** Restored item is broken / missing relations<br>**AR:** العنصر المستعاد معطوب / يفقد علاقاته | **EN:** After restore, related child records were not restored or were cascade-deleted.<br>**AR:** بعد الاستعادة، لم تُستعَد السجلات الفرعية المرتبطة أو حُذفت تسلسليًا. |
| 3 | **EN:** Cannot restore / force-delete an item<br>**AR:** تعذّر استعادة / حذف نهائي لعنصر | **EN:** Restore/force-delete fails due to missing permission or a foreign-key constraint.<br>**AR:** تفشل الاستعادة/الحذف النهائي بسبب صلاحية مفقودة أو قيد مفتاح خارجي. |
| 4 | **EN:** Accidentally force-deleted important data<br>**AR:** حذف نهائي غير مقصود لبيانات مهمة | **EN:** An irreversible force-delete removed data that cannot be recovered — needs backup restore.<br>**AR:** أدى حذف نهائي غير قابل للتراجع إلى إزالة بيانات لا يمكن استرجاعها — يلزم استعادة من نسخة احتياطية. |

## 25. Activity Log | سجل النشاط

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Action not recorded in the activity log<br>**AR:** إجراء غير مُسجَّل في سجل النشاط | **EN:** A create/update/delete or a custom action (toggle/reorder/bulk) is missing from the audit trail.<br>**AR:** عملية إنشاء/تعديل/حذف أو إجراء مخصص (تبديل/ترتيب/جماعي) مفقود من سجل التدقيق. |
| 2 | **EN:** Log shows wrong user / no IP<br>**AR:** السجل يعرض مستخدمًا خاطئًا / بلا عنوان IP | **EN:** The recorded actor, IP, or user-agent is missing or incorrect.<br>**AR:** الفاعل المسجَّل أو الـ IP أو متصفح المستخدم مفقود أو غير صحيح. |
| 3 | **EN:** Log filters / cleanup not working<br>**AR:** فلاتر / تنظيف السجل لا يعمل | **EN:** Filtering the audit trail returns wrong results, or old-record cleanup fails.<br>**AR:** فلترة سجل التدقيق تُرجع نتائج خاطئة، أو يفشل تنظيف السجلات القديمة. |

---

# C. CRM | إدارة علاقات العملاء

## 26. Contact Us / Leads Inbox | صندوق التواصل والعملاء المحتملون

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** New lead not appearing in the inbox<br>**AR:** عميل محتمل جديد لا يظهر في الصندوق | **EN:** A contact submission did not create a visible lead — check form flow and CRM permissions.<br>**AR:** رسالة تواصل لم تُنشئ عميلًا محتملًا ظاهرًا — تحقق من مسار النموذج وصلاحيات CRM. |
| 2 | **EN:** Cannot assign / unassign an agent<br>**AR:** تعذّر إسناد / إلغاء إسناد وكيل | **EN:** Agent assignment fails or does not save on a lead.<br>**AR:** يفشل إسناد الوكيل أو لا يُحفظ على العميل المحتمل. |
| 3 | **EN:** Status update / internal note not saving<br>**AR:** تحديث الحالة / الملاحظة الداخلية لا يُحفظ | **EN:** Lead status change, note, or threaded comment does not persist.<br>**AR:** تغيير حالة العميل أو الملاحظة أو التعليق لا يُحفظ. |
| 4 | **EN:** Email reply to customer not sent / not logged<br>**AR:** رد البريد للعميل لم يُرسَل / لم يُسجَّل | **EN:** Replying from the inbox does not deliver the email or does not log the reply.<br>**AR:** الرد من الصندوق لا يوصل البريد أو لا يسجّل الرد. |

## 27. Favourites Management (CRM) | إدارة المفضلة

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Favourites live search returns nothing<br>**AR:** البحث الفوري في المفضلة لا يُرجع نتائج | **EN:** Searching favourites lists in CRM returns empty despite existing records.<br>**AR:** البحث في قوائم المفضلة داخل CRM يُرجع فارغًا رغم وجود سجلات. |
| 2 | **EN:** Favourites report (Excel) export fails<br>**AR:** فشل تصدير تقرير المفضلة (Excel) | **EN:** `FavouritesReportExport` download fails, times out, or has broken Arabic encoding.<br>**AR:** يفشل تنزيل `FavouritesReportExport` أو ينتهي وقته أو يظهر ترميز عربي تالف. |
| 3 | **EN:** Send-email / send-notification to visitor fails<br>**AR:** إرسال البريد / الإشعار للزائر يفشل | **EN:** The email or notification flow for a favourites list does not reach the visitor.<br>**AR:** مسار البريد أو الإشعار لقائمة المفضلة لا يصل إلى الزائر. |
| 4 | **EN:** Cannot edit visitor info / delete an item<br>**AR:** تعذّر تعديل بيانات الزائر / حذف عنصر | **EN:** Editing user info or deleting an item from a favourites list fails to save.<br>**AR:** تعديل بيانات المستخدم أو حذف عنصر من قائمة المفضلة لا يُحفظ. |

## 28. Agents | الوكلاء / المندوبون

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Cannot create / edit an agent<br>**AR:** تعذّر إنشاء / تعديل وكيل | **EN:** Agent record creation or update fails due to validation or permissions.<br>**AR:** يفشل إنشاء أو تحديث سجل الوكيل بسبب التحقق أو الصلاحيات. |
| 2 | **EN:** Deleted agent still assigned to leads<br>**AR:** وكيل محذوف ما زال مُسنَدًا لعملاء محتملين | **EN:** A soft-deleted agent remains referenced on existing leads/favourites, causing display issues.<br>**AR:** وكيل محذوف مؤقتًا ما زال مرجعًا على عملاء/مفضلات قائمة، مما يسبب مشاكل عرض. |
| 3 | **EN:** Agent list not reflecting recent changes<br>**AR:** قائمة الوكلاء لا تعكس التغييرات الأخيرة | **EN:** Newly added or edited agents do not appear promptly in dropdowns.<br>**AR:** الوكلاء المضافون أو المعدّلون حديثًا لا يظهرون فورًا في القوائم المنسدلة. |

## 29. Job Postings (CRM) | إعلانات الوظائف

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Published job not shown on public careers page<br>**AR:** وظيفة منشورة لا تظهر في صفحة الوظائف العامة | **EN:** A job posting created in CRM is missing publicly due to date window or active flag.<br>**AR:** إعلان وظيفة أُنشئ في CRM مفقود علنًا بسبب نافذة التاريخ أو علامة التفعيل. |
| 2 | **EN:** Job dates / window configured incorrectly<br>**AR:** تواريخ / نافذة الوظيفة مضبوطة بشكل خاطئ | **EN:** The registration start/end dates make the job open/close at the wrong time.<br>**AR:** تواريخ بدء/انتهاء التسجيل تجعل الوظيفة تفتح/تغلق في وقت خاطئ. |
| 3 | **EN:** Applications not linked to the right job<br>**AR:** الطلبات غير مرتبطة بالوظيفة الصحيحة | **EN:** Received applications are associated with the wrong job posting.<br>**AR:** الطلبات المستلمة مرتبطة بإعلان وظيفة خاطئ. |

---

# D. System / Technical | النظام والجوانب التقنية

## 30. Email & Notifications | البريد الإلكتروني والإشعارات

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Emails not sending at all<br>**AR:** البريد لا يُرسَل إطلاقًا | **EN:** No outgoing mail (contact, favourites, notifications) — SMTP credentials, mailer config, or queue worker down.<br>**AR:** لا بريد صادر (تواصل، مفضلة، إشعارات) — بيانات SMTP أو إعداد المرسل أو عامل الطابور متوقف. |
| 2 | **EN:** Emails go to spam / fail SPF/DKIM<br>**AR:** البريد يذهب إلى الغير مرغوب / يفشل SPF/DKIM | **EN:** Delivered emails land in spam due to missing SPF/DKIM/DMARC or a wrong from-address.<br>**AR:** يصل البريد إلى مجلد الغير مرغوب بسبب غياب SPF/DKIM/DMARC أو عنوان مُرسِل خاطئ. |
| 3 | **EN:** Email content unstyled / Arabic broken<br>**AR:** محتوى البريد بلا تنسيق / العربية مكسورة | **EN:** Mail template renders without CSS or with broken Arabic (RTL/encoding).<br>**AR:** يظهر قالب البريد بلا CSS أو بعربية مكسورة (RTL/ترميز). |

## 31. Exports (PDF / Excel) | التصدير

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** PDF export fails / times out<br>**AR:** تصدير PDF يفشل / ينتهي وقته | **EN:** dompdf/mpdf generation errors on large reports or memory limits.<br>**AR:** فشل توليد dompdf/mpdf للتقارير الكبيرة أو تجاوز حدود الذاكرة. |
| 2 | **EN:** PDF shows broken Arabic / missing fonts<br>**AR:** PDF يعرض عربية مكسورة / خطوط مفقودة | **EN:** Arabic text in the PDF is disconnected or squares — missing RTL-capable font.<br>**AR:** النص العربي في الـ PDF منفصل أو مربعات — خط داعم للـ RTL مفقود. |
| 3 | **EN:** Excel export empty / wrong columns<br>**AR:** تصدير Excel فارغ / أعمدة خاطئة | **EN:** Maatwebsite/Excel output is empty, misaligned, or has encoding issues.<br>**AR:** مخرجات Maatwebsite/Excel فارغة أو غير متوازنة أو بها مشاكل ترميز. |

## 32. Performance & Errors | الأداء والأخطاء

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** "500 Server Error" on a page<br>**AR:** "خطأ خادم 500" في صفحة | **EN:** An unhandled exception breaks a page; needs the log (`storage/logs/laravel.log`) to diagnose.<br>**AR:** استثناء غير معالَج يكسر صفحة؛ يلزم السجل (`storage/logs/laravel.log`) للتشخيص. |
| 2 | **EN:** Page very slow / high memory usage<br>**AR:** الصفحة بطيئة جدًا / استهلاك ذاكرة عالٍ | **EN:** Heavy listing/eager-loads or N+1 queries slow the page; see the memory optimization guide.<br>**AR:** قوائم ثقيلة أو تحميل مسبق أو استعلامات N+1 تبطئ الصفحة؛ راجع دليل تحسين الذاكرة. |
| 3 | **EN:** "419 / 429 / 403" errors on actions<br>**AR:** أخطاء "419 / 429 / 403" عند الإجراءات | **EN:** CSRF expiry (419), rate limit (429), or permission (403) blocks an action.<br>**AR:** انتهاء CSRF (419)، أو حد المعدل (429)، أو الصلاحية (403) يمنع الإجراء. |
| 4 | **EN:** Site down / white screen<br>**AR:** الموقع متوقف / شاشة بيضاء | **EN:** Complete outage — check server, DB connection, `.env`, and cached config.<br>**AR:** توقف كامل — تحقق من الخادم واتصال قاعدة البيانات و`.env` والإعدادات المخزّنة مؤقتًا. |

## 33. Under-Construction & Deployment | وضع الصيانة والنشر

| # | Issue / المشكلة | Description / الوصف |
|---|---|---|
| 1 | **EN:** Public site stuck on "Under Construction"<br>**AR:** الموقع العام عالق على "قيد الإنشاء" | **EN:** `UNDER_CONSTRUCTION=true` is still enabled; disable it in `.env`/`config/site.php` after deploy.<br>**AR:** ما زال `UNDER_CONSTRUCTION=true` مفعّلًا؛ عطّله في `.env`/`config/site.php` بعد النشر. |
| 2 | **EN:** Changes not live after deploy<br>**AR:** التغييرات لا تظهر بعد النشر | **EN:** Cached config/routes/views serve old content — run cache clear and rebuild assets.<br>**AR:** الإعدادات/المسارات/العروض المخزّنة مؤقتًا تقدّم محتوى قديمًا — امسح التخزين المؤقت وأعد بناء الأصول. |
| 3 | **EN:** Images / assets 404 after deploy<br>**AR:** الصور / الأصول تُظهر 404 بعد النشر | **EN:** Missing `php artisan storage:link` or unbuilt Vite assets after a fresh deploy.<br>**AR:** غياب `php artisan storage:link` أو أصول Vite غير مبنية بعد نشر جديد. |
| 4 | **EN:** A module appears disabled<br>**AR:** أحد الوحدات يبدو معطّلًا | **EN:** A module is turned off in `modules_statuses.json`, hiding its routes/features.<br>**AR:** وحدة مُعطّلة في `modules_statuses.json`، مما يخفي مساراتها/ميزاتها. |

---

## Notes | ملاحظات

- **EN:** For every ticket, set **Category = `SVEC Website`** and pick the matching **Sub-category** above. Paste the relevant **Issue** as the subject and expand the **Description** with the reporter's specifics (URL, screenshot, steps to reproduce, user role, language EN/AR).
- **AR:** لكل تذكرة، اضبط **الفئة = `موقع SVEC`** واختر **الفئة الفرعية** المطابقة أعلاه. انسخ **المشكلة** المناسبة كموضوع ووسّع **الوصف** بتفاصيل المُبلِّغ (الرابط، لقطة الشاشة، خطوات إعادة الإنتاج، دور المستخدم، اللغة إنجليزي/عربي).
