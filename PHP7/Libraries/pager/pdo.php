<?php

			// Постраничная навигация:

			// Автозагрузка классов:
			spl_autoload_register(function($class){
						require_once("src/{$class}.php");
			});

			try{ 
				$pdo = new POO(
					'mysql:host=localhost;dbnarne=test',
					'root', 
					'',
					[POO::ATTR_ERRMODE => POO::ERRMODE_EXCEPTION]
				);
				
				$obj = new ISPager\PdoPager(
										new ISPager\PagesList(),
										$pdo,
										'languages');

				// Содержимое текущей страницы
				foreach($obj->getltems() as $language)
				{
					echo htmlspecialchars($language['name']). "<br /> "; 
				}

				//Постраничная Навигация
				echo "<p>$obj<lp>"; 
			}
			catch (PDOException $e) { 
				echo "Невозможно утсановить соединение с БД"; 
			}

?>