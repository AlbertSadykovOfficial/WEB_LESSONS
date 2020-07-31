<?php 
		/*
					Библиотека SPL
						Работа с Директориями (Directory Iterator)
						Фильтрация Файлов (FilterIterator)
								$filter= new ExtensionFilter( new Directoryiterator('.'), 'php');
						Постраничный вывод (LimitIterator)
								$limit = new Limititerator( new ExtensionFilter (new Directoryiterator ('.') ,"php") , 0, 5); //Нач поз/смещение
						Итератор (Вывод всего содержимого)
								$dir = new Recursivelteratorlterator( new RecursiveDirectorylterator('.'), true); 
		*/

		/*
			const 		- Сущетсвование может быть проверено методом  defined()
			public    - Доступен всем
			private   - Доступен методам только внутри класса
			protected - Доступен дочерним классам

			+ доп св-во static, которое явл ОБЩИМ для КЛАССА, а не Обьекта Класса
			+ так можно узнавать сколько создано всего классов и тд. Обращение self::count;

			Доступ к константам осуществляется через разрешение области видимости(::) CLASSNAME::, self::


		class MathComlex1
		{
				const PI = 3,14;
				public $re, $im;
				private static $count = 0;
				// Оператор используется всякий раз при исп опертора new обьекта
				public function __constructor($re = 0,$im = 0)
				{
					$this->re = $re;
					$this->im = $im;

					self::$count++;
				}
				public function _destruct()
				{
						// Вызовется автоматически при уничтожении обьекта
						 self::$count--;
				} 
				
				public static function getCount() { return self::$count; }

				public function add(MathComplex1 $y)
				{
					$this->re += $y->$re;
					$this->im += $y->$im;
				}	
			// ЧИСЛО В СТРОКУ
				function __toString()
				{
					return "({$this->re}, {$this->im})";
				}
		}

		$a = new MathComplexl;
			$a->re = 314;
			$a->im = 101;

		$b = new MathComplexl;
			$b->re = 303;
			$b->im = 6; 
		
		// Добавим одно значение к другому
			$a->add($b); 
		// Выводим Перегрузкой преобразования в строку
			echo $a->__toString();


//-- Перегрузка преобразования в строку

			В PHP присутствует ряд имен методов, начинающихся с двойных подчеркиваний
			которые имеют спец значение

			__toString(); // Вызовется автоматически каждый раз, когда мы затребуем неявное преобразоване (ссылки на обьект) в (строку)

			Пример: 
				$a = new MathComplexl; 
				$a->re = 314;
				$a->im = 101;
				echo "Значение: $a"; Эквивалентно (echo "Значение: ".$a->__toString();)
				PHP в момент интерполяции переменных вызывает метод __toString()
				Если бы не этот метод, мы получили бы ошибку:
				"Cathable fatal error: Object of class MathComplex could not be converted to string" (Не возмно преобразовать класс в строку)

//-- Использование Конструктора и дестркутора
			// Конструктор
			  // Старый метод заклчался в создании внутри класса метода с именем класса
			$a = new MathComplex2(314, 101);
			$a->add(new MathComplex2(303, 6)); 	

		*/
?>

<?php  		// ПРИМЕР, УПРОЩАЮЩИЙ ВЕДЕНИЕ ЖУРНАЛОВ
			
				class FileLogger
				{
					public $f;					// Откртый файл
					public $name;				// Логическое имя журнала
					public $lines = []; // Буфер накапливаемых строк
					public $t;

					public function _construct ($name, $fname)
					{
						$this->name = $name;
						$this->f = fopen($fname, "a+");
						$this->log("### _construct() called!");
					}
					// Закрытие файла при уничтожении обьекта
					public function _destruct()
					{
						$this-> log("### _destruct () called!");
						fputs($this->f, join("", $this->lines));
						fclose($this->f);
					}
					public function log($str)
					{
						$prefix= "[".date("Y-m-d_h:i:s ") ."{$this->name}] ";
						$str = preg_replace('l~lm', $prefix, rtrim($str));
						$this->lines[] = $str."\n";
					}
				}

				for ($n = 0; $n < 10; $n++)
				{
					$logger= new FileLogger("test$n", "test.log"); // Создаем новый класс, при этом мтарый удаляется 
					$logger->log("Hello!");
				}
				// PHP автоматически вызывает деструктор, когда обьект стал не нужен,
				// в нашем случае, он не нужен становится не нужен, когда его перезаписывают
				// в этот момент и срабатывает деструктор

				// Не смотря на то, что мы не уничтожили послежний обект, PHP сделает это сам
				exit(); 
