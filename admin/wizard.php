

<h3>Мастер для получения кода</h3>
<p class="description">Данный мастер позволяет получить код для вставки для доступных публичных альбомов указанного пользователя.</p>
	
<?php
//СДЕЛАТЬ ССЫЛКИ НА АЛЬБОМЫ

$IdUser = ( !empty($_POST["idUser"]) )?
( $_POST["idUser"] ):
( YFG_Core::getPluginOption('idUser') );

?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

    <div>
		Введите имя (iduser) <input type="text" name="idUser" 
		value="<?php echo $IdUser; ?>"  size="30" /> 
		<span>(Например, "<strong>aidaxoru</strong>" для 
		<a href="http://fotki.yandex.ru/users/aidaxoru/" target="_blank">http://fotki.yandex.ru/users/aidaxoru/</a>)</span><br />
	</div>
	<input type="hidden" name="action" value="update" />
    <p class="submit">
		<input type="submit" name="Submit" class="button" value="Получить коды альбомов" />
	</p>
</form>


<?php


if( !empty($IdUser) )
{

	$YFG_Core = new YFG_Core($IdUser);
	$Albums = $YFG_Core->getAlbums();

	?>
	<h3>Общие данные</h3>
	<p>Адрес страницы пользователя <strong><?php echo $IdUser; ?></strong> на сервисе Яндекс.Фотки:<br/>
	<a href="http://fotki.yandex.ru/users/<?php echo $IdUser; ?>/" 
	target="_blank">http://fotki.yandex.ru/users/<?php echo $IdUser; ?>/</a>
	</p>

	
	<h3>Альбомы</h3>
	<?php
	if (!empty($Albums))
	{
		echo "
		<p>Альбомы пользователя <strong>" . $IdUser . "</strong>:<br/>
		<OL>";
		foreach ($Albums as $Album) 
		{
			echo '<li><a href="http://fotki.yandex.ru/users/aidaxoru/album/' . $Album['id'] . '/" target="_blank" title="Посмотреть альбом на сервисе Яндекс.Фотки"><strong>' . $Album['title'] . '</strong></a> (ID: ' . $Album['id'] . ')<BR/>';
			echo "Код для вставки альбома: <input style='width:500px;' type='text' value='[yfgallery iduser=\"" . $IdUser . "\" show=\"album\" showtitle=\"1\" idalbum=\"" . $Album['id'] . "\" psize=\"XS\" asize=\"L\" sort=\"published\"]' onclick=\"this.select();\">";
			echo '</li>';
		}
		echo "</OL>";
	}
	else
	{
		echo "<p>У пользователя <strong>" . $IdUser . "</strong> нет альбомов.</p>";
	}
	?>
	
	
<?php
}
?>
