// Типы Данных
<?php 
/*
 	Ф-ции:
 	gettype($str); - Вернет строку/значение.../ or Неизвестный тип(если не определено)
	
	var_dump(); - Выводит структурированную инормацию о элементе (ТИП, ЗНАЧЕНИЕ)
*/

 
$filestream = fopen('index.html', 'r');
$data = array('PHP', 1, 2.3, TRUE, NULL, array(), new Directory, $filestream);

foreach ($data as $type) {
	var_dump($type);
	echo '<br> ';	
}	
	fclose($filestream);
	echo gettype($filestream);


# Контанты
	define('PI', 3.14);
	echo 'Число ПИ = '. PI;

// пока 5, а не 7 поэтому не сработает
echo PHP_VERSION;
	//define('PETS', ['Cat','Dog','Raccoon']);
	//echo '<p>Привет, число '. PI '. Как поживает'. PETS[2]'? </p>';
 
?>