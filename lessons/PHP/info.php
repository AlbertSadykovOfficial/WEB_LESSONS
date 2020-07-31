<?php 
// Вывод всей полезной информации
 //phpinfo(); 
//phpversion();
/*
		Конструкции once - Позволяют:
		исклбчить повторений и ошибко из-за них
		Пример: вкл Библиотеки:
		library1.php
		library2.php
		2 - содержит 1ю, чтобы не было ошибок в
		связи с эти-> Интерпретатор игнорирует
		уже присущий код

		require - как и include , НО
		include-открывает файл Один раз,
		а если ошибка, то ему пофиг, А
		require - будет пытаться открыть
		файл все время
*/
include_once "dope/header.html";
	echo 'main info';
require_once "dope/footer.html";


	/*	
	Проверяет есть ли такая функции в библиотеке
	function_exists("func");
	*/
	echo function_exists("array_combine"); // TRUE - Func есть
	echo '<hr>';

/*
	print_r($object); - Выведет всю информацию класса

	clone 
	Позволяет склонировать класс, иначе
	создать обьект с разными свойствами не 
	получится, т.к  obj1 и obj2 ссылаются 
	на один и тот же объект
*/
 $object1       = new User();  
 $object1->name = "Alice";  
 $object2       = $object1;  
 $object2->name = "Amy";

 echo "object1 name = " . $object1->name . "<br>"; 
 echo "object2 name = " . $object2->name . "<br>";

	 $object1       = new User();  
	 $object1->name = "Alice";  
	 $object2       = clone $object1;  
	 $object2->name = "Amy";
  echo "object1 name = " . $object1->name . "<br>";  
  echo "object2 name = " . $object2->name . "<br>";

  class User  { public $name;}


/*		Статические функции + константы

	User::pwd_string(); // (::), при (->) Будет ошибка
  class User  
  { 
  	const PASSWORD = 111;
  	static function pwd_string()    
  	{      
  		echo "Пожалуйста, введите свой пароль,иначе пароль:<br>";
  		echo self::PASSWORD; // self::(Обращение к константам и стат переменным напрямую)
 		} 
  } 
*/

/*	Неявное обьявление свойства (не надо так делать)
Даже если в классе не сущетсвует св-ва, его можно
добавить:

$object1       = new User();  
$object1->name = "Alice";

  echo $object1->name;
  
class User {} 
*/

/*
	class Example  
	{    
		 
		 public $age = 23;        // Открытое свойство (видно всем) 
		 protected $usercount;    // Защищенное свойство (передается дочерним классам)
    
    private function admin() // Закрытый метод (есть только у объекта этого класса)    
    {      
    	//code    
    }  
	}

*/

echo "<br><hr>";
/*  Методы наследования
		
		При наследовании классов, если в дочернем классе
		есть метод, который назван так же, как и в Родит,
		то дочерн класс перезапишет его, чтобы получить
		доступ к Родительскому методу, нужно использовать
		инструкцию parent::method();

?   Если нужно использовать вызов одноименного
		метода из текущего класса, можно исп инструкцию
		self::method(); 

		Запретить перезапись метода можно, использовав
		слово final

		 class User  
		 {    
		 	final function copyright()    
		 	{echo "Этот класс был создан Джо Смитом ";}  
		 }

*/
		$object = new Son;  
		$object->test();  
		$object->test2();
  class Dad  
  {    
  	function test() 
  	{      
  		echo "[Class Dad] Я твой отец<br>";    
  	}  
  }
  class Son extends Dad  
  {    
  	function test()    { echo "[Class Son] ЛЮК <br>"; }
    function test2()   {  parent::test(); }  
  } 

echo "<br><hr>";

/*	__constructor

	При создании дочернего класса конструктор не сработает
	его нужно повторно обьявлять в дочернем классе	

*/

	 $object = new Tiger();  
	 echo "У тигров есть...<br>";  
	 echo "Мех: " . $object->fur . "<br>";
	 echo "Полосы: " . $object->stripes;

  class Wildcat  
  {    
  	public $fur; // У диких кошек есть мех
    function __construct() 
    { $this->fur = "TRUE"; }  
  }

  class Tiger extends Wildcat  
  {    
  	public $stripes; // У тигров есть полосы
    function __construct()    
    {      
    	parent::__construct(); // Первоочередной вызов родительского 
    													//конструктора      
    	$this->stripes = "TRUE";    
    }  
  }


?>