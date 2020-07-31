<?php 

// Ассоциативные масивы
 $paper = array(	 'copier' => "Copier & Multipurpose",
               'inkjet' => "Inkjet Printer",              
               'laser'  => "Laser Printer",              
               'photo'  => "Photographic Paper");

  echo "Элемент массива p2: " . $p2['inkjet'] . "<br>";

// foreach as 
  // При каждой итерации значение элемента 
  // $p2 помещатся в $item
	$j = 0;
  foreach ($paper as $item) 
  {
  	   echo "$j: $item<br>";    
  	   ++$j;
  }
echo "<hr>";

  foreach ($paper as $item => $description)  echo "$item: $description<br>";
/* Альтернатива
each -возвращает пару: Ключ-значение,
			затем перемещает след указатель на следующую пару
			КОГДА возращать нечего-> FALSE
list -принимает массив (пару «ключ — значение»)
			Затем присваивает значения массива переменным, перечисленным внутри круглых скобок.
Пример: list($a, $b) = array('Alice', 'Bob'); Ответ: a=Alice b=Bob

	while (list($item, $description) = each($paper))      
	echo "$item: $description<br>";

***
Можно воспользоваться конструкцией foreach...as для создания цикла, извлекающего значения в переменную, которая следует за as, или воспользоваться функцией each и создать собственную систему циклической обработки.

 */

 echo '<hr><br>';

/*	Многомерные массивы 
		Перебор
*/

 $products = array(      
					 	'paper' => array( 'copier' => "Copier & Multipurpose",          
					 										'inkjet' => "Inkjet Printer",          
					 										'laser'  => "Laser Printer",          
					 										'photo'  => "Photographic Paper"),

			      'pens' =>  array( 'ball'   => "Ball Point",          
			      									'hilite' => "Highlighters",          
			      									'marker' => "Markers"),

			      'misc' =>  array( 'tape'   => "Sticky Tape",
          										'glue'   => "Adhesives",          
          										'clips'  => "Paperclips")  
	);

  echo "<pre>";
  foreach ($products as $section => $items)      // Извлекае разделы
  	foreach ($items as $key => $value)        	// Извлекаем из разделов : Ключ-значение
  		echo "$section:\t$key\t($value)<br>";  
	echo "</pre>"; 


/*
		Функции раоты с массивами
		 http://tinyurl .com/phparrayfuncs // Все функции на этом сайте

		 is_array($val); 			- TRUE, ЕСЛИ МАССИВ

#	Подсчет
 		 count($val);					- Кол-во значений массива
		 count($val, 1);      - 0-для подсчета верхнего уровня, 1- для подсчета всех ур-ней

# Сортировка 
		sort($fred); // Работает сразу с предоставленным массивом(отв:1, если сорт успешна)
		rsort($fred);	// Обратная

		sort($fred, SORT_NUMERIC); 
		sort($fred, SORT_STRING);

# Перемашивание массива
	shuffle($cards); // TRUE - УСПЕШНО

# Разбиение на составные части
	$x = explode('**', "here**we**go"); 
	printr(x); Отв: Array([0]=> here [1]=> we [2]=> go)

# extract ?(Почитать об этом еще) 
	Если возникает необходимость сохранить отправленные на сервер переменные для дальнешей 
	обработки:(Передаем $q='hi there')
	extract($_GET, EXTR_PREFIX_ALL, 'fromget'); // даная конструкция препишет 3 переменную
																							// получится переменная : $fromget_q, а не $q

# compact
 Для создания массива из переменных и их значений
 compact ищет список имен переменных, поэтому при вызове нужно писать без ($)
  $j 			 = 23;  
  $temp    = "Hello";  
  $address = "1 Old Street";  
  $age     = 61;
  print_r (compact (explode (' ','j temp address age'))); // explode, чтобы не писать 'j',...

# reset
Если при переборе foreach as? требуется вернуться к 1 эл массива,то:
	reset($fred);         // Отбрасывание возвращаемого значения 
	$item = reset($fred); // Сохранение первого элемента массива                      
												// в переменной $item

# end
Как restet/ только с последним элементом
	end($fred); 
	$item = end($fred); 
*/
 ?>