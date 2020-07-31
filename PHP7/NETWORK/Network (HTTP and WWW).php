<?php
			/*	
				header(); Длжен быть подключен в самом начале сценария.
				Не допускается: Выводить что-то перед ним в окно браузера (echo,html и тд)
				Если мы подключаем библиотеки, то после ?> в конце библиотеки не должно быть пробелов

				Для того, чтобы узнать произошел ли хоть какой-то вывод текста исп ф-цию
				В необязательные параметры file и line будет записана инфа о том где первый раз проиведен выод инфы
				bool haadars_sent([string &$file] [, int &$line]) 

				Прежде чем отправиться в браузер все заголовки накапливаются в буфер, который моно посмотреть:
				//Ответ:  Имя заголовка: Значение  (Content-type: text/plain)
				list headers_list() 

				Получение всех заголовков запроса: (но лучше исп переменные окружения, это переносимее)
				array getallheaders () 

				Часто бразуеры пытаются Кэшировать содержимое страниц, что недопустимо при динамическом
				их формировании, исходя из этого следует отключать кэширование.
					
					function nocache() { 
						header{"Expires: Thu, 19 Feb 1998 13:24:18 GMT") ; 
						header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT") ; 
						header("Cache-Control: no-cache, must-revalidate"); 
						header("Cache-Control: post-check = 0, pre-check = 0"); 
						header("Cache-Control: max-age = 0"); 
						header("Pragma: no-cache"); 
					}
				
			*/

			/* COOKIES
				Храни не влияющую на безопасноть херню, которая нафиг не сдалась в БД (статистика и тд)ю
					
					Установка (элементы, которые нужно пропустить устанавливай в "" или 0):

					(Куки появляюся только при следующем запуске сценария)
					($value - автоматически URL-кодируется/декодируется)

					int setcookies( string $name
													[,string $values]
													[,int $expire = 0]
													[,string $path]
													[,string $domain]
													[,bool $secure = false] 	// передача только через https
													[,bool $httponly = false] // Установка доступна только через http протокол и недоступна скриптам (JS)
												)
					Пример:
					// Установка до закрытия браузера
						setcookie("cookie", "I promise, by the time you're done eating it, you'll feel right as rain. "); 

					// Установка на час
						setcookie("other", "Here, take a cookie.", time() + 3600); 

					Пример (счетчикпосещений):
					($_COOKIE['counter'] значение как такововое не обновляет)
						$counter= isset($_COOKIE['counter']) ? $_COOKIE['counter'] 0; 
						$counter++; 
						setcookie("counter", $counter, 0x7FFFFFFF); 
					
					Для передачи массивов можно:
					1) В имя куки кинуть указатель на элемен массива ('arr[1][13]')
							setcookie("arr[0]", "What was said was for you and for you alone."); 
					2) Либо преобразовать массив в что-то типа JSON (serialize()) (Препочтительно)

					При этом PHP при парсе определит, что arr[0]-это массив, ане протсо набор символов и запишт значение,
					если такого массива нет - создаст.
					
					Записывать каждый элемент массива в отд куки тупая идея не только потому что это просто тупо,
					но и потому что некоторые бразуеры ставят ограничение на количество куки (но не на содержание)
					
					Получить значение (Куки: Hotel=Lafayette):
						$_COOKIE['Hotel']
						$_REQUEST['Hotel']
			*/

			/*	Разбор URL
					
					// Получить URL, составленный по анонам HTTP, Записать значение в ассоц массив $out
					// Если $out не указан, то содадутся сооветсвующие переменные (в func-локальные,в осн.прог- Глобальные)
					void parse_str(strinq $str [, array $out]) 
					
					Пример:
						$str = "sullivan=paul&names[roy]=noni&names[read]=tom"; 
						parse_str($str, $out); // sullivan=>paul names=>Array([Roy]=>noni [read]=>tom)
				
					// Собрать URL по данным из $data
					string http_build_query( array $data 
																	[,string $numericPrefix]  // -(N_) N_1, N_13 - Префикс для чисел, чтобы потом переменные извлектать
																	[,string $arg_separator]             //  Разделитель (по умолчанию &)
																	[,int $enc_type = PHP_QUERY_RFC1738] // Замена пробела (по умолчанию +) 3986 - %20
																	)
				
					// Разбор URL с записью в ассоциативный массив
					// Скобками помечено что выделфяется (Ключи и тд Гугли)
					(http)://(username):(password)@(example.com):(80)/(path)?(arg=value)(#anchor) 
						array parse_url(string $url) 

					// Обратной функции к parse_url нет, но ее можо написать:
					<?php 
							
							// Составить URL по частям массива parsed

							function http_build_url($parsed)
							{
								if (!is_array($parsed)) return false; 

								// Протокол задан?
								if (isset($parsed ['scheme'])
								{
									$sep = (strtolower($parsed['scheme']) == 'mailto' ? ':' : '://');
 									$url = $parsed['scheme'] . $sep;
								} 
								else
								{
									$url = '';
								}
								
								// А пароль и имя пользователя?
								if (isset($parsed['pass'))) {
									$url .= "$parsed[user]:$parsed[pass]@"; 
								}elseif (isset($parsed['user'))) 
								{
									$url .= "$parsed[user]@"; 
								}
								
								// QUERY STRING МАССИВ?
								if (@!is_scalar($parsed['query'])) {
									// ПРЕОБРАЗЕМ В СТРОКУ
									$parsed['query'] = http_build_query($parsed['query']); 
								}

								if (isset($parsed['host']))      	$url .= 		$parsed['host'];
								if (isset($parsed['port'])) 			$url .=	":".$parsed['port']; 
								if (isset($parsed['path'])) 			$url .=			$parsed['path'];
								if (isset($parsed['query']))			$url .=	"?".$parsed['query]; 
								if (isset($parsed['fragment']))		$url .=	"#".$parsed['fragment']; 
								
								return $url;
							}

					?>
			*/


?>