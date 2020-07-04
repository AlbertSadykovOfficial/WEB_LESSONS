<?php 
	/*		
			Спецификаторы
			public - Члены доступны излюбой позиции видимости класса
			private - Члены доступны тольо другим членам класса, в котором определены
			protected - Члены доступны только другим членам того же класса и членам, производным от этого класса


	
	*/

			class Dog
			{
				private $age;
				private $weight;
				private $color;

				public function gaf(){ echo 'ГАВ! <br>';}

				public function set_All(int $yrs = 2, int $lbs = 10, string $fur = 'Black')
				{
					$this->age = $yrs;
					$this->weight = $lbs;
					$this->color = $fur;
				}

				public function setAge (int $yrs)
				{$this->age = $yrs;}
				public function setWeight (int $lbs)
				{$this->weight = $lbs;}
				public function setColor (string $fur)
				{$this->color = $fur;}

				public function getAge(){return $this->age;}
				public function getWeight(){return $this->weight;}
				public function getColor(){return $this->color;}


			}

			$Vilya = new Dog();

			$Vilya->setAge(10);
			$Vilya->setWeight(12);
			$Vilya->setColor('Белый');

			echo 'Шерсть Вили имеет '.$Vilya->getColor().' цвет<br>';
			$Vilya->gaf();

echo '<br>Функция set_All()<br>';
			 $Vilya->set_All();
			 echo 'Возраст Вили '.$Vilya->getAge().'года<br>'.'Вес Вили '.$Vilya->getWeight().' кг<br>'.'Шерсть Вили имеет '.$Vilya->getColor().' цвет<br>';
	

/*		Анонимные классы
		$util = new class{public function log($s){echo $s;}};
	ВЫЗОВ:
		$util->log('Data');


*/

/*	Конструкторы и Деструкторы
		__construct() 
		__destruct() 

		Функции опроса классов
		class_exists(class)
		method_exists(class,method)
		property_exists(class,property)
		get_class_vars(class) - Для видимых
		get_class_methods(class)-Для видимых
*/

	/**
	* 
	*/
	class Cat{
		private $age;
		private $weight;
		private $color;

		function __construct(int $yrs = 2, int $lbs = 5, string $fur = 'Черного')
		{
			$this->age = $yrs;
			$this->weight = $lbs;
			$this->color = $fur;
		}
	
		function __destruct(){echo 'Типа все уничтожено';}
	}
		$Alis = new Cat(3,8,'Белого');

		$items = get_class_vars('Cat');
		echo 'Переменные класса Cat: '.count($items).'(0 если все private)';

		echo '<br>Методы класса Cat: <br>';
		$items = get_class_methods('Cat');
		foreach($items as $item) 
		{echo "$item <br><hr>";}

	

	/*			Наследование классов

	*/

#	Класс Родительский
			class Polygon{
				private $width, $height;

				function __construct(int $w = 4, int $h = 5)
				{
					$this->width = $w;
					$this->height = $h;
				}

				public function getWidth(){
					return $this->width;}
				public function getHeight(){
					return $this->height;}
			}

# Классы наследования
			class Rectangle extends Polygon
			{
				public function area()
				{return ($this->getWidth() * $this->getHeight());}
			}

			class Triangle extends Polygon
			{
				public function area(){return ($this->getWidth() * $this->getHeight() / 2);}
			}

			$rect = new Rectangle();
			$trio = new Triangle();

	echo 'Площадь прямоугольника: '.$rect->area().'<br>';
	echo 'Площадь треугольника: '.$trio->area();		

	/*			Полиморфизм

	*/
 ?>