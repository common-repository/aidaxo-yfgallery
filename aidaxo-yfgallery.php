<?php
/*
	Plugin Name: Aidaxo YFGallery
	Plugin URI: http://www.aidaxo.ru/projects/yfgallery/
	Description: YFGallery позволяет добавлять изображения и целые альбомы изображений, размещенные на фотохостинге "Яндекс.Фотки", в записи, страницы и сайдбар-блоки вашего блога на WordPress. Об использования тега <code>[yfgallery]</code> в ваших статьях, о добавлении собственных шаблонов вывода и другом, Вы можете узнать подробнее, прочитав <a href="http://www.aidaxo.ru/projects/yfgallery/" target="_blank">YFGallery FAQ</a>.
	Author: Sazhin Dmitriy (aka Aidaxo)
	Version: 1.0.4
	Author URI: http://www.aidaxo.ru/

	Instalation:
	1. Upload to your plugins folder, usually "wp-content/plugins/" and unzip the file, it will create a "wp-content/plugins/aidaxo-yfgallery/" directory.
	2. Activate the plugin on the plugin screen.
	3. Go to "YFGallery" administration menu.

	Requests:
	* PHP5
	* SimpleXML
	* CURL Extension

	Using:
	Paste the tag [yfgallery ...and params...] in your article|page|sidebar.

*/

//error_reporting(E_ALL);
//ini_set("display_errors", 1);

define( 'AIDAXO_ABSPATH', dirname(__FILE__) . '/' );

require_once 'aidaxo-yfgallery.class.php';

//Регистрация обработчика установки плагина
register_activation_hook(__FILE__, 'aidaxoYFGalleryInstall');

//Инициализирует кнопку быстрой вставки тега [yfgallery] в панель иснструментов стандартного редактора записей.
add_action('admin_head','aidaxoYFGalleryAddShortcodeButtonInStdEditor');

//Регистрация обработчика тега [yfgallery] в системе 
add_shortcode('yfgallery', 'aidaxoYFGalleryShortcodeEngine');



//подключает шаблон в шапку каждой страницы
if ( (bool)YFG_Core::getPluginOption( 'metaInfoEnabled' ) )
{
	add_action('wp_head',  'aidaxoYFGallery_head' );
}

function aidaxoYFGallery_head ()
{
	wp_enqueue_script( 'yfgalleryhead' );
	echo stripslashes( YFG_Core::getPluginOption( 'metaInfoContent' ) );
}


//Включает объявление обработчика  тега [yfgallery] для текстовых виджетов
if ( YFG_Core::getPluginOption('enableShortcodeInSidebars') )
{
	add_filter('widget_text', 'do_shortcode');
}

//Запускает инициализацию раздела управления плагином "YFGallery" в административном меню.
if(is_admin())
{
    add_action('admin_menu', 'aidaxoYFGallery_options');
}


/**
 * Инициализирует раздел управления плагином "YFGallery" в административном меню.
 *
 * @return void
 */
function aidaxoYFGallery_options() {
	add_menu_page('YFGallery', 'YFGallery', 8, basename(__FILE__), 'aidaxoYFGalleryOptionsPage');
	add_submenu_page(basename(__FILE__), 'Настройки', 'Настройки', 8, basename(__FILE__), 'aidaxoYFGalleryOptionsPage');
    add_submenu_page(basename(__FILE__), 'Шаблоны', 'Шаблоны', 8, basename(__FILE__) . 'templates', 'aidaxoYFGalleryTemplatesPage');
    add_submenu_page(basename(__FILE__), 'Кэширование', 'Кэширование', 8, basename(__FILE__) . 'cache', 'aidaxoYFGalleryCachePage');
    add_submenu_page(basename(__FILE__), 'Шаблон шапки', 'Шаблон шапки', 8, basename(__FILE__) . 'header', 'aidaxoYFGalleryHeaderPage');
    add_submenu_page(basename(__FILE__), 'Tag-Мастер', 'Tag-Мастер', 8, basename(__FILE__) . 'wizard', 'aidaxoYFGalleryWizardPage');
    add_submenu_page(basename(__FILE__), 'FAQ', 'FAQ', 8, basename(__FILE__) . 'faq', 'aidaxoYFGalleryFAQPage');
}


/**
 * Подключение страницы "Настройки"
 *
 * @return void
 */
function aidaxoYFGalleryOptionsPage () 
{
	require_once ( AIDAXO_ABSPATH . 'admin/settings.php');
}

/**
 * Подключение страницы "Шаблоны"
 *
 * @return void
 */
function aidaxoYFGalleryTemplatesPage () 
{
	require_once ( AIDAXO_ABSPATH . 'admin/templates.php');
}


/**
 * Подключение страницы "Кэширование"
 *
 * @return void
 */
