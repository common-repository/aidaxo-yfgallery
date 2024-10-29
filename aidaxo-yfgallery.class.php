<?php

/**
* Данный класс обеспечивает взаимодействие с API сервиса "Яндекс. Фотки".
*
* @package YFGallery
* @copyright Copyright (c) 2010 Dmitriy Sazhin (http://www.aidaxo.ru)
* @version 1.0.4
*/

class YFG_Core
{
	/**
	* Дефолтные настройки плагина
	*
	* @var static array
	*/
	private static $_defaultOptions = array (
		'idUser' => 'aidaxoru',
		'limit' => 0,
		'previewSize' => 'XS',
		'articleSize' => 'L',
		'sortOutput' => 'published',
		'showTitle' => true,
		'articleTemplate' => null,
		'feedTemplate' => null,
		'idPhoto' => null,
		'idAlbum' => null
	);
	
	
	/**
	* Имя пользователя на сайте Яндекс.Фотки
	*
	* @var string
	*/
	private $_idUser;
	
	
	/**
	* Путь к данным XML API пользователя на сайте Яндекс.Фотки
	*
	* @var string
	*/
	private $_userPath;
	
	
	/**
	* Количество выводимых изображений
	* 0 - без лимита
	* limit range 1-100
	*
	* @var integer
	*/	
	private $_limit;
		
		

	/**
	* Размер изображения для превью
	* XXXS = 50px
	* XXS = 75px
	* XS = 100px
	* S = 150px
	* M = 300px
	* L = 500px
	* XL = 800px
	* orig = Оригинальный размер изображения
	* 
	* @var string
	*/	
	private $_previewSize;		
		
		
		
	/**
	* Размер изображения для полноразмерного отображения в статье
	* XXXS = 50px
	* XXS = 75px
	* XS = 100px
	* S = 150px
	* M = 300px
	* L = 500px
	* XL = 800px
	* orig = Оригинальный размер изображения
	*
	* @var string
	*/	
	private $_articleSize;		
		
	/**
	* Сортировка вывода
	* updated  - по времени последнего изменения, от новых к старым;
	* rupdated - по времени последнего изменения, от старых к новым;
	* published - по времени загрузки (для фотографии) или создания (для альбома), от новых к старым;
	* rpublished - по времени загрузки (для фотографии) или создания (для альбома), от старых к новым;
	* created - по времени создания согласно EXIF-данным, от новых к старым (только для фотографий);
	* rcreated - по времени создания согласно EXIF-данным, от старых к новым (только для фотографий).
	* Точность времени относительно мала, поэтому в коллекции могут появляться элементы с одинаковым временем создания
	*
	* @var string
	*/	
	private $_sortOutput;
	
	
	/**
	* Отображение подписей к изображениям
	*
	* @var boolean
	*/	
	private $_showTitle;
	
	
	
	/**
	* Конструктор
	* 
	* @param string $idUser
	* @param integer $limit
	* @param string $previewSize
	* @param string $articleSize
	* @param string $sortOutput
	* @param boolean $showTitle
	* @return void
	*/
	public function __construct ($idUser = null, $limit = null, $previewSize = null, $articleSize = null, $sortOutput = null, $showTitle = null)
	{
		$this->setIdUser ( $idUser );
		$this->setLimit ( $limit );
		$this->setPreviewSize ( $previewSize );
		$this->setArticleSize ( $articleSize );
		$this->setSortOutput ( $sortOutput );
		$this->setShowTitle ( $showTitle );
	}
	
	
	/**
	* Возвращает предустановленные значения опции
	* 
	* @param string $optionName
	* @return mixed
	*/
	public static function getDefaultPluginOption ( $optionName )
	{
		return ( !empty( self::$_defaultOptions[$optionName] ) )?
		( self::$_defaultOptions[$optionName] ):
		( null );
	}
	

	/**
	* Возвращает значения опции, установленные пользователем в настройках плагина
	* 
	* @param string $optionName
	* @return mixed
	*/
	public static function getPluginOption ( $optionName )
	{
		$Option = get_option('Aidaxo_YFGallery_' . $optionName);

		return ( !empty( $Option ) )?
		( $Option ):
		( self::getDefaultPluginOption ( $optionName ) );
	}


