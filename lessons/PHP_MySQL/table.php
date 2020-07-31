<?php  
require_once 'login.php';  
$conn = new mysqli($hn, $un, $pw, $db);  

if ($conn->connect_error) 
	die($conn->connect_error);
/* Если еще не создана, то раскомментировать

  $query = "CREATE TABLE cats (    
  id SMALLINT NOT NULL AUTO_INCREMENT,    
  family VARCHAR(32) NOT NULL,    
  name VARCHAR(32) NOT NULL,    
  age TINYINT NOT NULL,   
   PRIMARY KEY (id))"; 

  $result = $conn->query($query);  

  if (!$result) 
 die ("Сбой при доступе к базе данных: " . $conn->error); 
*/

//--- Добавление данных
/*
 $query = "INSERT INTO cats VALUES(NULL, 'Lion', 'Leo', 4)";  // Первый параметр NULL -тк там все авено auto_increment,он сам добавит id 
 
 $result = $conn->query($query);
  
  if (!$result) 
  	die ("Сбой при доступе к базе данных: " .$conn->error()); 
*/
//--- Извлечение данных
  $query = "SELECT * FROM cats";  
  $result = $conn->query($query);  
  if (!$result) die ("Сбой при доступе к базе данных: " .$conn->error());

  $rows = $result-> num_rows;
  echo "<table>
  <tr> 
		<th>Id</th> 
		<th>Family</th> 
		<th>Name</th>
	  <th>Age</th>
	</tr>";
  for ($j = 0 ; $j < $rows ; ++$j) 
  	{    
  		$result->data_seek($j);     
  		$row = $result->fetch_array(MYSQLI_NUM);
			echo "<tr>";    
				for ($k = 0 ; $k < 4 ; ++$k) 
					echo "<td>$row[$k]</td>";    
			echo "</tr>";  
		}
  echo "</table>"; 

// -- Обновление данных
		 $query = "UPDATE cats SET name='Charlie' WHERE name='Charly'";  
		 $result = $conn->query($query);  

		 if (!$result) die ("Сбой при доступе к базе данных: " .$conn->error());  

//--- Удаление данных
 			$query = "DELETE FROM cats WHERE name='Growler'";  
 			$result = $conn->query($query);
  		
  		if (!$result) die ("Сбой при доступе к базе данных: " .$conn->error());

/*--- Узнать данные + AUTO_INCREMENT + insert id
  	// AUTO_INCREMENT не дает значения(которые были до этого) 
  	// Если удалить значение id=4,то при создании нового элемента, id=4 ему не присвоится
 			$query = "INSERT INTO cats VALUES(NULL, 'Lynx', 'Stumpy', 5)";  
 			$result = $conn->query($query);  
			$insertID = $conn->insert_id;			// Ключ (например для привязки кошки к Организации)
 			
 			echo "Значение вставленного ID равно " . $conn->insert_id;

 			$query = "INSERT INTO owners VALUES($insertID, 'Ann', 'Smith')"; // Так мы свяжем животное и хозяина посредством
 																																			// Уникального ключа  
			$result   = $conn->query($query); 


---- БЛОКИРОВКИ
			1. Блокировка первой таблицы (например, cats). 
			2. Вставка данных в первую таблицу. 
			3. Извлечение уникального ID из первой таблицы (свойство insert_id). 
			4. Снятие блокировки с первой таблицы. 
			5. Вставка данных во вторую таблицу. 
*/

 		
			
?> 