<?php  

$page_title = 'PHP - Публикация сообщения';

include('../web/grouping/header.html');

echo '<form action="process.php" method="POST" accept-charset="utf-8">

Имя: <input name="first_name"type="text">
Фамилия: <input name="last_name"type="text">

	<p>Тема:<br>
	<input name="subject" type="text" size="64">
	</p>
	<p>Сообщение:<br>
	<textarea name="message" cols="50" rows="5"></textarea></p>
	<p><input type="submit" value="Отправить"></p>
	</form>'
	;

	echo '<p><a href="forum.php">Вернуться к форуму</a></p>';

	include('../web/grouping/footer.html');