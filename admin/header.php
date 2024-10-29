<?php

?>
<h3>Подключение скриптов и таблиц стилей</h3>
	<p class="description">Вы можете активировать подключение скриптов для вашего блога.</p>

	<form method="post" action="options.php">
    <?php wp_nonce_field('update-options'); ?>
	
	<p>Включить шаблон шапки:
	<input type="checkbox" name="Aidaxo_YFGallery_metaInfoEnabled" value="1" <?php echo setSelectedFlag( true, (bool)YFG_Core::getPluginOption( 'metaInfoEnabled' ), 'checked' ); ?> /><br />
	</p>
	<p>Шаблон шапки, применяется ко всем страницам блога. Если шаблон включен, то указанная в нем информация будет выводиться между тегами &lt;HEAD&gt; и &lt;/HEAD&gt; на всех страницах блога. 
	Используйте это поле для подключения JavaScript и CSS файлов для Litebox, JQuery галерей и др.<br/>
	<strong>&lt;HEAD&gt;</strong><BR />
	<textarea name="Aidaxo_YFGallery_metaInfoContent" cols="80" rows="10"><?php echo stripslashes( YFG_Core::getPluginOption( 'metaInfoContent' ) ); ?></textarea><BR />
	<strong>&lt;/HEAD&gt;</strong><BR />
	<p/>
	<p>Если вы используете галерею, требующую подключение определенных JavaScript и CSS файлов, только на одной странице блога, то целесообразным является создание отдельного шаблона страницы с инкапсулированными скриптами.
	</p>
	<p>Добавление неизвестных скриптов и/или CSS может нарушить работу вашего блога. Добавляемые Вами скрипты могут вступить в конфликт с уже подключенными. Если такое произошло, то снимите галку с пункта "Включить шаблон шапки", а затем скорректируйте шаблон, устранив ошибку.
	</p>
	<input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="Aidaxo_YFGallery_metaInfoEnabled,Aidaxo_YFGallery_metaInfoContent" />
    <p class="submit">
		<input type="submit" name="Submit" class="button" value="Сохранить" />
	</p>
</form>