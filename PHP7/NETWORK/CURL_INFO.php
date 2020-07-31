<?php

			/*
					Подключение:
					Win: 		(php.ini extension=php_curl.dll)
					LINUX: 	$ sudo apt-get install php7-curl 
					MAC :		$ brew install php70-curl 

					+ Скопировать файлы библиотеки (ssleay32.dll и libeay32.dll)
					 	из каталога PHP
						в папку, которая описана в переменной окружения PATH
					
			*/
			/*
					Пример подключения:

					<?php
						//Задаем адресс удаленного сервера
						$curl 			= curl_init("http:llphp.net");

						// Парметры подключения
						curl_setopt ($curl, CURLOPT_RETURNTRANSFER, l);

						//Получить содержимое страницы
						$content 		= curl_exec($curl);

						// Закртыть соединение
						curl_close 	($curl);

						echo $content;
					?>

			*/

			/*
					Параметры подключения:

					Установить параметр option = value
					bool curl_setopt(rasource $curl, int $option, mixed $value)

					В примере CURLOPT_RETURNTRANSFER вернет результат без его вывода.
					По умолчанию вывод производится в окно браузера (echo curl_exec($curl);)

					(В отлиие от сокетов нам не требуется удалять полученные заголовки, это делается автоматически)
					Включить заголовки можно так: 
						curl_setopt($curl, CURLOPT_HEADER, 1);  // Вернет массив параметров 
					А отключить при этом тело:
						curl_setopt($curl, CURLOPT_NOBODY, 1); 

			*/

			/*
					Получение тоного времени:
					Обратиться к серверам точного времени можн по 13 порту,
					они тправляют точное время постоянно 
					$curl = curl_init("http://wwv.nist.gov:13"); // 57355 15-11-29 17:55:31 00 0 0 755.5 UTC(NIST) * 1 

			*/

			/*
					Отправка данных POST
					POST запрос формируется как и GET:
					имя1=значение1&имя2=значение2

					При этом надоучитывать язык и кодировать все в URL.

					Пример:
					(Такой вид атак - автопостинг, он позволяет размещат ьекламу на сайтах, чтобы помешать такому, можно внедрить 'проверку на робота, чтобы компьтеру было сложнее пройти аунтефикацию')
					<?php
						$curl = curl_init("http://localhost/handler.php");
						curl_setopt($curl, CURLOPT_POST, 1); 

						// Создаем POST ЗАПРОС
						$data= "name=".urlencode("Игорь").
									 "&pass=".urlencocle("пароль") ."\r\n\r\n"; 

						curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

						curl_exec ($curl);
						curl_close($curl); 
					?>

			*/

			/*
					Передача Агента
					HTTP заголовки могут маодифицироваться отправителем как угодно
					Пример подмены USER_AGENT (На Windows XP, Internet Explorer 6.0):

					$useragent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows. NT 5.1)";
					curl_setopt($curl, CURLOPT_USERAGENT, $useragent);

			*/




?>