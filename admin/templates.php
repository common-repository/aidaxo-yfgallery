<?php
/*

Aidaxo_YFGallery_templates
serialize()
$Templates["templateName"]["templateName"] = "default";
$Templates["default"]["templateTitle"] = "default";
$Templates["default"]["templateHeader"] = "<UL>";
$Templates["default"]["templateBody"] = "<li>%TITLE%</li>";
$Templates["default"]["templateFooter"] = "</ul>";

*/
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
?>
<h3>Настройки шаблонов</h3>
	<p class="description">Настройка шаблонов вывода.</p>

<?php
	
	
	$TemplateNameForEdit = YFG_Core::getPluginOption('templateNameForEdit');
	$Templates = unserialize( YFG_Core::getPluginOption('templates') );
	
	if ( !empty($_POST["action"]) AND $_POST["action"] == "update")
	{
		if ( !empty($_POST["Delete"]) )
		{
			echo "<p>Шаблон удален</p>";
			unset($Templates[$TemplateNameForEdit]);
			unset($TemplateNameForEdit);
			update_option( "Aidaxo_YFGallery_templateNameForEdit", null );
		}
		else
		{
			echo "<p>Шаблон обновлен</p>";
			$Templates[$TemplateNameForEdit]["templateName"] = $_POST["Aidaxo_YFGallery_templateName"];
			$Templates[$TemplateNameForEdit]["templateTitle"] = $_POST["Aidaxo_YFGallery_templateTitle"];
			$Templates[$TemplateNameForEdit]["templateHeader"] = $_POST["Aidaxo_YFGallery_templateHeader"];
			$Templates[$TemplateNameForEdit]["templateBody"] = $_POST["Aidaxo_YFGallery_templateBody"];
			$Templates[$TemplateNameForEdit]["templateFooter"] = $_POST["Aidaxo_YFGallery_templateFooter"];
		}
		update_option( "Aidaxo_YFGallery_templates", serialize ($Templates) );
	}
	
	if ( !empty($_POST["action"]) AND $_POST["action"] == "insert")
	{
		echo "<p>Шаблон сохранен</p>";
		$Templates[$_POST["Aidaxo_YFGallery_templateName"]]["templateName"] = $_POST["Aidaxo_YFGallery_templateName"];
		$Templates[$_POST["Aidaxo_YFGallery_templateName"]]["templateTitle"] = $_POST["Aidaxo_YFGallery_templateTitle"];
		$Templates[$_POST["Aidaxo_YFGallery_templateName"]]["templateHeader"] = $_POST["Aidaxo_YFGallery_templateHeader"];
		$Templates[$_POST["Aidaxo_YFGallery_templateName"]]["templateBody"] = $_POST["Aidaxo_YFGallery_templateBody"];
		$Templates[$_POST["Aidaxo_YFGallery_templateName"]]["templateFooter"] = $_POST["Aidaxo_YFGallery_templateFooter"];
		update_option( "Aidaxo_YFGallery_templates", serialize ($Templates) );
		update_option( "Aidaxo_YFGallery_templateNameForEdit", $_POST["Aidaxo_YFGallery_templateName"] );
		$TemplateNameForEdit = $_POST["Aidaxo_YFGallery_templateName"];
	}	
	
	
	?>


	<form method="post" action="options.php">
    <?php wp_nonce_field('update-options'); ?>
	
	
    <div style="padding-top: 10px;">
	Выберите шаблон: 
	<?php
		echo '<select name="Aidaxo_YFGallery_templateNameForEdit">';
		echo '<option value="newtpl">Создать новый шаблон</option>';
		
		foreach ($Templates as $Template) 
		{
			echo '<option value="' . $Template['templateName'] . '" >' . $Template['templateTitle'] . '</option>';
		}
		echo '</select>';		
	?>
	</div>
	<input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="Aidaxo_YFGallery_templateNameForEdit" />
    <p class="submit">
		<input type="submit" name="Submit" class="button" value="Выбрать" />
	</p>