	/**
	* Устанавливает значение сортировки вывода
	* 
	* @param string $sortOutput
	* @return void
	*/
	public function setSortOutput ( $sortOutput = null )
	{
		$this->_sortOutput = ($sortOutput == null) ? self::getPluginOption('sortOutput') : $sortOutput;
	}

	/**
	* Возвращает значение сортировки вывода
	* 
	* @return string
	*/
	public function getSortOutput  ()
	{
		return $this->_sortOutput;
	}		
	
	
	/**
	* Устанавливает значение флага отображения подписей к изображениям
	* 
	* @param boolean $showTitle
	* @return void
	*/
	public function setShowTitle ( $showTitle = null )
	{
		$this->_showTitle = (bool)(($showTitle == null) ? self::getPluginOption('showTitle') : $showTitle );
	}	
	
	
	
	/**
	* Возвращает флаг отображения подписей к изображениям
	* 
	* @return boolean
	*/
	public function getShowTitle  ()
	{
		return $this->_showTitle;
	}	
	


	

	
	/**
	* Устанавливает значение размера для превью изображений
	* 
	* @param string $previewSize
	* @return void
	*/
	public function setPreviewSize ( $previewSize = null )
	{
		$this->_previewSize = ($previewSize == null) ? self::getPluginOption('previewSize') : $previewSize;
	}
	
	/**
	* Возвращает значение размера для превью изображений
	* 
	* @return string
	*/	
	public function getPreviewSize ()
	{
		return $this->_previewSize;
	}

	/**
	* Устанавливает значение размера для изображений, выводимых в теле статьи
	* 
	* @param string $articleSize
	* @return void
	*/	
	public function setArticleSize ( $articleSize = null )
	{
		$this->_articleSize = ($articleSize == null) ? self::getPluginOption('articleSize') : $articleSize;
	}
	
	/**
	* Возвращает значение размера для изображений, выводимых в теле статьи
	* 
	* @return string
	*/		
	public function getArticleSize ()
	{
		return $this->_articleSize;
	}	


	/**
	* Устанавливает имя пользователя
	* 
	* @param string $idUser
	* @return void
	*/
	public function setIdUser( $idUser = null )
	{
		/* использовать общие настройки, если не указаны местные*/
		$this->_idUser = ( ($idUser == null)?(self::getPluginOption('idUser')):($idUser) );
		$this->_userPath = 'http://api-fotki.yandex.ru/api/users/' . $this->_idUser . '/';
	}	
	
	/**
	* Возвращает имя пользователя
	* 
	* @return string
	*/	
	public function getIdUser ()
	{
		return $this->_idUser;
	}	
	
	/**
	* Устанавливает количество выводимых изображений
	* 
	* @param string $limit
	* @return void
	*/	
	public function setLimit ( $limit = null )
	{
		$this->_limit = intval( ($limit == null) ? self::getPluginOption('limit') : $limit );
	}
	
	/**
	* Возвращает количество выводимых изображений
	* 
	* @return integer
	*/		
	public function getLimit ()
	{
		return intval( $this->_limit );
	}	
	

	/**
	* Обработчик массива фотографий по умолчанию.
	* Возвращает HTML список без открывающих и закрывающих тегов. 
	* 
	* @param array $photos
	* @return string
	*/
	public function getDefaultListPhotos ( $photos )
	{
		$OutBuffer = '';
		
		foreach ($photos as $Photo) 
		{
			$OutBuffer .= '<li><a href="'.$Photo['linkYandexImagePage'].'"><img src="'.$Photo['previewSizeLink'].'" alt="'.$Photo['title'].'" title="'.$Photo['title'].'" /></a>';
			/* Проверка на показ комментов*/
			$OutBuffer .= (( $this->getShowTitle() )?('<p>' . $Photo['title'] . '</p></li>'):('</li>'));
		}
		
		return '<UL>' . $OutBuffer . '</UL>';
	}	
	
