<?php // sqltest.php  

require_once 'login.php';  

$conn = new mysqli($hn, $un, $pw, $db);  
if ($conn->connect_error) die($conn->connect_error);

  if (isset($_POST['delete']) && isset($_POST['isbn']))  
  {    
  	$isbn  = get_post($conn, 'isbn');    
  	$query = "DELETE FROM classics WHERE isbn='$isbn'";   
  	$result = $conn->query($query);     
  	
  	if (!$result) 
  		echo "Сбой при удалении данных: $query<br>" .$conn->error . "<br><br>";  

  }

  if (isset($_POST['author']) && isset($_POST['title']) && isset($_POST['category']) && isset($_POST['year']) && isset($_POST['isbn']))  
  	{    
  		$author   = get_post($conn, 'author');    
  		$title    = get_post($conn, 'title');    
  		$category = get_post($conn, 'category');    
  		$year     = get_post($conn, 'year');    
  		$isbn     = get_post($conn, 'isbn');
    
    $query    = "INSERT INTO classics VALUES" ."('$author', '$title', '$category', '$year', '$isbn')";    
    $result   = $conn->query($query);     

    if (!$result) 
    	echo "Сбой при вставке данных: $query<br>" .$conn->error . "<br><br>";      
  }

echo <<<_END
 <form action="sqltest.php" method="POST">
 <pre>  
 Author		<input type="text" name="author">
 Title		<input type="text" name="title">  
 Category	<input type="text" name="category">    
 Year		<input type="text" name="year">    
 ISBN		<input type="text" name="isbn">         
 <input type="submit" value="ADD RECORD"> <!-- // кнопка // ДОБАВИТЬ ЗАПИСЬ -->  
 	</pre></form>  
_END;
  
  $query = "SELECT * FROM classics";																			// Выбираем таблицу 

  $result = $conn->query($query);
  if (!$result) die ("Сбой при доступе к базе данных: " . $conn->error);
  
  $rows = $result->num_rows;																							// Узнаем кол-во строк в таблице

  for ($j = 0 ; $j < $rows ; ++$j)  																			//Выводим каждую строку
  {  
  	$result->data_seek($j);      // Поиск интересующих нас данных
  	 $row = $result->fetch_array(MYSQLI_NUM); // Массив результатов

echo <<<_END
<pre>  
Author $row[0]   
Title $row[1]  
Category $row[2]    
Year $row[3]    
ISBN $row[4]  
</pre>  
    <form action="sqltest.php" method="POST">  
    <input type="hidden" name="delete" value="yes">  
    <input type="hidden" name="isbn" value="$row[4]">  
    <input type="submit" value="DELETE RECORD"></form>  <!-- кнопка // УДАЛИТЬ ЗАПИСЬ -->  
_END;
  }

  $result->close();  
  $conn->close();

  function get_post($conn, $var)  {    
  	return $conn->real_escape_string($_POST[$var]);  //  извлекает введенные данные из браузера.
  																									// real_escape_string - Удаление символов, которые могут приветси к взлому
  }
