<?php
			

			/*
				Фильтры Проверки Данных: 
				
				Фильтрует $variable по фильтру с параметрами
				mixed filter( 
								mixed $variable 
								[,int $filter = FILTER_DEFAULT
								[,mixed options]]
								);

				Пример:
					$email_wrong = 'aloyalyoha@//gmail.com'; 
					filter_var($email_wrong, FILTER_VALIDATE_EMAIL); // false 
					 filter_var($email_wrong, FILTER_SANITIZE_EMAIL) // aloyalyoha@gmail.com

					Фильтры проверки:
						FILTER_VALIDATE_EMAIL
						FILTER_VALIDATE_IP
						FILTER_VALIDATE_REGEXP (если значение соответсвует regexp заданному в доп параметре options)
						FILTER_VALIDATE_URL
						FILTER_VALIDATE_(BOOLEAN INT FLOAT)

					Доп флаги:
						BOOLEAN: FILTER_NULL_ON_FAILURE (ВЕРНЕТ null при неудаче)
						FILTER_VALIDATE_IP:
							 FILTER_FLAG_IPV4 (Ip в формате IPv4)
							 FILTER_FLAG_IPV6
							 FILTER_FLAG_NO_PRIV_RANGE - Запрещает успех при ipv4:  10.0.0.0/8, 172.16.0.0/12 192.168.0.0/16 и IPv6: FD, FC
							 FILTER_FLAG_NO_RES_RAN - Запрещает для : ipv4: 0.0.0.0/8, 169.254.0.0/16, 192.0.2.0/24, 224.0.0.0/4.
						INT (дает возможность указать max и min) а ЕЩЕ КО ВСЕМ моожно применять значение по умолчанию: 
							$options = [
											'options'=>[
														'min_range'=>-10, 
														'max_range' => 10,
														'default' => 10 
																]
														];
						REGEXP:
							$options = [
											'options'=>[  'regexp' => "/^ch\d+$/"  ]
												 ];
					

					Для массива:

					Массив данных data и массив фильтров defenition
					В случае неудачи элемент содержит null
					Если третй параметр false, то не прошедший проверку эоемент будет false
					mixed filter_var_array ( 
										array $data 
										[,mixed $defenition
										[, bool $add_empty = true]]);

			*/

			/*
				Фильтры Очистки Данных: 

				Пример:
				FILTER_SANITIZE_ENCODED - кОДИРУЕТ ДАННЫЕ ДЛЯ ПЕРЕДЧИ ПО url
				FILTER_UNSAFE_RAW - Бездействует, при необходимости удаляет или кодирует спец символы
				FILTER SANITIZE SPECIAL CHARS - экранирует html
				FILTER_SANITIZE_EMAIL - удаляет все символы, котрые не могут быть в email.
				...Остальные ищи в интернете

			*/

			/*	Пользоваьелькая фильрация данных (FILTER_CALLBACK):
					
					function filterTags($value)
					{ 
						return strip_tags($value); 
					}
					$str = "<html><h1>Заголовк</h1></html>";
					echo filter_var($str, FILTER_CALLBACK, ['options' => 'filterTags']); 

			*/

			/*  Фильтрация пользоватльского ввода 
					
					Принимает одну из констант (INPUT_GET,INPUT_POST...) 2 параметр - ключ в массиве, который нужно проверить
					mixed filter_input( 
											int $type,
											string $variable_name 
											[, int $filter = FILTER_DEFAULT
											[, mixed $options]]);
					
					массив defenition содержит ассоциативный массив, ключи которого соответсвуют названиям проверяемых переменных, а значения - фильтрам
					mixed filter_input_array(
										int $type
										[, mixed $definition
										[, bool $add_empty = true]]);

			*/

			/*
				 Поведение фильтров может быть настроено в файле php.in  в разделе [filter]
			*/



?>