function aidaxoYFGalleryCachePage () 
{
	require_once ( AIDAXO_ABSPATH . 'admin/cache.php' );
}


/**
 * Подключение страницы шапки
 *
 * @return void
 */
function aidaxoYFGalleryHeaderPage () 
{
	require_once ( AIDAXO_ABSPATH . 'admin/header.php');
}


/**
 * Подключение страницы "Мастера"
 *
 * @return void
 */
function aidaxoYFGalleryWizardPage () 
{
	require_once ( AIDAXO_ABSPATH . 'admin/wizard.php');
}


/**
 * Подключение страницы "FAQ"
 *
 * @return void
 */
function aidaxoYFGalleryFAQPage () 
{
	require_once ( AIDAXO_ABSPATH . 'admin/faq.php');
}


/**
 * Добавляет кнопку быстрой вставки тега [yfgallery] в панель иснструментов стандартного редактора записей.
 *
 * @return void
 */
function aidaxoYFGalleryAddShortcodeButtonInStdEditor()
{
	if ( preg_match('~post(-new)?.php~',$_SERVER['REQUEST_URI']) )
	{
		wp_print_scripts( 'quicktags' );
		echo "<script type=\"text/javascript\">"."\n";
		echo "/* <![CDATA[ */"."\n";
		echo "edButtons[edButtons.length] = new edButton"."\n";
		echo "\t('ed_aidaxoyfgallery',"."\n";
		echo "\t'YFGallery'"."\n";
		echo "\t,'[yfgallery mode=\"\"]'"."\n";
		echo "\t,''"."\n";
		echo "\t,'n'"."\n";
		echo "\t);"."\n";
		echo "/* ]]> */"."\n";
		echo "</script>"."\n";
	}
}



/**
 * Обработчик тега [yfgallery] 
 *
 * @return void
 */