?>

<?php  // АЛГОРИТМ СБОРА МУСОРА
			// Если скрипт +- Не потребляет много памяти, то можно отключить сборщик мусора (php.ini)
			// zend.enable_gc = flase;
			// По умолчанию сборщик мусора запускается автоматически при заполнении буфера (10 000);

			/*
				Допустим, наша переменная, обьект - это пальто, которое мы сдали в гордероб.
				Мы имеем номерок от пальто - (ссылку на обьект), который можем копировать.
				Скопировав Номерок, мы можем так же забрать свое палто.
				Допустим, мы потеряли все номерки (уничтожили все ссылки на обьект).
				Тогда Гардеробщик рано или поздно заметит, что за пальто никто не приходит 
				и сдаст его в утиль (Диспетчер динамической памяти - Сборщик мусора).
				Так, интерпретатор сразу обнаруживает обьекты на которых нет ссылок и удаляет их.

				Сложность, если ссылок много, ведь как узнать, что уничтожена послежняя?
					Для решения жтой проблемы каждый обьект хранит в себе скрытое поле 
					-Счетчик ссылок, который увеличивается автоматически при создании 1 ссылки.
					$alias = $source

					Поэтому, при обнулени происходит удаление обьекта:
					unset($alias);
			*/

					// Проблема циклических ссылок
			/*
					Допустим:
					Есть класс Родитель и ребенок.
					При чем Родитель при создании ребенка хранит ссылку на ребенка, а ребенок на родителя
					при присвоении 
						$parant = null  и child = null (счетчик уменьшается на 1)
					Но при этом память не освобождается, а доступ к обьектам уже не получить.
					Все это потому что каждый этот элемент ссылается друг на друга. 
					И сборщик мусора не найдет элементы с счетчиком 0, ведь он у них равен 1.

					Это как сдать в гардероб 2 пальто, в 1м номерок от 2, а во 2 от 1
					При этом ссылка на самого себя тоже беда:
						class Station { public $exit; }
						$theMobilAve = new Station;
						$theMobilAve->exit = $theMobilAve;
						unset($theMobilAve);								// Обьект не будет удален



			*/
?>

<?php 	// ПРИМЕР self у класса - КЭШ РЕСУРСОВ 
				
				// Локальное кэширование ресурсов по идентификатору
				// Ранее уже рассматривался пример с FileLogger, но не хорошо создавать 
				// несколько обьектов дл яодного и того же файла
				// Нужно, чтобы при передаче одинаковых имен система не создавала новый обьект
				// А возвращала существующий

				class FileLogger
				{
					static public $loggers = [];
					private $time;

					//  Закрытый конструктор - создание обьектов извне запрещено
					private function __constructor($fname)
					{
						$this->$time = microtime(true);
					}
					// Создать новый обьект можно только с его помощью
					public static function create($fname)
					{
						//  Проверяем : Обьект для указанного имени файла существует?
						if(isset(self::$loggers[$fname]))
							return self::$loggers[$fname];
						else // Иначе создаем новый обьект и записываем его ссылку в массив
							return self::$loggers[$fname] = new self($fname); 
					}

					public function getTime() { return $this->time;}

					// Другие методы...
					//...
				}

				#$logger= new FileLogger("a"); // Нельзя, доступ закрыт
				$logger1 = FileLogger::create("file.log"); // OK!
				// Код работы программы 
				 sleep(1); 
				//...
				$logger2 = FileLogger::create("file.log"); // OK!

				echo "{$loggerl->getTime()}, {$logger2->getTime()}";  // Время создания обоих обьектов 
																															// время совпадет - т.к один и тот же обьект
?>

