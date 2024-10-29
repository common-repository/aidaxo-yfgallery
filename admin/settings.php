<?php 
//ЗАПРЕТИТЬ ПРЯМОЕ ОБРАЩЕНИЕ К ФАЙЛАМ
//прописать путь регистрации вместо http://fotki.yandex.ru/
//блок для восстановления станлартных настроек
	if ( !empty($_POST["action"]) AND $_POST["action"] == "resetOptions")
	{
		aidaxoYFGalleryReset();
	}

?>
<h3>Базовые настройки</h3>
	<p class="description">Указанные настройки будут использоваться по умолчанию, если не указано другое.</p>
	<form method="post" action="options.php">
	<?php wp_nonce_field('update-options'); ?>
	
    <div>
		Введите имя (iduser)* <input type="text" name="Aidaxo_YFGallery_idUser" 
		value="<?php echo YFG_Core::getPluginOption( 'idUser' ); ?>"  size="30" /> 
		<span>(Например, "<strong>aidaxoru</strong>" для 
		<a href="http://fotki.yandex.ru/users/aidaxoru/" target="_blank">http://fotki.yandex.ru/users/aidaxoru/</a>)</span><br />
		<p class="description">* - пользователь с таким именем должен быть зарегистрирован на сервисе "Яндекс.Фотки". Если у вас нет аккаунта на яндексе, то вы можете <a href="http://passport.yandex.ru/passport?mode=register&from=fotki&retpath=http%3A%2F%2Ffotki.yandex.ru%2F" target="_blank">зарегистрироваться здесь</a>.</p>
	
	</div>
<h3>Параметры атрибутов по умолчанию</h3>
    <p class="description">Здесь можно указать значения атрибутов тега [yfgallery], которые будут использоваться по умолчанию, если 
	Вы не указали их при вызове тега.</p>    
		<p>Количество выводимых изображений (limit):
		<input name="Aidaxo_YFGallery_limit" value="<?php echo intval( YFG_Core::getPluginOption( 'limit' ) ); ?>" size="3" /> шт.<br />
	    </p>
		
		<p>Отображать названия изображений (showTitle):
		<input type="checkbox" name="Aidaxo_YFGallery_showTitle" value="1" <?php echo setSelectedFlag( true, (bool)YFG_Core::getPluginOption( 'showTitle' ), 'checked' ); ?> /><br />
		</p>
		
	
	<?php
	$SizeValues = array(
	                'XXXS' => 'XXXS (50px)',
	                'XXS' => 'XXS (75px)',
	                'XS' => 'XS (100px)',
	                'S' => 'S (150px)',
	                'M' => 'M (300px)',
	                'L' => 'L (500px)',
	                'XL' => 'XL (800px)',
	                'orig' => 'Оригинальный размер изображения'
	            );

	$SortValues = array(
	                'updated' => 'updated (по времени последнего изменения, от новых к старым)',
	                'rupdated' => 'rupdated (по времени последнего изменения, от старых к новым)',
	                'published' => 'published (по времени загрузки (для фотографии) или создания (для альбома), от новых к старым)',
	                'rpublished' => 'rpublished (по времени загрузки (для фотографии) или создания (для альбома), от старых к новым)',
	                'created' => 'created (по времени создания согласно EXIF-данным, от новых к старым (только для фотографий))',
	                'rcreated' => 'rcreated (по времени создания согласно EXIF-данным, от старых к новым (только для фотографий))'
	            );			
	$Templates = unserialize( YFG_Core::getPluginOption('templates') );
				
	?>	
		
		
		<p>Размер превью изображения, например, в сайдбаре (psize):
		<select name="Aidaxo_YFGallery_previewSize">
		<?php
		
		foreach ($SizeValues as $key => $val) 
		{
			echo '<option value="' . $key . '" ' . setSelectedFlag( $key, YFG_Core::getPluginOption( 'previewSize' ) ) . '>' . $val . '</option>';
		}
		?>
		</select></p>
	 
	 
	 
	 
		<p>Размер изображения в статье (asize):
		<select name="Aidaxo_YFGallery_articleSize">
		<?php
		foreach ($SizeValues as $key => $val) 
		{
			echo '<option value="' . $key . '" ' . setSelectedFlag( $key, YFG_Core::getPluginOption( 'articleSize' ) ) . '>' . $val . '</option>';
		}
		?>
		</select></p>

		
		
		
		<p>Режим сортировки вывода (sort):
		<select name="Aidaxo_YFGallery_sortOutput">
		<?php
		foreach ($SortValues as $key => $val) 
		{
			echo '<option value="' . $key . '" ' . setSelectedFlag( $key, YFG_Core::getPluginOption( 'sortOutput' ) ) . '>' . $val . '</option>';
		}
		?>
		</select></p>
		
		
		<p>Шаблон для вывода в статье, сайдбаре (atemplate): 
		<select name="Aidaxo_YFGallery_articleTemplate">
		<option value="">Не задан</option>
		<?php
		
			foreach ($Templates as $Template) 
			{
				echo '<option value="' . $Template['templateName'] . '" ' . setSelectedFlag( $Template['templateName'], YFG_Core::getPluginOption( 'articleTemplate' ) ) . '>' . $Template['templateTitle'] . '</option>';
			}
			echo '</select>';		
		?></p>
		
		
		
		
		<p>Шаблон для вывода в фид (ftemplate): 
		<select name="Aidaxo_YFGallery_feedTemplate">
		<option value="">Не задан</option>
		<?php
			foreach ($Templates as $Template) 
			{
				echo '<option value="' . $Template['templateName'] . '" ' . setSelectedFlag( $Template['templateName'], YFG_Core::getPluginOption( 'feedTemplate' ) ) . '>' . $Template['templateTitle'] . '</option>';
			}
			echo '</select>';		
		?></p>
		
		
		<h3>Другие параметры</h3>
		<p>Включить обработку тега [yfgallery] в сайдбарах:
			<input type="checkbox" name="Aidaxo_YFGallery_enableShortcodeInSidebars" value="1" <?php echo setSelectedFlag( true, (bool)YFG_Core::getPluginOption( 'enableShortcodeInSidebars' ), 'checked' ); ?> /><br />
		</p>
		
		<input type="hidden" name="action" value="update" />
	    <input type="hidden" name="page_options" value="Aidaxo_YFGallery_idUser,Aidaxo_YFGallery_limit,Aidaxo_YFGallery_showTitle,Aidaxo_YFGallery_previewSize,Aidaxo_YFGallery_articleSize,Aidaxo_YFGallery_sortOutput,Aidaxo_YFGallery_articleTemplate,Aidaxo_YFGallery_feedTemplate,Aidaxo_YFGallery_enableShortcodeInSidebars" />
	    <p class="submit">
	        <input type="submit" name="Submit" class="button" value="Сохранить" />
	    </p>
	</form>		
		
	<h3>Сброс параметров к начальным настройкам</h3>
<p class="description">Все настройки плагина будут сброшены к настройкам по умолчанию. Внимание! Также будут удалены все шаблоны.</p>
		
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<input type="hidden" name="action" value="resetOptions" />
	<p class="submit">
		<input type="submit" name="Delete" class="button" value="Вернуть первоначальные настройки" onclick="javascript:return confirm('Будут УДАЛЕНЫ все имеющиеся настройки плагина. Восстановить настройки по умолчанию?')"/>
	</p>
	</form>

