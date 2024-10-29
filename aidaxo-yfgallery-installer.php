<?php
/**
* Модуль установки плагина
*
* @package YFGallery
* @copyright Copyright (c) 2010 Dmitriy Sazhin (http://www.aidaxo.ru)
* @version 1.0.4
*/
if(!defined("Aidaxo_YFGallery_initInstall")) 
{
	header("HTTP/1.0 404 Not Found");
	die ("404 Not Found");
}

	$CurrentVersion = get_option("Aidaxo_YFGallery_version");
	

	/* плагин устанавливается впервые */
	if($CurrentVersion == '')
	{
		add_option( "Aidaxo_YFGallery_idUser", "aidaxoru" );
		add_option( "Aidaxo_YFGallery_limit", 3 );
		add_option( "Aidaxo_YFGallery_previewSize", "XS" );
		add_option( "Aidaxo_YFGallery_articleSize", "L" );
		add_option( "Aidaxo_YFGallery_sortOutput", "published" );
		add_option( "Aidaxo_YFGallery_showTitle", true );
		add_option( "Aidaxo_YFGallery_articleTemplate", null );
		add_option( "Aidaxo_YFGallery_feedTemplate", null );
		add_option( "Aidaxo_YFGallery_idPhoto", null );
		add_option( "Aidaxo_YFGallery_idAlbum", null );
		
		$Templates["demotemplate"]["templateName"] = "demotemplate";
		$Templates["demotemplate"]["templateTitle"] = "Демонстрационный шаблон";
		$Templates["demotemplate"]["templateHeader"] = "<UL>";
		$Templates["demotemplate"]["templateBody"] = "<li><img src=\"%previewSizeLink%\"><BR/><em>%title%</em></li>";
		$Templates["demotemplate"]["templateFooter"] = "</UL>";
		
		add_option( "Aidaxo_YFGallery_templates", serialize ($Templates) );
		
		$CurrentVersion = '1.0.0';
		add_option("Aidaxo_YFGallery_version", $CurrentVersion);
	}
	
	//обновление до версии 1.0.1
	if($CurrentVersion == '1.0.0')
	{
		//Управляет обработкой тега [aidaxo_yfgallery] в сайдбарах
		add_option( "Aidaxo_YFGallery_enableShortcodeInSidebars", 1 );
		
		$CurrentVersion = '1.0.1';
		update_option("Aidaxo_YFGallery_version", $CurrentVersion);
	}

	//обновление до версии 1.0.2
	//добавлен визард по тегам альбомов
	if($CurrentVersion == '1.0.1')
	{
		//подключение информации между тегами HEAD
		add_option( "Aidaxo_YFGallery_metaInfoEnabled", 0 );
		add_option( "Aidaxo_YFGallery_metaInfoContent", "" );
		
		$CurrentVersion = '1.0.2';
		update_option("Aidaxo_YFGallery_version", $CurrentVersion);
	}	
	
	//обновление до версии 1.0.3
	if($CurrentVersion == '1.0.2')
	{
		//активация кэширования
		add_option( "Aidaxo_YFGallery_cacheEnabled", 0 );
		
		$CurrentVersion = '1.0.3';
		update_option("Aidaxo_YFGallery_version", $CurrentVersion);
	}	

	//обновление до версии 1.0.4
	if($CurrentVersion == '1.0.3')
	{
		//интервал обновления кэша в секундах (86400=сутки)
		add_option( "Aidaxo_YFGallery_cacheRefreshInterval", 86400 );
		
		$CurrentVersion = '1.0.4';
		update_option("Aidaxo_YFGallery_version", $CurrentVersion);
	}		
?>