	/**
	* Обработчик массива фотографий на основе пользовательских шаблонов.
	* Принимает массив фотографий ($photos) и массив шаблона ($template)
	* Возвращает форматированный шаблон (HTML).
	* 
	* @param array $photos
	* @param array $template
	* @return string
	*/
	public function getListPhotos ( $photos, $template = '')
	{
		if (empty ($template) OR $template == '')
			return $this->getDefaultListPhotos ( $photos );
		
		$SearchParams = array(
		"%id%", 
		"%title%", 
		"%previewSizeLink%", 
		"%articleSizeLink%", 
		"%originalSizeLink%", 
		"%linkYandexImagePage%"
		);
			
		$OutBuffer = $template["templateHeader"];
					
		foreach ($photos as $Photo) 
		{
			$ReplaceParams = array (
			$Photo["id"], 
			( ( $this->getShowTitle() )?( $Photo['title'] ):( null ) ), /* Проверка на показ комментов*/
			$Photo["previewSizeLink"], 
			$Photo["articleSizeLink"], 
			$Photo["originalSizeLink"], 
			$Photo["linkYandexImagePage"]
			);
			$OutBuffer .= str_replace($SearchParams, $ReplaceParams, $template["templateBody"]);
			
			unset($ReplaceParams);
		}
		
		$OutBuffer .= $template["templateFooter"];
		
		//не забываем убирать экранирующие слеши
		return stripslashes( $OutBuffer );
	}		
	
	
	
	
	
	
	/**
	* Возвращает массив альбомов пользователя
	*
	* @param integer $limit
	* @param string $sort
	* @return array
	*/
	public function getAlbums ( $limit = null, $sort = "published" )
	{
		$albumsPath = $this->_userPath . 'albums/' . $sort . '/' . ( ($limit > 0)?('?limit=' . $limit):('') );

        $Feed = simplexml_load_file($albumsPath);
		
		if ( empty($Feed) ) return array();
		
		$entries = $Feed->children('http://www.w3.org/2005/Atom')->entry;
		$result = array();
        
        foreach ($entries as $entry) 
		{
            $details = $entry->children('http://www.w3.org/2005/Atom');
            $content = $details->content->attributes();
            
            $result[] = array(
                'id' => preg_replace('/.*:(\d+)$/', '\1', $details->id),
                'title' => $details->title
            );
        }
        
        return $result;
	}
	


	/**
	* Возвращает одно изображение
	*
	* @param integer $idPhoto
	* @return array
	*/
	public function getPhoto ($idPhoto = null)
	{
		$Entry = array();
        /* http://api-fotki.yandex.ru/api/users/aidaxoru/photo/231114/*/
		$photoPath = $this->_userPath . 'photo/' . ( ($idPhoto == null)?( self::getDefaultPluginOption('idPhoto') ):( $idPhoto ) ) . '/';
		$AtomFeedContent  = "";
		
		$cUrl = curl_init();
		
		if ( ($AtomFeedContent = self::getContentFromURL($cUrl, $photoPath) ) === false) 
			return false;
			
		curl_close($cUrl);

		$AtomFeedContent = '<feed xmlns="http://www.w3.org/2005/Atom" xmlns:app="http://www.w3.org/2007/app" xmlns:f="yandex:fotki">
		  <id>urn:yandex:fotki:aidaxoru:photos</id>
		  <author>
		    <name>aidaxoru</name>
		  </author>
		  <title>aidaxoru на Яндекс.Фотках</title>
		  <updated>2010-03-30T18:26:20Z</updated>
		  <link href="http://api-fotki.yandex.ru/api/users/aidaxoru/photos/" rel="self" />
		  <link href="http://fotki.yandex.ru/users/aidaxoru/" rel="alternate" />
		' . $AtomFeedContent .'
		</feed>';
		
        $Feed = simplexml_load_string($AtomFeedContent);
        $Entry[] = $Feed->children('http://www.w3.org/2005/Atom')->entry;
        
		return $this->parsePhotoEntriesInAtomFeed ($Entry);
        
	}		
	
	
	
