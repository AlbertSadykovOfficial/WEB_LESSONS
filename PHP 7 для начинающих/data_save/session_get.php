<?php session_start(); ?>

<?php 
			if(isset($_SESSION['user']))
			{
				$user = $_SESSION['user'];
				echo "<h1>Добро пожаловать, $user!</h1><hr>";
				echo '<a href="session_data.php">Просмотр сессии</a>';
			}else{
				echo 'Пожалуйста, <a href="session_form.html">авторизуйтесь</a>';
			}
		


 ?>