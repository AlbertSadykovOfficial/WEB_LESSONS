<?php  
/* 
	Сортировка по значениям:
		void asort  (array &$array [,int $sort_flag]) 
		void arsort (array &$array [,int $sort_flag] ) 

		 $sort_ flag:
		 SORT_REGULAR - автоматический выбор; 
	 	 SORT_NUMERIC - Числовая сортировка; 
	   SORT_STRING - лексиграфическая сортировка

	   Пример: 
	   	$A = [ 
				"a"=> 'Zero',
				"b"=> 'Weapon',
				"c"=> 'Alpha'
				"d"=> 'Processor'
			];
			asort ($A); 
			print_r ($A);// Array([c]=>Alpha [d]=>Processor [b]=>Weapon [a]=>Zero)

	Сортировка по ключам:
		void ksort  (array &$array [,int $sort_flag]) 
		void krsort (array &$array [,int $sort_flag] ) 

	Пользовательская сортировка по ключам и значениям
		void uksort(array &$array, string $callback)
		void uasort(array &$array, string $callback)

	Перевернуть массив
		array array_reverse(array $array [ ,bool $preaserveKeys=flase])
		при preaserveKeys=true обработаются только значения, а ключи останутся в прежнем порядке.

	Функция "естественной сортировки"
		void natsort (array &$array);
		void natcasesort (array &$array); // без учета регистра букв
		Для сортировки подобого:
		image2.gif
		image10.gif
		image.1gif
		image20.gif

	Сортировки списков (не ассоциативных массивов)
		void sort (array &$array [,int $sort_ flag]) 
		void rsort(array &$array [,int $sort_flag])
		При передаче ассоциативного массива в функцию ключи теряются, превращаясь в цифры

	Пользовательская сортировка списка:
		void usort (array &$array, string $callback) 


//---	Сортировка многомерных массивов
			bool array_multisort(array &$ar1 [ ,$arg [,... [, ... ]]] );
			array_multisort(arr1, $arr2, ... , $arrN);
			Массивы, которые переадем в ф-цию должны иметь одинаковое число аргументов, так ни воспринимаются как таблица.
			Так, будет сортироваться ПЕРВЫЙ АРГУМЕНТ, а отсальные будут равнятся по нему, т.е переносится вся строка

			Пример:
			$arrl = [3, 4, 2, 7, 1, 5]; 
			$arr2 = ["world", "Hello", "yes", "no", "apple", "wet"]; 
			array_multisort($arrl, $arr2); 
			print_r($arrl); 
			print_r($arr2); 

				arr1=[	1,		2,		3,	...]
				arr2=[apple, yes world,	...]

			SORT_ASC  - Сортировка в возрастающем порядке
			SORT_DESC - Сортировка в убывающем порядке

		
//---		Перемешивание списка случайным образом:
				void shuffle(array &$array);

//---		Поменять ключи и значения местами:
				array array_flip(array $array); // Вернет новый массив, не меняя старый

//---		Вернуть все ключи 		list array_keys (array $array [,mixed $searchVal]) 
//---		Вернуть все значения 	list array_ values (array $arrray);
//---		Есть ли элемент в массиве? bool in_array(mixed $val, array $array); // лучше исп ключи + значения

//---		Подсчет повторяющихся элементов: 
				array array_count_values (list $list);
				Пример:
				$list = ( 1, "hello", 1, "world", "hello"); 
				array_count_values($array); // array(1 => 2, "hello"=> 2, "world"=> 1) ;

//---		Слияние массивов:
				array array_merge(array $Al, array $A2,...) 
				$Ll = [10, 20, 30]; 
				$L2 = [100, 200, 300]; 
				$L = array_merge($Ll, $L2); // $L1 === (10, 20, 30, 100, 200, 300]; 

//---		Работа с подмассивами:
				1) array array_slice(
								array $arr, 
								int $offset [,int $length = NULL ] [, bool $preserve _ keys = false])
						Возвращает из arr часть, начиная с элемента $offset и длинной length
						При минусе в аргумент - отсчет с конца.
						$input = ["a", "b", "c", "d", "e"]; 
						$output = array_slice($input, 2); //  c d e
						$output = array_slice($input, 2, -1); // c d


				2)list array_splice (list &$list, int $offset [, int $len] [, int $rapl]);
					Пример: 
					$colors= ["red", "green", "blue", "yellow"]; 
					array_splice($colors, 2); 													// $colors= ["red", "green"]
					array_splice($colors, 1, -1); 											// $colors= ["red", "yellow"]
					array_splice ($colors, -1, 1, ["black", "maroon"]); // $colors === ["red", "green", "blue", "black", "maroon"] 
					array_splice($colors, 1, count($colors), "orange"); // $colors === ["red", "orange."] 

	
//---		Работа со стеком и очередью:
				// Запись в конец
					int array_push (list &$array, mixed $varl [, mixed $var2,...]) // Возврщает номер добавленного элемента
					mixed array_pop(list '$array) 																 // Извлекает, а потом удаляет последний элемент
				
				// Добавить в начало стека
					int array_unshift(list 5$array, mixed $varl [, mixed $var2, ... ])
					mixed array_shift (list &$array)                               // Берет 1 элем у удаляет его

//---  ?????????
				// Упаковка в ассоциативный массив переменных, при чем ключи явл именами переданных переменных
					array compact (mixed $vn1 [ , mixed $vn2, ... ])

				// Противоположность (превразает пару ключ=> значение в переменную текущего контекста )
				void extract (array $array [ , int $type] [, string $prefix] ) 
						$type - предписывает что делать с переменной, существующей в контексте:
						EXTR_OVERWRITE   - Переписывет текущую переменную (по умолчанию)
						EXTR_SKIP 		   - Не перезаписывает переменную, если она сущетвует
						EXTR_PREFIX_SAME - Создает переменную с префиксом $prefix
						EXTR_PREFIX_ALL  - Всегда предваряет переменные префиксом $prefix
				
				// Перевод всех ключей в нужный регистр (CASE_LOWER, CASE_UPPER) 
				array array_change_key_case (array $array, int $case=CASE_LOWER)

				// Пример (так делать - плохо, но ради примера(сама концепция плоха))
				<table width:"l00%"> 
						<?php foreach ($book as $entry) { ?> 
						<?php extract(array_change_key_case($entry, CASE_UPPER)) ?> 

						<tr> 
							<td>~: <?=$NAME?></td> <!-- Вместо $entry['name'J --> 
							<td>Az:tpec: <?=$URL?></td> <!-- Вместо $entry['url'J --> 
						</tr> 
						<tr>
							<td colspan="3"><?-$TEXT?></td>
						</tr> 
						<tr>
							<td colspan="3"><hr /></td>
						</tr> <? I ?> 
				</table>

//---  
			// Создать список последовательных чисел от low до high
				list range(int $low, int $high) 
				Пример: 
					foreach (range(l,100) as $i){...}

*/

