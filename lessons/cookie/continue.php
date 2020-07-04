<?php 
 session_start();
  if (isset($_SESSION['username']))  // Если в сессии введено имя, то и другие данные будут присутствать
  	{    
  		$username = $_SESSION['username'];    // выводим данные из сессии
  		$password = $_SESSION['password'];    
  		$forename = $_SESSION['forename'];    
  		$surname = $_SESSION['surname'];

    echo "С возвращением, $forename.<br>        
    			Ваше полное имя $forename $surname.<br>
					Ваше имя пользователя '$username'       
					и ваш пароль '$password'.";  
		 
		 destroy_session_and_data();			// Уничтожение сессии после покидания пользователя 
		}  
		else 
			echo "Пожалуйста, для входа <a href='authenticate2.php'>щелкните здесь</a>."; 
 			
 			function destroy_session_and_data()  
 			{    
 				$_SESSION = array();    

 				if (session_id() != "" || isset($_COOKIE[session_name()]))        
 					setcookie(session_name(), '', time() - 2592000, '/');    
 				session_destroy();  
 			} 
 ?>