<?php 
 /*	Предотвращение попыток взлома
	Изьян 1 (Доступ через комментарий)
		$user  = $_POST['user']; 			//  Ввести:( admin' # ) # - В sql начало коммента
		$pass  = $_POST['pass']; 			//  Ничего не вводить
		$query = "SELECT * FROM users WHERE user='$user' AND pass='$pass'"; 	
		
		Result: SELECT * FROM users WHERE user='admin' #дальше уже не важно - паролья может не быть
		
		$user  = $_POST['user']; 			//  Ввести:( anything' OR 1=1 # ) # - В sql начало коммента
		$pass  = $_POST['pass']; 			//  Ничего не вводить
		$query = "DELETE FROM users WHERE user='$user' AND pass='$pass'"; 
		
		Result:	DELETE FROM users WHERE user='anything' OR 1=1 #ДАЛЬШЕ НЕ ВАЖНО
		 // Условие ВСЕГДА выполнится -> Произойдет удаление всех сведений о пользователях
*/
#  Вариант 1.1 Использование указателей мест заполнения 
		require 'login.php';  
		$conn = new mysqli($hn, $un, $pw, $db);  
		if ($conn->connect_error) die($conn->connect_error);      

			$stmt = $conn->prepare('INSERT INTO classics VALUES(?,?,?,?,?)');  	// Вопросительные знаки замещаются параметрами
			
			$stmt->bind_param('sssss', $author, $title, $category, $year, $isbn);	// Забиваем параметры
			/* 	Параметр Череды Типов Аргументов: 'sssss':
					i — данные, являющиеся целым числом;  
					d — данные, являющиеся числом с двойной точностью;  
					s — данные, являющиеся строкой;  
					b — данные, являющиеся большим двоичным объектом — BLOB (отправляемым в пакетах). 
			*/
		// Присваиваем значения переменным для передачи SQL
	  	$author 	= 'Emily Brontë';  
	  	$title 		= 'Wuthering Heights';  
	  	$category = 'Classic Fiction';  
	  	$year 		= '1847';  
	  	$isbn 		= '9780553212587';
	  
	  	$stmt->execute();  
	  	printf("%d Row inserted.\n", $stmt->affected_rows);  // проверка на успешное выполнение команды
	  	$stmt->close();  
  	$conn->close();
	
/*
		stripslashes($variable); // Избавление от Слешей
		strip_tags($variable);  // удаление всего html внедрения (должен быть до htmlentities)
		htmlentities($variable);  // Обезвреживание html внедрения

# Готовые ф-ции
		 function sanitizeString($var)  
		 {    
		 	$var = stripslashes($var);          
		 	$var = strip_tags($var);    
		 	$var = htmlentities($var);        
		 	return $var;  
		 }
	  function sanitizeMySQL($connection, $var)  
	  { 
	  	$var = $connection->real_escape_string($var);    
	  	$var = sanitizeString($var);    
	  	return $var;  
	  } 

*/
/*	Предотвращение внедрения HTML-кода		
		В таком типе взлома пользователь загружает в форму код, который внедряется в страницу и может быть использован
		как похищение данных
		Пример:
		<script src='http://x.com/hack.js'> 
		</script><script>hack();</script>
		Чтобы предотвратить это внедрение, нужно лишь вызвать функцию htmlentities, выявляющую все коды разметки HTML и заменяющую их формой, которая отоHTML и заменяющую их формой, которая ото и заменяющую их формой, которая отображает символы, но не позволяет браузеру действовать в соответствии с их предназначением:

		&lt;script src='http://x.com/hack.js'&gt; &lt;/script&gt; 
		&lt;script&gt;hack();&lt;/script&gt; 

		Код обезвреживания:
		 $user = mysql_entities_fix_string($conn, $_POST['user']);  
		 $pass = mysql_entities_fix_string($conn, $_POST['pass']);  
		 $query = "SELECT * FROM users WHERE user='$user' AND pass='$pass'";
 
		 function mysql_entities_fix_string($conn, $string)  
		 {    
		 	return htmlentities(mysql_fix_string($conn, $string));  // Тут защита и от SQL(ф-ция ниже) и от HTML внедрения
		 }

*/
/*
#Вариант 1.2

			Пример испоьзования 
			$user = mysql_fix_string($conn, $_POST['user']);  
			$pass = mysql_fix_string($conn, $_POST['pass']);  
			$query = "SELECT * FROM users WHERE user='$user' AND pass='$pass'";
  
			  function mysql_fix_string($conn, $string)  
			  {    
			  		if (get_magic_quotes_gpc()) 	// возвращает TRUE, если свойство «волшебных кавычек» находится в активном состоянии. 
			   																	// Если это так, любые добавленные к строке слеши подлежат удалению
			  		$string = stripslashes($string);    
			  	return $conn->real_escape_string($string);   
			  }
	 */


//  Вариант 1.1 (По-другому) Использование указателей мест заполнения 
/*
	PREPARE statement FROM "INSERT INTO classics VALUES(?,?,?,?,?)";
		SET @author 	= "Emily Bront",
				@title 		= "Wuthering Heights",    
				@category = "Classic Fiction",    
				@year     = "1847",    
				@isbn     = "9780553212587";

		EXECUTE statement USING @author,@title,@category,@year,@isbn;
		DEALLOCATE PREPARE statement; 
 */ 

 ?>