	/**
	* Возвращает массив с результатом преобразования Atom Feed XML
	*
	* @param array $entriesArray
	* @return array
	*/
	private function parsePhotoEntriesInAtomFeed ($entriesArray)
	{
		$Result = array();
		$Counter = 0;
		$Limit = $this->getLimit();
		
		foreach ($entriesArray as $entries) 
		{
	        foreach ($entries as $Entry) 
			{
				$Counter++;
				$Details = $Entry->children('http://www.w3.org/2005/Atom');
				$ImageSrc = $Details->content->attributes()->src;
				
				$Result[] = array (
					'id' => $Details->id,
					'title' => $Details->title,
					'previewSizeLink' => preg_replace('/(.*)((_|-)+)(\w{1,4})$/', '$1$2' . $this->getPreviewSize(), $ImageSrc),
					'articleSizeLink' => preg_replace('/(.*)((_|-)+)(\w{1,4})$/', '$1$2' . $this->getArticleSize(), $ImageSrc),
					'originalSizeLink' => preg_replace('/(.*)((_|-)+)(\w{1,4})$/', '$1$2orig', $ImageSrc),
					'linkYandexImagePage' => $Details->link[2]->attributes()->href
				);
				
				//добавлено для исключения ошибки вывода полного альбома, вызванной игнором параметра limit на стороне Яндекса (обнаружено 16.06.2010)
				if ($Limit != 0 AND $Counter == $Limit) return $Result;
			}
		}
		
		return $Result;
	}	
	
	

	/**
	* Получение контента с заданного URL
	*
	* @param $cUrl
	* @param $url
	* @param $port
	* @param $timeout
	* @param $errCount
	* @return array
	*/	 
	public static function getContentFromURL(& $cUrl, $url, $port = 80, $timeout = 5, $errCount = 1)
	{
	    curl_setopt($cUrl, CURLOPT_URL, $url);
	    curl_setopt($cUrl, CURLOPT_PORT, $port);
	    curl_setopt($cUrl, CURLOPT_RETURNTRANSFER,1);
	    curl_setopt($cUrl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727)");
	    curl_setopt($cUrl, CURLOPT_TIMEOUT, $timeout);
	    $Content = curl_exec($cUrl);

	    if (curl_getinfo($cUrl,CURLINFO_HTTP_CODE) != 200)
	        return (($errCount < 2) ? self::getContentFromURL($cUrl, $url, $port, $timeout, ++$errCount) : false);
		else
	        return $Content;
	}	
	
	
	
	/**
	* Возвращает все изображения в указанном альбоме или все изображения изо всех альбомов, если $idAlbum опущен
	*
	* @param integer $idAlbum
	* @return array
	*/
	public function getPhotos ($idAlbum = null)
	{
		$Limit = $this->getLimit();

		$PhotosPath = ($idAlbum == null)?
		/* возвращаем общую коллекцию фотографий*/
		( $this->_userPath . 'photos/' . ($this->getSortOutput()) . '/' . ( ($Limit > 0)?('?limit=' . $Limit):('') ) ):
		/* возвращаем коллекцию фотографий из указанного альбома*/
		( $this->_userPath . 'album/' . $idAlbum . '/photos/' . ($this->getSortOutput()) . '/' . ( ($Limit > 0)?('?limit=' . $Limit):('') ) );
		
		$Entries = array();
		
		if ($Limit == 0)
		{
			/* получаем информацию со всех страниц, если нет лимита*/
			while ( !empty($PhotosPath) )
			{
				$Feed = simplexml_load_file($PhotosPath);
				$Entries[] = $Feed->children('http://www.w3.org/2005/Atom')->entry;
				
				/* получение линка на следующую коллекцию*/
				$Links = $Feed->link;
				foreach ($Links as $Link) 
				{
					if ($Link->attributes()->rel == "next")
						$PhotosPath = $Link->attributes()->href;
					else
						$PhotosPath = null;
				}
			}
		}
		else
		{
			$Feed = simplexml_load_file($PhotosPath);
			$Entries[] = $Feed->children('http://www.w3.org/2005/Atom')->entry;
		}
		
		return $this->parsePhotoEntriesInAtomFeed ($Entries);
	}

}

?>
