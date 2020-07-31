<?php
	if (!empty($_POST)) 
	{
		//Обработчик
		include "handler.php";
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Отправка Письма с вложением</title>
</head>
<body>
	<table>
		<form method='POST' enctype="multipart/form-data">
			<tr>
				<td width="50%">Кому:</td>
				<td align='right'><input type='text' name='mail_to' maxlength='32'> </td>
			</tr>
			<tr>
				<td width="50%">Тема:</td>
				<td align='right'><input type='text' name='mail_subject' maxlength='64'> </td>
			</tr>
			<tr>
				<td colspan="2">
					Сообщение:<br><textarea name="mail_msg" cols="56" rows="8"></textarea>
				</td>
			</tr>
			<tr>
				<td width="50%">Изображение:</td>
				<td align='right'><input type='file' name='mail_file' maxlength='32'> </td>
			</tr>
			<tr>
				<td colspan='2'>
					<input type='subrnit' value='OrnpaBWTb'>
				</td>
			</tr> 
			
		</form>
	</table>
</body>
</html>