<?php  		// Перехват обращений к членам класса
		/*	

				 __get() - Обращение на чтение
				 __set() - Установка значения неуществующему св-ву
				 __call()- Вызов метода с незарегистрированным именем

				class Hooker
				{
					private $vars = array(); 

					public function __get($name)
					{
						echo "Перехват, получаем значениен $name.<br />"; 
						return isset($this->vars[$name])? $this->vars($name) : null; 
					}

					public function __set($name, $value)
					{
						echo "Перехват, устанавливаем значение $name равным '$value'";
						return $this->vars($name) = trim($value);
					}

					public function __call($name, $arg)
					{
						echo "Перехват, вызываем $name с аргументами:";
						var_dump($args);
						return $args(O); 
					}
				}	
				$obj = new Hooker(); 		

				echo 'Установка несуществующей переменной: '.
				$obj->nonExistent = 101; 
				echo "Значение: {$obj->nonExistent}<br />"; 
				echo 'Обращение к несуществующему методу: '.$obj->nonExistent(6); 

		*/
?>

<?php  			// КЛОНИРОВАНИЕ 
			
			// МЫ не дураки, помним, что просто присвоение не прокатит, ведь это ссылка
			// Пожтому, чтобы скопировать используют clone();
			// Для принудительного запрета клонирования следует установить его как private

			/*
					$x = new MathComplex2(0, 0); 
					$y = clone $x;

			*/ 

			// Принудительные дейсвия при клонировании 
				// спец функция __clone(); (прописывай в класс)

					/*
						public $dna - какой-нибудь идентификатор
						public function __clone()
						{
							$this->dna = $this->dna."(cloned)";
						}
					*/
?>

<?php 		//  УПАКОВКА И РАСПАКОВКА КЛАССОВ в файл/из файла
			/*
					class cls
					{
							public $var;
							public function __construct($var)
							{
								$this->var = $var;
							}
					}

				//Упаковать
					$obj = new cls(100);
					// Упаковать
					$text = serialize($obj);      // Что сделает: 0:3:"cls":1:{s:3:"var";i:100;} 
						$fd = fopen("text.obj", "w");
						if(!$fd) exit("Hевозможно открыть файл");
						fwrite($fd, $text); 
						fclose ($fd); 

				//Распаковать (при этом сам класс обязательно должен быть обьявлен до)
						$fd = fopen("text.obj", "r");
						if(!$fd) exit("Hевозможно открыть файл");
						$text = fread($fd, filesize("text.obj")); 
						fclose ($fd); 
					// Восстановить:
					$obj = unserialize($text);
			
			Методы сериализации:
			__sleep(); - При сериализации
			__wakeup();- При восстановлении

			Пример:
				(При сохранении пользователя нежелательно зранить его пароль на диске, поэтому его не следуетсозранять):
				(При восстановлении желательно обновить время)
				class user
				{
					public function __construct($name,$password)
					{
						$this->name = $name;
						$this->password = $password;
						$this->refferer = $_SEREVER['PHP_SELF'];
						$this->time = time();
					}
					public function __sleep()
					{
						return ['name','referrer','time'] ; 
					}
					public function __wakeup()
					{
						$this->time = time(); 
					}
					public $name;
					public $password;
					public $refferer;
					public $time;
				}

			*/

?>

<?php // НАСЛЕДОВАНИЕ
				
			// У нас вверху есть класс FileLogger (будет отталкиваться от него)
			// !!! Если мы переопределяем класс, то его модификатор доступа должен быть таким же или менее строгим, чем был
			// !!! Так, если был арг (public var) У Родителя, то он не может быть (private var) У Дочернего класса

			// Запрет наследования класса
			// final class Base {} 

			// Запрет на переопределение в классе - родителе (final) выглядит так :
			// public final function test() {}  // Помогает в безопасности для прав доступа
			
			
			class FileLoggerDebug extends FileLogger
			{

				public function __construct($fname)
				{
					// Синтаксис вызова методов Класса - Родителя (Чтобы избежать бесконечной рекурсии)
					// Так же можно исп FileLogge:: и self::
					parent::__construct(basename($fname), $fname); 
				}
				// Новый метод
				public function debug($s, $level = 0)
				{
						$stack = debug_backtrace(); 
						$file  = basename($stack[$level] ['file']);
						$line  = $stack[$level]['line']; 

						$this->log("[at $file line $line] $s"); 
				}
				//Остальное наследуется автоматически
			}
