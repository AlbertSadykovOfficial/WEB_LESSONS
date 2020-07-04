<?php 
 require_once 'login.php'; 

  $connection =  new mysqli($hn, $un, $pw, $db);
  
  if ($connection->connect_error) die($connection->connect_error);

  if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))  
  	{    
  		$un_temp = mysql_entities_fix_string($connection,$_SERVER['PHP_AUTH_USER']);    
  		$pw_temp = mysql_entities_fix_string($connection,$_SERVER['PHP_AUTH_PW']);

    $query = "SELECT * FROM users WHERE username='$un_temp'";    
    
    $result = $connection->query($query);    

    if (!$result) 
    	die($connection->error);    
    elseif ($result->num_rows)
    	{        
    		$row = $result->fetch_array(MYSQLI_NUM);                 
    		$result->close();

        $salt1 = "qm&h*"; $salt2 = "pg!@";        
        $token = hash('ripemd128', "$salt1$pw_temp$salt2");                
// -----------------------------------------------------------------------Смотреть сюда----------------------------------------// 
        if ($token == $row[3]) 
        	{            
            session_start();            
            // Усанавливаем время ожидания сессии, после чего она закроется(Если чел не регистрируется или забыл, чтоб сессия не висела)
            // Использование этого здесь - показательное, не практическое
            ini_set('session.gc_maxlifetime', 60 * 60 * 24); 
            echo 'До конца сессии'.ini_get('session.gc_maxlifetime').'<br>';   // Узнать сколко осталось до конца сессии
            $_SESSION['username'] = $un_temp;  // Запоминаем в сессии НИК
            $_SESSION['password'] = $pw_temp;  // Пароль
            $_SESSION['forename'] = $row[0];   //  ИМЯ
            $_SESSION['surname'] = $row[1];    //  ФАМИЛИЮ       
            echo "$row[0] $row[1] : Привет, $row[0],теперь вы зарегистрированы под именем '$row[2]'";            
            die ("<p><a href='continue.php'>Щелкните здесь для продолжения</a></p>"); 
          }        
        else 
        	die("Неверная комбинация имя пользователя — пароль");    
      } 
 // -----------------------------------------------------------------------Смотреть сюда----------------------------------------//    
      else 
      die("Неверная комбинация имя пользователя — пароль");  
  	}  else  {    
  		header('WWW-Authenticate: Basic realm="Restricted Section"');    
  		header('HTTP/1.0 401 Unauthorized');    
  		die ("Пожалуйста, введите имя пользователя и пароль");  
  	}

  	 $connection->close();
  	
  	function mysql_entities_fix_string($connection, $string)
		{    
			return htmlentities(mysql_fix_string($connection, $string));  
		}

		function mysql_fix_string($connection, $string)  
		{    
			if (get_magic_quotes_gpc()) 
				$string = stripslashes($string);    
			return $connection->real_escape_string($string);  
		}  

/*     О безопасности сессии
Все мои прежние заверения в том, что после аутентификации пользователя и начала сессии можно спокойно предположить, что переменные сессии заслуживают доверия, не вполне соответствуют действительности. �ело в том, что для вскрытия идентификаторов сессий, передаваемых по сети, можно организовать анализ пакетов — packet sniffing (перехват набора данных). Кроме того, если идентификатор (ID) сессии передается в области GET-запроса URL-адреса, он может появиться в файлах регистрации внешних сайтов. 
Единственный по-настоящему безопасный способ предотвращения вскрытия заключается в применении протокола защищенных сокетов — Secure Socket Layer (SSL) — и запуске веб-страниц, использующих вместо протокола HTTP протокол HTTPS. Эта тема выходит за рамки данной книги, но за подробностями настроек безопасности веб-сервера можно обратиться по адресу http://www.apache-ssl.org. 


*/
 ?>