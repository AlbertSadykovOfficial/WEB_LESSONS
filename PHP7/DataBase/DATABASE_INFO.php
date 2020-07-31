<?php


			/*
					Для гарантии уникального значения сужит PRIMARY KEY
					Припопытки записать одинаковое значение язык выдаст ошибку
					Для Игнора этой ошибки следует сделать так (значение все равно не запишется):
					INSERT IGNORE INTO tbl VALUES(1);

					ВЫбрать отсортированное значение
					SELECT catalog_id, name FRCM catalogs ORDER BY catalog_id;

					Узникальное значение:
					SELECT DISTINCT catalog_id, name FROM catalogs ORDER BY catalog_id;
					SELECT catalog_id FROM tbl GROUP BY catalog_id ORDER BY catalog_id; 

			*/

			/*
				// Изменит таблицу
					ALTER TABLE table_name spec 
					
					Пример:
					// Добавить в табл forum столбец test после столбца name
					ALTER TABLE forum ADD test int(1O) AFTER name; 
					
					// Переделать стобец
					ALTER TABLE forum CHANGE test naw_test TEXT; 

			*/

			/*
					Вставка каледарных значений:
					CREATE TABLE(
										id int(11) NOT NULL,
										putdate DATETIME NOT NULL,
										lastdate DATE NO NULL
										);
					INSERT INTO tbl VALUES (1, '2016-01-03 0:00:00', '2016-01-03');
					INSERT INTO tbl VALUES (2, '2016-01-03 0:00:00', '2016-01-03 0:00:00'); //Во 2 отбросятся 0ли. т.к они лишние для этого фрмата
					INSERT INTO tbl VALUES (3, NOW(), NOW()); // Текущее время
					INSERT INTO tbl VALUES (4, '2016-01-01 0:00:00' - INTERVAL 3 WEEK, NOW() + INTERVAL 3 MONTH) ; 

					Многоступенчатый INSERT:

					INSERT INTO catalogs VAULUES (NULL, 'Процессоры'), (NULL, 'Материнские платы');
					INSERT INTO catalogs (name) VALUES ('Процессоры'), ('Материнские платы');

					REPLACE - Заменяет значение старой записи при UNIQUE или PRIMARY KEY.

			*/

			/*
				Сортировка (DESC - обратный порядок)
				SEIECT * FROM tbl ORDER BY catalog_id DESC, putdate DESC;
				
				Случайный порядок
				SELECT catalog_id, name FROM catalogs ORDER BY RAND();
				SELECT catalog_id, name FRCM catalogs ORDER BY RAND() LIMIT 1;

				SELECT catalog_id, name FORM catalogs 
				ORDER BY catalog_id DESC 
				LIMIT 2, 2;    // 1 число - пзиция с которой нужно вернуть результат, 2 - кол-во извлекаемых элементов
			*/
?>

<?php

			/*	PDO
					
				PDO - интерфейс для дотсупа к БД PHP (позволяет облегить переход с одной БД на другую)
				Усановка:
					Win (php.ini раскомментировать строку):
						extension = php_pdo_mysql.dll
					Ubuntu:
						$ sudo apt-get install php7-mysql
					Mac:
						$ brew install php70-mysql 
			
			*/

			/*
					Установка соединения с БД:

					//$dsn - название драйвера имя и пароль БД
					PDO::__construct(
											string $dns
											[,string $username
											[, $password
											[, array $options]]]
													)
						$option Ошибок:
							PDO::ERRMODE_SILENT  		// По умолчанию (извлекаются через errorInfo())
							POO::ERRMODE_WARNING 		// Генерация Предупреждений PHP
							POO::ERRMODE_EXCEPTION  // Генерация исключений (PDOException)
						Пример:
							$option = [PDO::ATTR_ERRMODE => PDO: :ERRMODE_EXCEPTION]

					Пример:
					// В случае неудачи генерируется искючение 
					try{
						$pdo = new POO('mysql:host=localhost;dbname=test','root','');
					} catch (PDOException $e) {echo 'невозможно уст соединение'}


					Запросы:
					$query 	= "SELECT VERSION () AS version";
					$ver 		= $pdo->query($query); 

					$version= $ver->fetch(); 
					echo $version['version'];


					Выполнени запроса (вернет кол-во затронутых записей)
					public int PDO::exec(string $statement);

					$count = $pdo->exec($query); 
					print_r($pdo->errorInfo());


			//--fetch()
					fetch извлекает содержимое в виде ассоциативного массива с доступом по именам при сохранении доступа по числу
					$catalog = $cat->fetch();

					Константы изменения поведения:
					POO::FETCH_NUM  (Только индексный массив)
					POO::FETCH_CLASS(В виде обьекта, свойства - названия солбцов)
					POO::FETCH_BOTH (По умолчанию)
			
			//-- Парметризированный запрос
					
					//Извлечь из таблицы ctalogs запись, гду catalog_id = 1
					// Параметр (:catalog_id) заполяется в результате выполнения методом execute
					
						$query = "SELECT * FROM catalogs WHERE catalog_id = :catalog_id";
						$cat= $pdo->prepare($query);
						$cat->execute(['catalog_id' => 1]);  

						или
						$query = "SELECT * FROM catalogs WHERE catalog_id = ?;
						$cat= $pdo->prepare($query);
						$cat->execute([1]); 
			*/


?>