<?php 
			// Процедурный метод исп SQL, а не Объектный
/*		
			// Подключение				
				$link = mysqli_connect($hn, $un, $pw, $db);
			//Откючение
				mysqli_close($link);

				if (mysqli_connect_errno()) die(mysqli_connect_error()); 
 			// Запрос к MySQL
				$result = mysqli_query($link, "SELECT * FROM classics");
 				
 				$rows = mysqli_num_rows($result); //int 
 				$row = mysqli_fetch_array($result, MYSQLI_NUM);	// Извлечение данных  $row[0] -1й столбец
 			// Информация об id вставленного эл-та
 				$insertID = mysqli_insert_id($result);

 		// Методы Обезвреживания строк
 			#1
 			$escaped = mysqli_real_escape_string($link, $val);  
 		#2
 			$stmt = mysqli_prepare($link, 'INSERT INTO classics VALUES(?,?,?,?,?)'); 						// Открыть запрос
 			mysqli_stmt_bind_param($stmt, 'sssss', $author, $title, $category,$year, $isbn); 
 			mysqli_stmt_execute($stmt); 																												// Присвоение значений
 			mysqli_stmt_close($stmt);  																													// Закрыть запрос
 */
 ?>
