<?php session_start(); ?>
# При обновлении $_SESSION сбросится 
<?php
		function kill_session()
		{
			unset($_SESSION['user']);
			unset($_SESSION['pass']);
			session_destroy();
			echo '<hr>Сессия прервана<br>';
			echo 'Идентификатор сессии: '.session_id().'<br>';
			var_dump($_SESSION);
		} 

			if (count($_SESSION) > 0) 
			{
				echo '<dl> ';
				foreach ($_SESSION as $key => $value)
				{
					echo "<dt>Ключ: $key"; echo "<dd>Значение: $value";
				}
				echo '</dl><hr>';

				echo 'Идентификатор сессии: '.session_id().'<br>' ;
				var_dump($_SESSION);
				kill_session();
			}else
			{
			 echo 'Пожалуйста, <a href="session_form.html">Авторизуйтесь</a>';	
			}
 ?>