?>

<?php // КОНСТАНТЫ __CLASS__ и __METHOD__
				//__CLASS__  - Заменяются интерпреатором на текущее имя класса
				//__METHOD__ -Заменяются интерпреатором на текущее имя Метода/функции
			
			// Ограничение : Не позволяют переопределить статический метод в производных классах
			/*
						class Base
						{
							public static function title()
							{
								echo __CLASS__;
							}
							public static function test()
							{
								self::title();      //  2) static::title(); 
							}
						}
						class Child extends Base
						{
							public static function title()
							{
								echo __CLASS__;
							}
						}
							Child::test(); //Base // 2) Child
				*/

				// Для решения этой проблемы PHP исп специальное слово static
				
?>

<?php  // АНОНИМНЫЕ КЛАССЫ
				// Есть еще вложенные анонимные классы, но я не понял как они радботают и зачем
				class Dumper
				{
					public static function print($obj)
					{
						print_r ($obj);
					}
				}

				Dumper::print( new class {
					public $title;
					public function __construct() 
					{
						$this->title = "Hello world!";
					}
				}) ; 
				/// Out: class@anonymous Object ( [title] => Hello world! ) 
?>

<?php // ПОЛИМОРФИЗМ 

/*
		Полиморфизм (многофменность) - Способность классов предоставлять единый программный интерфейс
		при различной реализации (возможность при этом переопределять поведение методов).
		Полиморфность - способность бьекта использовать методы производного класса.
		Методы, которые могут переопределиться в классе назваются ВИРТУАЛЬНЫМИ (АБСТРАКТНЫМИ)

		Базовые классы,  которые не меняются и на основе которых будут построены другие обычно преписывают
		словом abstract. Так же и поступают с Промеуточными Классами и при доавлении в промежуточных 
		АБСТРАКТНЫХ Классах новых абрактных функций.

		Пример:
		Класс Page - базовый.
					User и Cached - дочерние (User не надо хранить в кэше)
					Cached -> Static Page, Catalog, News. Дочерние у Cached
*/

		/** Пример Классов
		* 	Пример иллюстрирует рботу с memcahe.(Хранение Данных в Оперативной памяти)
		*/
		abstract class Page
		{

			protected $title;
			protected $content;
			
			public function __construct($title='', $content='')
			{
				$this->title = $title;
				$this->content = $content;
			}

			public function title()		{	return $this->title;}
			public function content()	{	return $this->content;}

			public function render()
			{
				echo "<h1>".htmlspecialchars($this->title()) ."</h1>"; 
				echo "</p>".nl2br(htmlspecialchars($this->content())) ."</p>"; 
			}

		}

		/**
		* 
		*/
		abstract class Cached extends Page
		{
			protected $expires; // Время действия Кэша
			protected $store;
			
			public function __construct($title='', $content='',$expires = 0)
			{
				// Конструктор базового Класса
				parent::construct($title, $content); 

				// УСТАНАВЛИВАЕМ ВРЕМЯ ЖИЗНИ
				$this->expires = $expires;
					// Хранилище
					// $this->store = new Memcached();
					// $this->store->addServer('localhost', 11211);  

				// Кидаем данные в хранилище
				$this->set($this->id('title'), $title); 
				$this->set($this->id('content'), $content); 
			}

			// Проверка существования ключа в Кэше Сервера
			protected function isCached($key)
			{
				// return (bool) $this->store->get($key)
			}

			protected function set($key, $value, $force = false)
			{

				//if ($force) 
				//{
				//	$this->store->set($key, $value, $this->expires); 
				//} else {
				//	if($this->isCached($key)){
				//		$this->store->set($key, $value, $this->expires); 
				//	}
				//} 
			}
			protected function get($key)
			{
					// return $this->store->get($key); 
			}

			abstract public function id($name)
			{
				die('ВЫЗОВ ИЗ АБСТРАКТНОГО КЛАССА');
			}
			public function title()
			{
				// if ($this->isCached($this->id('title'))) return $this->get($this->id('title')); 
				// else 																		return parent::title(); 
			}

			public function content()
			{
				// if ($this->isCached($this->id('content'))) return $this->get($this->id('conten')); 
				// else 																			return parent::content(); 
			}

		}

		/**
		* 
		*/
		class StaticPage extends Cached
		{
			
			public function __construct($id)
			{
				// Проверяем нет ли странциы в кэше
				if ($this->isCached($this->id($id)))
				{
					// Есть - Инициализируем обьект
					parent::_construct($this->title(), $this->content()); 
				}	else {
					// Данные  не кэшированы - извлекаем из БД
					// (Сравнительно долго)
							// $query= "SELECT * FROM static_pages WHERE id = :id LIMIT 1" 
							// ИЛИ
							// $query= "SELECT * FROM news WHERE id = :id LIMIT 1" 
							// ИЛИ
							// $query= "SELECT * FROM catalog WHERE id = :id LIMIT 1" 
					// $sth = $dbh->prepare($query); 
					// $sth = $dbh->execute($query, [$id]); 
					// $page= $sth->fetch(PDO::FETCH_ASSOC:); 
					// parent::_construct($page['title'], $page['title']); 
					parent:: _construct ( "Контакты", "Содержимое страницы") ; 
				} 

				// Уникальный ключ
				public function id($name) 
				{ 
					// Префикс для того, чтобы в кэше данные не пересекались с Новостями (news)
					return "static_page_{$id}";  
				}
				// ИЛИ
				// public function id($name) { return "news_{$id}"; }
				// public function id($name) { return "catalog_{$id}";  } 
			}
		}

		$id = 3;
		$page = new StaticPage($id); 
		$page->render(); 			// Контакты Содержимое страницы
		echo $page->id($id);  // static_page_3


		// Проверки на типы классов  (instanceof)
		function echoPage($obj)
		{
			$class = "Page"; 
			if (!($obj instanceof $class)) 
				die("Argument 1 must be an instance of $class.<br I>"); 
			$obj->render(); 
		}
			$page = new StaticPage(3); 
			echoPage($page); 


		// Обратное преобразование (проверка набора св-в и методов обьекта)
			else if ($obj instanceof News) echo "Работаем с Новостями"; 
