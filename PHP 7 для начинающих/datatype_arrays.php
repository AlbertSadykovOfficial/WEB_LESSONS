<?php 
		# Комментарий одной строки
$body_temp = 36.6;
echo "<p>Температура тела составляет $body_temp по Цельсию";
$body_temp = 97.78;
echo " ($body_temp по Фаренгейту)</p>"; // ""-учитывает переменную внутри '' - Не учитывает (все текст)
 $song_title = "\"Eminem\" - Loose Yourself ";
 # Или
 $song_title = '"Eminem" - Loose Yourself';

 #	Конкатетация--
 $str1 = 'Hello ';
 $str2 = 'World';
 $str_result = $str1. ','. $str2; #Hello, World 

 $phrase = 'Правда редко бывает чистой';
 $author = 'Оскар Уайлд';
  echo "<p> Часто говорят, что <q>$phrase</q> </p>";

  $phrase = $phrase. ' и никогда не бывает простой';
  echo "<p><q>$phrase</q> <cite>$author</cite></p>";

//------------------			Массивы
//
  $days[] = 'Понедельник'; $days[] = 'Вторник';$days[] = 'Среда';
  # Или
  $days = array('Пн','Вт','Ср');
/* Узнать явл ли переменная массивом 
	is_array($var);
	Кол-во Эл в массиве
	count($var);
*/
  # Создание Имени-Ключа

  $months['янв'] = 'Январь';
  $months['янв'] = 'Февраль';
  $months['янв'] = 'Март';

  # или
// Можно начинаь массив не с 0, а с 1 значения, указав array(1 => 'Январь', ...)
 // Если мы указаи имена ключей, то уже не можем оращаться к ним по индексам
  $months = array('янв' => 'Январь', 'фев' => 'Февраль', 'мар' => 'Март');

  // echo "<p> Сейчас Месяц $months['янв']</p>";
  echo $months['янв']."<p> </p>";

  foreach($days as $value) {echo "$bull; $value "; }

echo '<d1>';
  foreach($months as $key => $value)
  	{echo "<dt>$key<dd>$value";}
  echo '</d1>';
 
 echo"<p>----------</p>";

// Последовательность значений

  $six = range(1,6);
  $a_z = range('a','z');
  echo $a_z[0];

  # Сортировка массивов
/*Создание списка значений, разделенных запятыми (CSV* Файлы) *Comma-Separated Values 
  $csv_list = implode(', ', $array);
# Преобразование строки в массив (из списка разделенного запятыми)
  $array = explode(', '. $csv_list);
/*

  /*
  Возрас		Убывание
  sort(); 	rsort(); - Сортировка по знач с отбрасыванию исходного ключа
  asort();	arsort(); - сорт по знач с сохран исх ключа
  ksort();	krsort(); - сортировка по ключу 
  */

  $cars = array('УАЗ' => 'Патриот','ГАЗ' => 'Сайбер','ВАЗ' => 'Нива',);
 
echo '<d1><dt>Исходный порядок Элементов:<dd>';
 	foreach ($cars as $key => $value) 
 		{echo ' &bull; ', $key. ' '. $value; }

# Сортировка по значению 
	asort($cars);
	 echo '<dt>Сортировка по значению (Модели):<dd>';
 	foreach ($cars as $key => $value) 
 		{echo ' &bull; ', $key. ' '. $value; }
# Сортировка по Ключу 
	ksort($cars);
	 echo '<dt>Сортировка по ключу(Марке):<dd>';
 	foreach ($cars as $key => $value) 
 		{echo ' &bull; ', $key. ' '. $value; }
echo '</d1>';


# Многомерные Массивы------------------
$letters = array('А','Б','В');
$numbers = array(1,2,3);
$matrix = array('Буква' => $letters, 'Число'=> $numbers);
echo "<p>Начало: {$matrix['Буква'][0]}</p>";
foreach ($matrix as $array => $list) 
{
	echo '<ul>';
	foreach ($list as $key => $value) 
	{ echo "<li>$array [$key] = $value ";}	
	echo '</ul>';
}
 ?>