<?php session_start(); ?>

<?php 
	function reject($entry)
	{
		echo "Недопустимо: $entry <br>";
		echo 'Пожалуйста, <a href="cookie_form.html">авторизуйтесь</a>';
		exit();
	}

	if (isset($_POST['user'])) 
	{
# trim удаляет лишние пробелы в начале/конце 
		$user = trim($_POST['user']);
		if (!ctype_alpha($user)) { reject('Имя Пользователя');}

		if (isset($_POST['pass'])) 
		{
			$pass = trim($_POST['pass']);
# Проверка на соотвтствие формату
# preg_match(ругулярное выраж, $str);
			if (!preg_match('/^[A-Za-z0-9._]{8,}$/',$pass)) 
			{ reject('Пароль');}
			else 
			{
				$_SESSION['user'] = $user;
				$_SESSION['pass'] = $pass;

				header("Location: session_get.php");
			}
		}
	}
	else {header('Location: session_form.html');}

 ?>