?>

<?php
				// ИНТЕРФЕЙСЫ И ТРЕЙТЫ

	/*
			В PHP нет возмодности наследовать сразу несколько классов как в Java и C#,
			т.к это это влечет за сбой много трудостей (одинаковые названия и тд)
			Поэтому для имитации таких возможностей служат Интерфейсы и Трейты.

			Интерфейсы - обычный абстрактный класс, который не содержит свойств,
			а содержит методы, которые не должны быть описаны.

			Трейты Содержат не абстрактные методы,а общие фрагменты классов.

			При этом класс словно заключает сделку с интерфейсом (если он его
			использует), он обязан определить все его методы

			Допустим в Catalog и News есть информация, которая не должна быть
			в StaticPage, значит следует ввести Интерфейс, который будут исп
			только Catalog и News. 
			А еще News и StaticPage имеют что-то, что не должно быть в Catalog,
			тогда мы добавим еще 1 интефейс.

//-- Интерфейсы
			interface SEO_info 
			{ 
				public function keywords(); // тело не указается
				public function description(); 
				public function ogs(); 
			}
				
			interface Tag 
			{
				public function tags(); 
			} 

			class Page StaticPage extends Cached implements SEO_info, Tag
			{
				public function keywords(){};
				public function description(){}; 
				public function ogs(){}; 
				public function tags(){}; 
			}


			// Наследование Интерфейсов 
				// При наследованиии Интерфейсов Интерфейс-родитель 
				// уже нельзя использовать при обьявлении класса
				// При исп с абстрактными классами, как обычно далжны быть описаны их методы

			  interface Author extends Tag
			  {
						public function info($id); // информация Об Авторе
			  }
	
//-- Трейты
			trait Seo
			{
				private $keyword; 
				private $description; 
				private $ogs; 
				
				public function keywords(){
					// $query= "SELECT keywords FRCJ.1 seo WHERE id• :id LIMIT 1" 
					echo "Seo::keywords<br />"; 
				}
				public function description() 
				{ 
					// $query• "SELECT description FRCJ.1 seo WHERE id• :id LIMIT 1" 
					echo "Seo::description<br />";
				} 
				
				public function ogs()
				{ 
					// $query= "SELECT ogs FRCJ.1 seo WHERE id= :id LIMIT 1" 
					echo "Seo::ogs<br />"; 
				}
			}

			trait Tag 
			{
				public function tags() 
				{ 
					// $query= "SELECT* FRCJ.1 authors WHERE id IN(:ids)"
					echo "Tag: : tags<br />";
				} 
			}

			class News 
			{
				// Новости снабжающиеся Сео инфой и списком авторов
				use Seo, Tag; 
				private $id; 
			}

			$news->new News(); 
			$news->keywords(); 	Seo:: keywords 
			$news->tags();			Tag::	tags 


			//  Конфлиы=кты имен и их разрешение:

				trait Tag
				{
					public function tags() 			echo "Tag: : tags<br />"; 
					public function authors() 	echo "Tag: : authors<br />"; 
				}

				trait Author
				{
					public function tags() 			echo "Author: : tags<br />"; 
					public function authors() 	echo "Author: : authors<br />"; 
				}

				class News
				{
						use Author, Tag
						{
							Tag::tags insteadof Author;  		// Ставим Приоритет tags у Author Выше, чем у Tag
							Author::authors insteadof Tag;  // Ставим Приоритет authors у Tag Выше, чем у Author
							Author::tags as list; 					// Позволяем обращаться к tags у Author через list
						}
				}

	*/
