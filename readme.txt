=== Aidaxo YFGallery (Яндекс.Фотки в Wordpress) ===
Contributors: aidaxo
Donate link: http://www.aidaxo.ru/projects/yfgallery/
Tags: yandex fotki, fotki, yandex, photos, gallery, litebox, images, sidebar, Яндекс фотки, Яндекс, фотки
Requires at least: 2.8
Tested up to: 3.0.1
Stable tag: trunk

This plugin will add single photos and photo albums published on Fotki.Yandex.ru Service in posts, pages and sidebar of your blog on WordPress.

== Description ==

This plugin will add single photos and photo albums published on Fotki.Yandex.ru Service in posts, pages and sidebar of your blog on WordPress. The plugin gives an opportunity to show images of any size from 75x100 px till original, to define sorting mode of image output, to create personal templates which allow easily to integrate any gallery or litebox scripts into your blog. Built-in XML-Atom data cashing system reduce the load, if your blog is very popular; frendly wizard will insert an interesting album for a few clicks only. Amount of photos and albums downloading to Fotki.Yandex.ru Service is unlimited, the Aidaxo YFGallery plugin will create comfortable and up-to-date media storage for minimum efforts.

Этот плагин позволяет добавлять единичные фотографии и целые альбомы фотографий, размещенные на фотохостинге Яндекс Фотки, в записи, страницы и сайдбар-блоки вашего блога на WordPress. Плагин дает возможность выводить изображения любого размера от 75х100 пикселей до оригинального, определять режим сортировки вывода фотографий, создавать персональные шаблоны, которые позволят легко интегрировать любую галерею или litebox в ваш блог. Встроенная система кэширования XML-Atom данных существенно снижает нагрузку при большой посещаемости страниц вашего блога, а специальный мастер позволит вам вставить интересный альбом за несколько кликов. Так как количество фотографий и альбомов, загружаемых на Fotki.Yandex.ru ограничено только вашими желаниями, то плагин Aidaxo YFGallery позволит создать удобное и современное медиа хранилище без малейших затрат.

== Installation ==

1. Upload aidaxo-yfgallery.zip to your plugins folder, usually wp-content/plugins/ and unzip the file, it will create a wp-content/plugins/yandex-fotki/ directory.
2. Activate the plugin on the plugin screen.
3. Go to "YFGallery" section in administration menu of your blog on WordPress.

== Screenshots ==

1. YFGallery Plugin Settings Menu in administration panel
2. General settings section
3. Template settings section
4. Shortcode receiving wizard for albums inserting
5. Scripts including section (header template)
6. Cashing manage section

== Changelog ==

= 1.0.4 =
* Добавлен параметр времени обновления кэша, который определяет интервал устаревания данных в кэше.
* Добавлено предупреждение об активности системы кэширования на странице редактирования шаблонов.
* Пункт меню «Подключение скриптов» переименован в «Шаблон шапки»
* Исправлена ошибка работы кэша, которая приводила к игнорированию дополнительных параметров у изображения или галереи, например, showtitle.

= 1.0.3 =
* Добавлена система файлового кэширования. После первой генерации тега, результат обработки помещается в статический кэш.
* Исправлена ошибка обработки тега в сайдбаре, если сайдбар выводился на главной странице, странице архива и некоторых других страницах.
* Получил 2010.06.28 ответ по limit от техподдержки Яндекса: «Возможную причину исправили. Уточните, пожалуйста, возникает ли проблема сейчас?». Проблема устранена, но обработчик пока оставил.

= 1.0.2 =
* Добавлен раздел «Tag-мастер», который позволяет получить готовый код для вставки альбомов в страницы и записи Вашего блога на WordPress.
* Добавлена возможность глобального подключения JavaScript и CSS файлов из панели администрирования, что дает возможность быстрого подключения litebox и/или JQuery галерей.
* Добавлен обработчик ситуации, когда параметр limit игнорируется сервером Яндекс.Фотки. Отправил вопрос по limit в техподдержку Яндекса (2010.06.17).

= 1.0.1 =
* Добавлен инсталлятор, позволяющий производить корректное обновление плагина
* Добавлена возможность сброса к «заводским» установкам
* Добавлено отключение обработчика тега [yfgallery] в области сайдбара (sidebar). Рекомендуется отлючить обработчик, если вы не используете тег [yfgallery] в боковых блоках
* Исправлена ошибка экранирования в header и footer шаблонов, которая приводила к невозможности указать параметры для HTML тегов.
* Исправлена ошибка, в результате которой в некоторых случаях игнорировался параметр ftemplate

= 1.0.0 =
* Базовый функционал
