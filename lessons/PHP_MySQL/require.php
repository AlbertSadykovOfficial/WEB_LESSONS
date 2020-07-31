<?php
 require_once 'login.php';  
 $conn = new mysqli($hn, $un, $pw, $db);  // Создаем ноый объект

// Св-во об ошибках $conn->conncet_error 
 if ($conn->connect_error) die($conn->connect_error);  // die НЕ ИСПОЛЬЗУЮТ НА готовом проекте
/*
	АЛльтернатива
	function mysql_fatal_error($msg) 
	{    
		$msg2 - mysql_error();    
	echo <<<_END 
	К сожалению, завершить запрашиваемую задачу не представилось возможным. Было получено следующее сообщение об ошибке:
    <p>$msg: $msg2</p>
		Пожалуйста, нажмите кнопку возврата вашего браузера и повторите попытку. Если проблемы не прекратятся, пожалуйста, <a href="mailto:admin@server.com">сообщите о них нашему администратору </a>. Спасибо. 
_END;
	}
*/

		// Создание и выполнение запроса 	
  	 $query = "SELECT * FROM classics";  // Составляем сообщение запроса
  	 $result = $conn->query($query);  	//  Создаем обьект и принимам в него ответ, передав запрос
  	 if (!$result) die ($conn->error); 				// die НЕ ИСПОЛЬЗУЮТ НА готовом проекте

  	 //Извлечение результата 
  	  $rows = $result->num_rows;
/* // fetch_assoc() метод обьекта для поэлементного извлечения данных 		
  		for ($j = 0 ; $j < $rows ; ++$j)  
  		{  
  			$result->data_seek($j);	// Метод для поисканужной строки      
  			echo 'Author: '		. $result->fetch_assoc()['author']   	.'<br>';
  		 	$result->data_seek($j);        
  		 	echo 'Title: '		. $result->fetch_assoc()['title']     	.'<br>';  
  		 	$result->data_seek($j);
  		 	echo 'Category: '	. $result->fetch_assoc()['category']		.'<br>';  
  		 	$result->data_seek($j);        
  		 	echo 'Year: '			. $result->fetch_assoc()['year']     	.'<br>';  
  		 	$result->data_seek($j);        
  		 	echo 'ISBN: ' 		. $result->fetch_assoc()['isbn']     	.'<br><br>';  
  		}
 */ 		
// Более компактный Компактный способ
  		for ($j = 0 ; $j < $rows ; ++$j)
  		{
  			 $result->data_seek($j);    
  			 $row = $result->fetch_array(MYSQLI_ASSOC);    // Возвращает строку данных в виде массива 
  			 echo 'Author: '   . $row['author'] .   '<br>';    
  			 echo 'Title: '    . $row['title'] .    '<br>';    
  			 echo 'Category: ' . $row['category'] . '<br>';    
  			 echo 'Year: '     . $row['year'] .     '<br>';    
  			 echo 'ISBN: '     . $row['isbn'] .     '<br><br>'; 
  		}
  	// Отключение (По-возможности нужно делать как можно быстрее)	
  		$result->close();  
  		$conn->close();
 
 /* fetch_array()
 		MYSQLI_NUM — числовой массив. 0 - Author 1 - Title
 		** MYSQLI_ASSOC — ассоциативный массив.  Каждый ключ является именем столбца // Предпотительный
 		MYSQLI_BOTH — ассоциативный и числовой массив
 */

  ?>