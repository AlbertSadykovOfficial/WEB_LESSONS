<?php

			/*
				Спискок хороших компонентов можно найти тут:

				https://github.com/ziadoz/awesome-pbp.

			*/

			/*
				Пример своего компонента:
					Папка pager

				Размещение компонента:
				$ git add
				$ git commit -am "Initialize ISPager"
				$ git remote add origin git@github.com:someone/paper.git
				$ git push -u origin master 
				
				Назначить версию:
				$ git tag -a v1.0.0 -v 'Version 1.0.0'
				$ git push origin v1.0.0 

				Скопировать проект:
				$ git clone https://github.com/someone/pager.git

				Для публикации на Pakegist
					Войти в раздел Submit
					Ввести Repository URL -> https://github.com/someone/pager.git
					Нажать Check
				
				Теперь компонент можно использовать:
				{
					"require": { 
						"someone/pager": "*" 
						}
				}
				 Пример импользования:

				 <?php
						require_once(__DIR__. 'vendor/autoload.php');

						$obj = new ISPager\FilePager(
											new ISPager\ItemsRange(),
											'../../math/largetextfile.txt');

						foreach($obj->getitems() as $line) {
							echo htmlspecialchars($line) ."<br I> "; 
						}
						
						echo "<p>$obj</p>"; 
				 ?>

			*/

			/*

				Компоенты (Библиотеки) - коллекция связных классов, интерфейсов и трейтов, 
				которые решают определенную задачу (компонент-парсер RSS, компонент-обертка HTTP запросов)

				Компоненты могут сам состоять из компонентов, чтобы все их скачатьи обьединить может 
				понадобиться много времени, поэтому придуманы спец программы, которые сдлеют все сами,
				такие как Composer:

				Установка:
					
				Windows:
					Загрузить с сайта:
					https://getcomposer.org/Composer-Setup.exe

					+ установить расширение OpenSSL (php.ini extension=php_openssl.dll)
					Можно установить и через PHAR - архивы PHP
					PHAR - исполняемый архив (в него можно засунуть много файлов, которые потом автоматически распакуютс итерпретатором)
					Для создания команды в Composer:
					@php "%-dp0composer.phar" %* 
				
				MAC:
					sudo brew install composer

				Ubuntu:
					$ php -r "readfile('https://getcomposer.org/installer');" | php 

					Если curl или wet установлены:
					$ curl -sS https://getcomposer.org/inataller | php 

					Чтобы файл был доступен, следует поместить его сюда (и + можно переименовать для удобного доступа):
					(Права доступа должны позволять исполнение 0755)
					$ mv composer.phar /usr/local/bin/composer
					$ php composer --version

			*/

			/*  Установка пакета

					Каждый пакет имеет имя и версию, в свое время имя состоит из 2х частей: Имена производитя/пакета

					Для устанвки понадобится создание файла в коневом каталоге с названием composer.json и содержанием:
					{
						"require": { "monolog/monolog": "1.17.*" }

					}
						1.17.*         - диапазон пакета от 1.17.0 до 1.18
						1.17.0 - 2.0.0 - Диапазон от 1ч до 2ч
						~1.17          - От ТЕКУЩЕЙ ДО 2.0
						~1.17.2 			 - От текущей до 1.18
					
					Для установки следует в папке с конфигурационным файлом выполнить команду:
						$ composer install
					
					После этого автоматически создастся:
					 Папка vendor 
					 Файл composer.lock (содержит древо зависимостей пакетов, источник загрузки, точные версии пакетов)

					Для обновления до новой версии пакета(+ автоматически поправится coposer.lock):
					$ composer update monolog/monolog
					
			*/

			/* 	Подклчение компонента
					
					В папке vendor содержится фалй autoload.php.
					Для автозагрузки компонетов следует воспользоваться подключением:
						require_once(__DIR__. '/vendor/autoload.php'); 

						После чего компонент можно использовать:
						$handler= new Monolog\Handler\StreamHandler('app.log', Monolog\Logger::WARNING); 
			*/


			/*
					Поезные компоненты:

				//--psySH (Интерактивный отладчик)

					 	Подключить (psysh/composer.json) : { "require": { "monolog/monolog" : "1 .17.*", "psy/psysh": "*" } }
						Установить: 												composer install

						В точке, где необходимо выполнить отладку следует включить:
						eval(\Psy\sh()); 

						При этом вывод в браузер пректратиться и 
						дальнейшие действия будут оступны в консоли сервера.
						Отладчик позволит запускать любой php код, посмотреть состояние переменных или вызвать метод класса
				

				//--phinx Миграции

						Создав таблицу или изменив состоав столбцов ней нуно быть увереным, что на всех 
						рабочих станциях и серверах произошло это изменение.

						Вместо того, чтобы менять БД напрямю SQL КОМАНДАМИ, создают файлы PHP, которые содержат
						выводы методов специального класса

						В БД как правило есть таблица, фиксирующая выполненные миграции. Если миграция не зарегистрирована,
						то она вполняется и заносится в таблицу. Зарегистрированные миграции протсто игнорируются.

						Миграции позволяют и воссоздавать схему БД, если оно утеряна. Удобно исп и систему контроля версий для
						отката как PHP кода, так и миграций

						Подключить (phinx/composer.json): { "require": { "rot:rnorgan/phinx": "*"} }

						После этого в каталоге компонентов создается папка bin с командами для Win(phinx.bat) и UNIX(phinx)
						Для обращение к команде из корня проекта указвается путь: ./vendor/bin/phinx 
						(Можно прописать путь до vendor/bin и в переменной окружения PATH)

						Инициализация компонента:
						$ phinx init

						Это создаст конфигурационный файл  phinx.yml, который позволет задать параметры соединения с БД.
						Режимы работы:
							 production  - производстенный
							 development - разработки
							 testing  	 - тестовый
						Параметры соединения для режимов:
							aqdapter - тип БД, поддерживается MySQL, PostgreSQL, SQLite, SQL Server (по умолчанию mysql)
							host 		 - адрус сервера БД
							name     - название БД
							user     - имя пользователя
							pass     -
							port     - порт сервера БД (MySQL = 3306)
							charset  - кодировка оединения (по-умолчанию utf-8)


						ПОДГОТОВКА Миграции
							
						Необходимо вызвать phinx create и дать уникальное название миграции в CamelсCaseStyle
						$ phinx create CreateUserTable 

						Для миграций, предложенных впервые будет сздана папка db/migrations, в отоырй расположится
						файл миграции вида: YYYYMMDDHHMMSS_create_user_table.php;
						Внутри файла класс названный как имя миграции, который содержит пустой метод change,
						в который можно поместить код создания БД.
							
							public function change()
							{
								$table = $this->table('users'); 
								$table->addColumn('first_name', 'string')
											->addColumn('last_~·, 'string')
											->create();
							}

						Пример исп доп параметров:
						$table->addColumn('first_name', 'string', ['limit' => 50, 'null' =>false]) 	

						ВЫПОЛНЕНИЕ миграции:
						
						Необходимо вызвать phinx migrate и передать через -e название окружения
						$ phinx migrate -e davelopment 

						После этого будет создана таблица (users), которую мы сделали в подготовке,
						а запись о миграции запишется в файл phinxlog
						mysql> SELECT * FROM phinxlog; 


						ОТКАТ миграции:
						$ phinx rollback -e davelopment 

						(После этого удалится таблица users и регистрационная запись из phinxlog)

						Не все операции можо откатить, к примеру, нельзя откатить удаление столбца (т.к данные утеряны)

						ИЗМЕНЕНИЕ МЕХАНИЗМА отката
						вместо метода change в класс миграции следует поместить:
						up()	 - для миграции
						down() - для отката

						Пример:
						class CreateUserTable extends AbstractMigration 
						{
									public function up() 
									{
										$table = $this->table('users'); 
										$table->addColumn('first_name', 'string')
											->addColumn('last_~·, 'string')
											->create();
									}

									public function down()
									{
										$exists= $this->hasTable('users'); 
										if ($exists) { 
												$this->dropTable('users'); 
										}
									}
						}
					Для переименования:
					$table= $this->table('users'); 
					$table->rename('profiles'); 


					Получить Таблицу:
					$table= $this->table('users'); 

					Получить Столбцы таблицы:
					$columns= $this->table('users')->getColumns(); 

					Проверить существование столбцов:
					if($this->table('user')->hasColumn('first_name'))

					Переименвать:
					$table= $this->table('users')->renameColumn('first_name', 'name'); 

					Удалить:
					$this->table('users')->removeColumn('short_name')->update();

			// Подготовка тестовых данных (seed)
					Чтобы при разработке при тестировании не тратитть время на то, чтобы забивать данные в БД,
					создана функция, котрая сделает это за человека.
					
					Для этого служит функция phinx seed:create (CamelStyle pls)
					$ phinx seed:create UsersSeeder 

					При выполнении команды впервые будет предожено создать папку db/seed, в которуюпоместиться новый
					seed файл UsersSeeder.php,rjnjhsq , который будет содержать одноименный класс с методом run(), куда
					можно будет прописат заполнение данных

					Для запуска seed файла на ыполнение следует исп команду:
					(По умолчанию выполнятся все файлы в папке db/seed)
					$ phinx seed:run -e development
					$ phinx seed:run -s UsersSeeder -e development // Для выолнения конкретного файла

			*/


?>