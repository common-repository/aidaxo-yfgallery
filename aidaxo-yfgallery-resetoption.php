<?php
/**
* Модуль сброса настроек
*
* @package YFGallery
* @copyright Copyright (c) 2010 Dmitriy Sazhin (http://www.aidaxo.ru)
* @version 1.0.4
*/
if(!defined("Aidaxo_YFGallery_resetOptions")) 
{
	header("HTTP/1.0 404 Not Found");
	die ("404 Not Found");
}

	$Options = array (
	"Aidaxo_YFGallery_idUser" => "",
	"Aidaxo_YFGallery_limit" => "",
	"Aidaxo_YFGallery_previewSize" => "",
	"Aidaxo_YFGallery_articleSize" => "",
	"Aidaxo_YFGallery_sortOutput" => "",
	"Aidaxo_YFGallery_showTitle" => "",
	"Aidaxo_YFGallery_articleTemplate" => "",
	"Aidaxo_YFGallery_feedTemplate" => "",
	"Aidaxo_YFGallery_idPhoto" => "",
	"Aidaxo_YFGallery_idAlbum" => "",
	"Aidaxo_YFGallery_templates" => "",
	"Aidaxo_YFGallery_enableShortcodeInSidebars" => "",
	"Aidaxo_YFGallery_version" => ""
	);
	
	echo "<UL>";
	foreach ($Options as $Option => $val)
	{
		delete_option( $Option );
		//echo "<li>Удалена опция $Option</li>";
	}
	echo "</UL>";
	echo "<p>Сброс опций произведен</p>";
	//восстановление заводских настроек
	aidaxoYFGalleryInstall();
	
?>