<?php 
/*		ФУНКЦИИ
указывать тип данных можео только с PHP 7
		function my_func(int &$ref, int $val = 3):int/.../array {return $val;}

*/

function outer()
{
	function inner(){echo 'Влож f вызвана <br>';}
	echo 'Влож f создана <br>';
}
outer();
inner();


$a = $b = 5;
function modify(int $val, int &$ref)
{
	echo "Переданные значения: $val, $ref<br>";
		$val++;
		$ref++;
	echo "Инкреметированные значения: $val, $ref <hr>";
}
modify($a, $b);
echo "Сохраненные значения: $a, $b<hr>";

function drink(string $tmp = 'горячий',string $flavor = 'чай')
{
	echo "Пейте $tmp $flavor<br>";
}
drink();
drink('Холодный');
drink('Прохладный', 'Лимонад');

/* -------------------------------------------------
PHP 5.6 - Вызов ф-ции с неизвестным кол-вом эл-тов;
*/
function add(...$numbers)
{
	$total = 0;
	foreach ($numbers as $num) {$total += $num;}
	echo "<hr>Итого: $total<hb>";
}
add(1,2,3);

#ИЛИ

function addt($one,$two,$three){
	echo "<hr>Итого: $three<hr>";
}
$arr = [1,2,3,6,7];
addt(...$arr);




/*	-------------------------------------------------- 
Рекрусивные фукнции

*/
$number = 1;

function recur()
{
	// Если убрать static, то будут только А
	global $number; static $letter = 'A';
	if ($number<14)
	{
		echo "$number:$letter | ";
		$number++; $letter++; recur();
	}
}
recur();
echo "<hr> Глобально число: $number<hr>";

function suply(){return array(75, 3.14,'Супер PHP', TRUE);}
$array = suply();
 foreach($array as $data)
 	{echo "Значение Элемента: $data<br>";}



 /*   Анонимные функции
// После всегда Ставится ( ; ) как у переменных!!!
	function ()
	{
	return value;
	}; 

 */

/* ?????????????????????????????????????????????????? */
	$hello = function($user){ echo "<hr>Салам Алейкум, $user!<br>";};
	//Вызов
	$hello('Альба');
// Перевызов с другим параметром
	function greet(callable $anon) { $anon('Катя');}
	greet($hello); // Передать строку Катя в ф-цию hello

	function meet(): callable 
	{
		$time = 'Утро';
	// use и $ позволяет ссылаться Анон ф-ции на лок перемен в ВОЗВРАЩАЮЩ ф-ции (т.е meet();)
		return function($name) use(&$time){return "Доброе $time, $name!";};
	}
	$meeting = meet();
	echo $meeting('Вика');
 ?>


