<?php
$CacheFilesPath = AIDAXO_ABSPATH . "cache/";

if ( !empty($_POST["emptyCache"]) )
{
	removeFilesFromDir ( $CacheFilesPath );
}

$FilesInDir = getQuantityFilesInDir( $CacheFilesPath );

?>
<h3>Управление кэшированием</h3>
	<p class="description">Вы можете активировать кэширование, которое исключает повторные запросы XML-Atom данных с сервиса "Яндекс.Фотки", что снижает нагрузку на сервер и уменьшает время генерации страницы.</p>

	<form method="post" action="options.php">
    <?php wp_nonce_field('update-options'); ?>
	
	<p>Включить кэширование:
	<input type="checkbox" name="Aidaxo_YFGallery_cacheEnabled" value="1" <?php echo setSelectedFlag( true, (bool)YFG_Core::getPluginOption( 'cacheEnabled' ), 'checked' ); ?> /><br />
	</p>
	<p>Хранить в кэше:
	<input type="text" name="Aidaxo_YFGallery_cacheRefreshInterval" value="<?php echo intval( YFG_Core::getPluginOption( 'cacheRefreshInterval' ) ); ?>" />&nbsp;секунд.<br />
	</p>	
	<input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="Aidaxo_YFGallery_cacheEnabled,Aidaxo_YFGallery_cacheRefreshInterval" />
    <p class="submit">
		<input type="submit" name="Submit" class="button" value="Сохранить" />
	</p>
</form>




<p>Сейчас в кэше  <?php echo $FilesInDir["FilesCounter"]; ?> файлов, 
общим объемом <?php echo ceil($FilesInDir["SizeCounter"]/1024); ?> кБ.</p>


<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p class="submit">
		<input type="submit" name="emptyCache" class="button" value="Очистить кэш" onclick="javascript:return confirm('Будут удалены все файлы из кэша. Продолжить?')"/>
	</p>
</form>





<?php


function getQuantityFilesInDir ( $dirPath, $deleteFiles = false )
{
	$Out = array (
	"FilesCounter" => 0,
	"SizeCounter" => 0
	);

	//Проверяем, является ли директорией
	if (is_dir( $dirPath )) 
	{
		//Проверяем, была ли открыта директория
		if ($DirHandle = opendir($dirPath)) 
		{
			//Сканируем директорию
			while ( false !== ($File = readdir($DirHandle)) )
			{
				if ( is_file ( $dirPath . $File ) )
				{
					$Out["FilesCounter"]++;
					$Out["SizeCounter"] += filesize ( $dirPath . $File );
					if ( $deleteFiles ) unlink ( $dirPath . $File );
				}
			}
			//Закрываем директорию
			closedir($DirHandle);
		}
		else
			return false;
	}
	else
		return false;
	return $Out;
}



function removeFilesFromDir ( $dirPath )
{
	return  getQuantityFilesInDir ( $dirPath, true );
}



?>