/*
//////// Работа с множествами:
			
//--- Пересечение:
		array array_interaect(array $array1, list $array2 [, list array3, ] ) 
		Пример: 
		$native = ["green", "red", "blue"]; 
		$colors = ["red", "yellow", "green", "cyan", "black"]; 

		$inter = array_intersect($colors, $native); // Вернет Ассоц массив с сохранением значений ключа при совпадении
		print_r($inter); // Array([0]->red [2]->green);

//--- Разность (Обратная переечнию)
		Вернет массив, составленный из array1, в которые не входят array2, array 3
		array array_diff(array $array1, list $array2 [, list array3, ... ] ) 		

//--- Объединение 
			$native= ["green", "red", "blue"); 
			$colors = ["red", "yellow", "green", "cyan"); 
			$inter= array_unique(array_merge($colors, $native));  // еСЛИ УБРАТЬ array_unique, то значения green и red встретятся 2ды

			print_r($inter); //  Array([O]=>red [l]=>yellow [2J=>green [3]=>cyan [6]=>blue) 
*/

/*
//////// JSON-формат
				JSON - Объект JS
				Функция преобразования переменных в JSON последовательность
				string json_encode(mixed $value, int $options = 0, int $depth = 512) 
								option - Битовая маска Флагов
								depth - Максимальная глубина генерируемого JSON обьекта
				
				Пример:
				$arr = [ "employee" => "Иван Иванов", 
								 "phones"	  => [ 
								 "916 153 2854"', 
								 "916 643 8420" ]
							 ]; 
				echo json_encode($arr); 
				echo json_encode($arr, JSON_UNESCAPED_UNICODE); // Для корректного отображения Кириллицы
				//"employee":"\u0418\u0432\u0430\u043d \u0418\u0432\u0430\u043d\u043e\u0432","phones": ["916 153 2854","916 643 8420"]) 
				// Иногда значения могут отличаться от ожидаемого, надо начтраивать функцию
				
				options:
				JSON_HEX_TAG - <> в UTF-8 код \u003C и \u003E 
				JSON_HEX_AMP - & в UTF-8 код \u0026 
				JSON_HEX_APOS 
				JSON_HEX_QUOT
				JSON_FORCE_OBJECT - пРИ ИСП СПИСКА, вместо массива выдавать обьект (когда список пуст или принимающая сторона принимает обьект)
				JSON_NUMERIC_CHECK - Кодирование числ в числа, а не числа в строки как о умолчанию
				JSON_BIGINT_AS_STRING- Кодирует больше целые числа в виде и строковых кивалентов
				JSON_PRETTY_PRINT - Использовать пробельные символы в возвращемых данных для их форматирования
				JSON_UNESCAPED_SlASHES - Символ (/) не экранируется
				JSON_UNESCAPED_UNICODE - Многобайтные символы кодируются как есть, по умолчанию они \uXXXX
				
				Для обьединение флагов используется побитовый или (|):
				json_encode($arr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SlASHES); 

   //--- Преобразование JSON в массив

   				mixed json_decode( string $json, bool $assoc = false, int $depth = 512, int $options = 0)		
   									Возвращает ассоциативный массив,если assoc = true, если false или не указано, то вернет обьект
   									$depth - Максимальная глубина вложенности
   									$options (JSON_BIG_INT_AS_STRING) - Большие целые инты в строки

   				Пример:
   				$json = '{"employee":"Иван Иваное ","phones": ["916 153 2854","916 643 8420"] )'; 
   				$arr= json_decode($json, true); 
   				echo "<pre>"; print_r($arr); echo "</pre>"; 


*/
?>