</form>
	
	<p>
	Перед созданием собственного шаблона вы можете прочитать стаью
	<a href="http://www.aidaxo.ru/2010/06/30/yfgallery_litebox_integration/" target="_blank">
	"Пример интеграции Litebox с плагином YFGallery в блог на WordPress"</a>.
	
	</p>
	<?php


	
	
	
	if ( !empty($TemplateNameForEdit) )
	{
		/* создаем новый шаблон */
		if ($TemplateNameForEdit == "newtpl")
		{
			echo '<h3>Создать новый шаблон</h3>';

			?>
			<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
			
			<p>Имя шаблона (указывается в параметрах ftemplate и atemplate, анг. буквы без пробелов, если указать имя существующего шаблона, то старый шаблон будет затерт новым)<br/>
			<input type="text" name="Aidaxo_YFGallery_templateName" value="newtemplate"/><p/>
			
			<p>Название шаблона (для Вас)<br/>
			<input type="text" name="Aidaxo_YFGallery_templateTitle" value="New template"/><p/>
						
			<p>Шапка шаблона (например, &lt;ul&gt;)<br/>
			<textarea name="Aidaxo_YFGallery_templateHeader" cols="80" rows="10"></textarea><p/>
			
			<p>Тело шаблона (может выводится в цикле, например, &lt;li&gt;&lt;/li&gt;)<br/>
			<textarea name="Aidaxo_YFGallery_templateBody" cols="80" rows="10"></textarea><p/>
			
			<p>Тело шаблона может содержать следующие атрибуты:
			<UL>
			<li><strong>%id%</strong> - id изображения</li>
			<li><strong>%title%</strong> - заголовок изображения</li> 
			<li><strong>%previewSizeLink%</strong> - ссылка на версию для предпросмотра</li> 
			<li><strong>%articleSizeLink%</strong> - ссылка на версию для статей</li>
			<li><strong>%originalSizeLink%</strong> - ссылка на оригинальное изображение</li>
			<li><strong>%linkYandexImagePage%</strong> - ссылка на страницу с изображением на сайте Яндекса</li>
			</UL></p>
			<p>Подвал шаблона (например, &lt;/ul&gt;)<br/>
			<textarea name="Aidaxo_YFGallery_templateFooter" cols="80" rows="10"></textarea><p/>
			
			<input type="hidden" name="action" value="insert" />
		    <p class="submit">
				<input type="submit" name="Submit" class="button" value="Создать" />
			</p>
			</form>
			
			<?php
		
		}
		else /* редактируем имеющийся шаблон */
		{
			echo '<h3>Редактирование шаблона: "' . $TemplateNameForEdit . '"</h3>';
			
			?>
			<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
			
			<p>Имя шаблона (указывается в параметрах ftemplate и atemplate, поле доступно только для чтения)<br/>
			<input type="hidden" name="Aidaxo_YFGallery_templateName" value="<?php echo $TemplateNameForEdit; ?>"/><p/>
			<input type="text" value="<?php echo $TemplateNameForEdit; ?>"onclick="this.select();" /><p/>
			
			<p>Название шаблона (для Вас)<br/>
			<input type="text" name="Aidaxo_YFGallery_templateTitle" value="<?php echo stripslashes( $Templates[$TemplateNameForEdit]['templateTitle'] ); ?>" /><p/>
			
			<p>Шапка шаблона (например, &lt;ul&gt;)<br/>
			<textarea name="Aidaxo_YFGallery_templateHeader" cols="80" rows="10"><?php echo stripslashes( $Templates[$TemplateNameForEdit]['templateHeader'] ); ?></textarea><p/>
			
			<p>Тело шаблона (может выводится в цикле, например, &lt;li&gt;&lt;/li&gt;)<br/>
			<textarea name="Aidaxo_YFGallery_templateBody" cols="80" rows="10"><?php echo stripslashes( $Templates[$TemplateNameForEdit]['templateBody'] ); ?></textarea><p/>
			
			<p>Тело шаблона может содержать следующие атрибуты:
			<UL>
			<li><strong>%id%</strong> - id изображения</li>
			<li><strong>%title%</strong> - заголовок изображения</li> 
			<li><strong>%previewSizeLink%</strong> - ссылка на версию для предпросмотра</li> 
			<li><strong>%articleSizeLink%</strong> - ссылка на версию для статей</li>
			<li><strong>%originalSizeLink%</strong> - ссылка на оригинальное изображение</li>
			<li><strong>%linkYandexImagePage%</strong> - ссылка на страницу с изображением на сайте Яндекса</li>
			</UL></p>
			<p>Подвал шаблона (например, &lt;/ul&gt;)<br/>
			<textarea name="Aidaxo_YFGallery_templateFooter" cols="80" rows="10"><?php echo stripslashes( $Templates[$TemplateNameForEdit]['templateFooter'] ); ?></textarea><p/>
			
			<?php
			if ( (bool)YFG_Core::getPluginOption( 'cacheEnabled' ) )
			{
				echo "<p>Важно! У вас включено кэширование. Для отображения изменений, внесенных Вами в шаблон, Вам необходимо очистить кэш.</p>";
			}
			?>
			
			<input type="hidden" name="action" value="update" />
		    <p class="submit">
				<input type="submit" name="Delete" class="button" value="Удалить" onclick="javascript:return confirm('Удалить шаблон <?php echo $Templates[$TemplateNameForEdit]['templateTitle']; ?>?')"/>
				<input type="submit" name="Update" class="button" value="Изменить" />
			</p>
			</form>
			
			<?php
			
		}
	}

	
?>