?>

<?php 		// ПРОСТРАНСТВО ИМЕН 

	/*
					Проблема именования:

					Когда происходит расширение проекта или Библиотеки, то назвать новые функции 
					и что-то еще становаится проблематично. Для того, чтобы можно было использовать
					одинаковое имя функций и не увеличивать длину названий с версии PHP 5.3 было
					введено Пространсво Имен.
					
					Пространсво имен - имеющий имя фрагмент программы, содержащйи в себе функции, переменные,
					программы и другие именованные сущности.
					В пространсве имен может содержаться любой PHP код, но действия пространства распространятся 
					лишь на классы, функции, интерфейсы, константы.

					Пространсво имен организовывает код в виртуальной иерархии, напоминающей фйловую
					систему. (Словно файлы с одинаковым именем в разных каталогах/папках)

					Обьявление:
					!Особенность оператор namespace ДОЛЖЕН БЫть в самом начале 
					<html>
					<?php namespace PHP7;  //Fatal Error
					
					<?php # namespace.php
						namespace PHP7; 

						function debug($obj){   }

						class Page {}
					?>

					<?php # Другой файл
						
						require_once 'namespace.php'

						$page = new PHP7\Page('Каталог','Содердимое катлога');

						PHP7\debug('page');
					?> 


					// Доступ к глобальному пространсву имен осуществляется через \
						namespace PHP7;
						strlen(); // Ф-ция пространсва имен PHP7
						\strlen(); // Встроенная функция


					// Импортирование и Псевднимы:
							use PHP7\classes\Page as Page; 
							use PHP7\functions as functions;

							Если имя Псевдонима совпадает с последним словом иерархии, то можно сократить:

							use PHP7\classes\Page; 
							use PHP7\functions;  
				

				// Функция автоматической подгрузки классов 

					function __autoload($classname)
					{
						require_once(__DIR__. "/$classname.php"); // Или include_once || require || include
					}
					
					// Регистрация очереди ф-ций автозагрузчиков (Так, кадая библиотека моет реализовать чвой механизм автозагрузки)
					// Все параметры необязательны
					spl_autoload_register(
											[callable $autoload_function     // Функция обратного вызова (или анонимную ф-цию)
											[, bool $throw = true 					 // Генерируется ли исключение
											[, bool  $prepend = false]]]);   // Добавление ф-ций в конец цепочки = false 
	*/	


	/*  НЕЯВНЫЙ ВЫЗОВ (Динамическе создание/вызов)
				
				Используется также как и с функциями:
					$funcName = 'trim';
					call_user_func($funcName, " What? What did I just say? "); 

					$addMethod = "add"; 
					$a = new MathCornplex2(101, 303); 
					$b = new MathComplex2(0, 6); 
					call_user_func([$a, $addMethod], $b); 


				Для массивов данных:
					$args = (101, 6); 
					$result = call_user_func_array("test", $args);								// Функция
					$result = call_user_func_array([$obj, "test"], $args); 				// Класс
					$result= call_user_func_array{["ClassName", "test"), $args);	// Статичекий метод класса

	
				Инстанцирование классов - (Сздание обьекта некоторого класса)
				$className = "MathComplex2";
				$obj = new $className(6, 1); 

				Инстанцирование с переменными, генерируемымми находу
				$className = "MathComplex2";
				$args = [l, 2]; 
				// Создадим обьект, хранящий всю информацию о классе (т.е рнит информацию о нашем классе)
				$class = new ReflectionClass($className); 
				$obj = call_user_func_array{ [$class, "newInstance"], $args); 


				Аппарат Отражений 
				Отражения хранят информацию 'об информации' - Имя, место в программе, данные  об аргументах
				Отличительная особенность - мы можем взаимодействовать с обьектом (ВЫЗЫВАТЬ НЕЯВНО ФУНКЦИИ, к примеру)

				function throughTheDoor($which) {echo "(get through the $which door)"; } 
				$func =new ReflectionFunction{'throughTheDoor') ; 
				$func->invoke("left");  // invoke вызывает функцию для которой создано отражение (как call_user_func(), но для ООП - лучше так)

				ВСЕ классы отражений реализуют интерфейс Reflector.


				Отражение функций
				ReflectionFunction
					Принимает один аргумент - имя функции, если ф-ции не существует Возбуждает исключение ReflectionException.
					Какие методы реализует - читай не здесь, в падлу все это переписывать. (Можно узнать о файле хранение, функции...)
					try { $obj = new ReflectionFunction ("spoon"); } catch (ReflectionException $e) { echo $e->getMessage();}

					Интересен метод getDocComment() - вернет комментари перед этой функцией (если он задокументирован так)
					/**
					*	Documentation 
					* (После /** не должно быть пробелов)
					* /
					function hello(){};
				
				ReflectionParameter (Содержит данные опереданном параметре функции)
				ReflectionClass (Хранит инфу о классе) Имеет много методов, поэтому гугли если надо
					Стоит знать - Если мы сздаем ReflectionClass для дочернего класса, то у нас не будет достпупа к privat
					эл-там его родителя. 
				ReflectionProperty (Информация о СВОЙСТВЕ КЛАССА)
				ReflectionMethod   (Информация о МЕТОДЕ КЛАССА) Схожа с ReflectionFunction
				ReflectionExtension(Получить свойства подключенного Расширения) (Имя, версия, функции, константы, директивы, отлад. представ)
					$consts = [] // Список всех констант
					foreach (get_loaded_extensions() as $name) 
					{ 
						$ext= new ReflectionExtension($name); 
						$consts = array_merge(Sconsts, Sext->getConstants()); 
					}
				Не Классы-Отражения:
				Reflection
						class Reflection{
							public static array getModifierNarnes(int $modifiers); 					// Принимает битовыю маску, возвращает тект. представ
							public static string export(string $refl, boo; $return=false); 	// Отладка Принять Обьект-отражение, вызвать у него __String();
						}

				ReflectionException (Исключение) // Наследует Exception, ничего не меняя (Сздан для классификации исключений)

				Иерархическая структура:
				class Reflection { } 
				interface Reflector { }
					class ReflectionFunction implements Reflector {} 
						class ReflectionMethod extends Reflection_Function { } 
					class ReflectionPararneter implements Reflector { } 
					class ReflectionClass implements Reflector { } 
					class ReflectionProperty implements Reflector { } 
					class ReflectionExtension implements Reflector { } 
				class ReflectionException extends Exception { } 
	*/
?>