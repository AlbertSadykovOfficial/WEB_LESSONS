<?php

			/*
					 phpDocumentator

					 Установка:
					 { "require": { "phpdocumentor/phpdocumentor": "2.*"}}
					 $ composer install

			*/

			/*
					Комментарий должен выглядеть следующим образом:
					/**
					*	В последней строчке не должно быть пробела
					* Между * и /
					* /
					function hello(){}

					Структура:
						1) Заголовок
						2) Описание (подробное описание с примерами, отделяется от зоголовка строкой)
						3) Теги (крткое описание метаинфомации об элементах )

					Пример:
					/**
					*	ПРИМЕР
					* 
					*	Все это сделано ради примера
					* Тут должна описываться функция
					* Функция принимает массив или обьект и выводит его структуру
					* dump(['Hello', 'world','!']); 
					*
					* @param array|object $arr 
					*
					*	@return void // Что возвращет работа функции (/** @return string|null * / )
					* /
					function dump($arr) 
					{
						echo "<pre>";
						print_r($arr);
						echo "</pre>"; 
					}
				
					Для документации служит команда
					-d - каталог
					-f - файл
					-t - каталог назначения
					$ phpdoc -f docblock.php -t docs 
					В результате в папке docs появится документация в HTML формате

					Теги могут включать в себя другие теги, их следует обрамлять {}
					{@see http://php.net/manual/en/function.htrnlspecialchars.php ~YHK!U1R htmlspecialchars()} 

					Полный список тегов, таких как авторы, параметры и т.д. найдешь сам phpDocumentator

					Пример:
						/**
						* Абстрактный класс страницы
						*
						*	@author X. Someone <someone@mail.com>
						*
						* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
						*
						*	@package Page 
						* @subpackage PHP7\Page 
						* /
						..Тут код
			*/


?>