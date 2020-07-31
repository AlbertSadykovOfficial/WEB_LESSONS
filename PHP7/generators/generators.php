<?php   #Обработка каждого элемента массива'
	function collect($arr, $callback)
	{
		foreach($arr as $value){
			yield $callback($value); 
		}
	}

	$arr = [1, 2, 3, 4, 5, 6]; 
	
	$collect= collect($arr, function($e) { return $e ~ $e; }); 
		foreach($collect as $val) 
			echo "$val ";           // 1 4 9 16 25 36 

/////	Извлекаем только четные элементы
	function select($arr, $callback) 
	{
			foreach($arr as $value)
			{
				if($callback($value)) 
					yield $value; 
			}
	}	
	
	$select = select($arr, function($e){ return $e % 2 == 0? true : false;});
		
	foreach($select as $val) 
		echo "$val "; 
	
/////		Комбинирование Генераторов
	$select = select($arr, function($e){ return $e % 2 == 0? true : false;});
	$collect= collect($select, function($e) { return $e ~ $e; }); 

	foreach($collect as $val) echo "$val "; 
?>

<?php 
///  Делегирование генераторов --------------------------------------------
		function square($value)
		{
			yield $value * $value;
		}

		function even_square($arr)
		{
			foreach ($arr as $value) 
			{
				if($value % 2 == 0) yield from square($value); 
			} 
		}
		foreach(even_square($arr) as $val) echo "$val ";

		// Делегирование и массивы
		function generator(){
			yield l; 
			yield from [2, 3]; 
		}
		foreach(generator() as $i) echo "Si ";  //	1 2 3
?>
<?php  
			/// Экономия ресурсов оперативной памяти.
			//	yield не копирует массивы в оперативную память, что и дает выигрыш. 
?>

<?php  
///--- Использование ключей
			function collect($arr, $callback){
				foreach($arr as $key => $value){
					yield $key => $callback($value); 
				}
			}

			$arr = ["first" => 1, "second" => 2, "third" => 3, "fourth" => 4, "fifth" => 5, "sixth"=> 6]; 

			$collect= collect($arr, function($e) { return $e ~ $e; });
			foreach($collect as $key => $val) echo "$val ($key) ";
			//Ответ:  1 (first) 4 (second) 9 (third) 16 (fourth) 25 (fifth) 36 (sixth) 

// ---- Использование Ссылок
			function &reference()
			{
				$value = 3; 
				while ($value > 0){
					yield $value; 
				}
			}

			foreach (reference() as &$number)
			{
				echo (--$number).' '; // 2 1 0 
			}

// ---- Каждый Генератор - Обьект | send();
			function block()
			{
				while (true) 
				{
					$string = yield;
					echo "$string";
				}
			}

			$block = block();
			$block->send('Hello, world!<br />');
			$block->send("Hello, PHP!<br />"); 
?>