function aidaxoYFGalleryShortcodeEngine($atts)
{

	//буфер вывода
	$OutBuffer = "";
	
	//получение переданых пользователем параметров
	extract(shortcode_atts(array(
		'iduser' => null,
		'show' => null,
		'atemplate' => null,
		'ftemplate' => null,
		'idalbum' => null,
		'idphoto' => null,
		'limit' => null,
		'psize' => null,
		'asize' => null,
		'showtitle' => null,
		'sort' => null,
		'cache' => null,
	), $atts));


	try 
	{
			
		$Templates = unserialize( YFG_Core::getPluginOption('templates') );
		
		//устанавливаем активацию кэша
		$CacheEnabled = false;
		if ( (bool)YFG_Core::getPluginOption( 'cacheEnabled' ) )
			$CacheEnabled = ( $cache == "0" OR $cache == "disabled")?(false):(true);
				
		
		switch ($show)
		{
			case "single": 
			
				if (empty($idphoto)) throw new Exception('Не указан обязательный параметр idphoto');
				
				$YFG_Core = new YFG_Core( $iduser, null, $psize, $asize, null, $showtitle );
				
				/* подстановка требуемого шаблона, если вывод производится в фид */
				$ActualTemplate = ( is_feed() )?( $ftemplate ):( $atemplate );
				

				//проверяем активность кэша в настройках плагина
				if ( $CacheEnabled )
				{
					
					
					$CacheTemplateFileName = md5 ($iduser . $show . $atemplate . $ftemplate . $idalbum . $idphoto . $limit . $psize . $asize . $showtitle . $sort . $cache);

					$CacheFilesPath = AIDAXO_ABSPATH . "cache/single_" . $idphoto . "_" . $CacheTemplateFileName . ".htm";
					
					//если файл имеется в кеше, то выводим его
					if ( @file_exists( $CacheFilesPath ) AND ( filemtime( $CacheFilesPath ) + intval( YFG_Core::getPluginOption( 'cacheRefreshInterval' ) ) > time() ) AND @is_readable( $CacheFilesPath ) )
					{
						//вывод файла кэша в OutBuffer
						$OutBuffer = file_get_contents( $CacheFilesPath );
					}
					else //файла нет в кэше
					{
						/* если указан шаблон и такой шаблон существует, то используем его */
						if ( !empty($ActualTemplate) AND !empty($Templates[$ActualTemplate]) )
							$OutBuffer .= $YFG_Core->getListPhotos ( $YFG_Core->getPhoto( $idphoto ), $Templates[$ActualTemplate] );
						else /* используем станлартный вывод */
							$OutBuffer .= $YFG_Core->getListPhotos ( $YFG_Core->getPhoto( $idphoto ) );
						
						//сохраняем в кэш
						file_put_contents ($CacheFilesPath, $OutBuffer);
					}
				}
				else //кэширование отключено
				{
					/* если указан шаблон и такой шаблон существует, то используем его */
					if ( !empty($ActualTemplate) AND !empty($Templates[$ActualTemplate]) )
						$OutBuffer .= $YFG_Core->getListPhotos ( $YFG_Core->getPhoto( $idphoto ), $Templates[$ActualTemplate] );
					else /* используем станлартный вывод */
						$OutBuffer .= $YFG_Core->getListPhotos ( $YFG_Core->getPhoto( $idphoto ) );
				}
				
				break;

			case "album":
				
				//if (empty($idalbum)) throw new Exception('<p>Не указан обязательный параметр idalbum</p>.');
				
				$YFG_Core = new YFG_Core( $iduser, $limit, $psize, $asize, $sort, $showtitle );
				
				/* подстановка требуемого шаблона, если вывод производится в фид */
				$ActualTemplate = ( is_feed() )?( $ftemplate ):( $atemplate );
				

				//проверяем активность кэша в настройках плагина
				if ( $CacheEnabled )
				{
					$CacheTemplateFileName = md5 ($iduser . $show . $atemplate . $ftemplate . $idalbum . $idphoto . $limit . $psize . $asize . $showtitle . $sort . $cache);
									
					$CacheFilesPath = AIDAXO_ABSPATH . "cache/album_" . $idalbum . "_" . $CacheTemplateFileName . ".htm";
					
					
					
					//если файл имеется в кеше, он доступен для чтения и не просрочен, то выводим его
					if ( @file_exists( $CacheFilesPath ) AND ( filemtime( $CacheFilesPath ) + intval( YFG_Core::getPluginOption( 'cacheRefreshInterval' ) ) > time() ) AND @is_readable( $CacheFilesPath ) )
					{
						//вывод файла кэша в OutBuffer
						$OutBuffer = file_get_contents( $CacheFilesPath );
					}
					else //файла нет в кэше или просрочен
					{
						/* если указан шаблон и такой шаблон существует, то используем его */
						if ( !empty($ActualTemplate) AND !empty($Templates[$ActualTemplate]) )
							$OutBuffer .= $YFG_Core->getListPhotos ( $YFG_Core->getPhotos( $idalbum ), $Templates[$ActualTemplate] );
						else /* используем стандартный вывод */
							$OutBuffer .= $YFG_Core->getListPhotos ( $YFG_Core->getPhotos( $idalbum ) );
			
						//сохраняем в кэш
						file_put_contents ($CacheFilesPath, $OutBuffer);
					}
				}
				else //кэширование отключено
				{
					/* если указан шаблон и такой шаблон существует, то используем его */
					if ( !empty($ActualTemplate) AND !empty($Templates[$ActualTemplate]) )
						$OutBuffer .= $YFG_Core->getListPhotos ( $YFG_Core->getPhotos( $idalbum ), $Templates[$ActualTemplate] );
					else /* используем стандартный вывод */
						$OutBuffer .= $YFG_Core->getListPhotos ( $YFG_Core->getPhotos( $idalbum ) );
				}
					
				break;
				
			default: 
				throw new Exception('Отсутствует обязательный параметр show');
				break;
		}
		
		
	} 
	catch (Exception $e) 
	{
		$OutBuffer .= "<p>Возникла исключительная ситуация: <em>" . $e->getMessage() . "</em></p>\n";
	}
	
	$AuthorString = '<div id="aidaxo_yfgallery" style="display: none">
	<a href="http://www.aidaxo.ru/projects/yfgallery/" target="_blank" title="Плагин Aidaxo YFGallery - Яндекс.Фотки в вашем блоге на Wordpress">Официальный сайт плагина Aidaxo YFGallery</a>
	<a href="http://www.aidaxo.ru/" target="_blank" title="Официальный сайт Дмитрия Сажина aka Aidaxo (Dmitriy Sazhin aka Aidaxo)">Официальный сайт Дмитрия Сажина (Dmitriy Sazhin)</a>
	</div>';
	
	return $OutBuffer . $AuthorString;
}

/**
 * Подключение функций установщика плагина
 *
 * @return void
 */
function aidaxoYFGalleryInstall () 
{
	define("Aidaxo_YFGallery_initInstall", true);
	require_once( dirname(__FILE__) . "/aidaxo-yfgallery-installer.php" );
}

function aidaxoYFGalleryReset () 
{
	define("Aidaxo_YFGallery_resetOptions", true);
	require_once( dirname(__FILE__) . "/aidaxo-yfgallery-resetoption.php" );
}

/**
* Возвращает значение для выделения элемента HTML формы
*
* @param mixed $fValue
* @param mixed $sValue
* @param string $checkType
* @return string
*/
function setSelectedFlag ($fValue, $sValue, $checkType = 'selected')
{
	return ($fValue == $sValue) ? $checkType . '="' . $checkType . '"': '';
}

?>