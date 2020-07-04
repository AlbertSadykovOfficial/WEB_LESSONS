<?php 
	function reject($entry)
	{
		echo "Недопустимо: $entry <br>";
		echo 'Пожалуйста, <a href="cookie_form.html">авторизуйтесь</a>';
		exit();
	}

/*ctype_alnum(x) Проверка на содержание только букв и цифр
	TRUE - если правда
*/	
	if (isset($_POST['user'])) 
	{
# trim удаляет лишние пробелы в начале/конце
		$user = trim($_POST['user']);
		if (!ctype_alnum($user)) { reject('Имя Пользователя');}

		if (isset($_POST['pass'])) 
		{
			$pass = trim($_POST['pass']);

			if (!ctype_alnum($pass)) { reject('Пароль');
			}else {
				setcookie('user', $user, time()+3600); //Время действия записи 1час
				setcookie('pass', md5($pass), time()+3600);
				header("Location: cookie_get.php");
			}
		}
	}
	else {header('Location: cookie_form.html');}

 ?>