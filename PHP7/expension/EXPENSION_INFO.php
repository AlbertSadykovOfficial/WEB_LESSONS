<?php

			/*
					Расширение - библитека, содержащия контанты, функции и классы для расширения базовых возможностей.

					Расширения пишутся на C.

					Язык имеет модульную архитектуру, что позволяет разрабатвать расширения разным командам и дает возможность
					создавать свои.

					Иерархия расширений:
					1) Входящие в ядро 
					2) Динамические библиотеки (не входят в ядро - редко исп). При нужде можно подключить.
							Компилируются в виде внешних библиотект (.dll, .so) 
							Для поключения -> php.ini -> extension dir = "ext" (ext-путь к папке с расширениями)
							Обычно в php.ini все уже есть и можно просто раскомментировать нуное extension=php_mbstring.dll 
					3) Из PECL-репозитория (расширения, которые устарели). Загружаются инивидуально.
					
					Установка расширений:
					1) В win: поместить в C:\Windows\system32
					2) Unix: $ brew install php70-curl (MAC). $ sudo apt-get install php7-curl (LINUX)

					Узнать библиотеки можно скачав tar.gz архив (в ext папке есть много подпапок с C-расширением)
						http://php.net/downloads.php 
					
					Узнать список доступных расширений:
					1) php -m
					2) phpinfo() (Configuration)
					3) --with-ext (ext - название расширения)
			*/

			/*		php.ini
					
					Сотоит из :
					секций 	: [DATE]
					директив: directive = value

					PHP ищет файл в:
					1)  По пути в переменной окружения  PHPRC
					2)	В текущем каталоге (если скрипт выполняется под управдением сервера)
					3)	 C:\Windows\ ||| Linux: (/etc/ или /etc/php7/) |||  Max: /usr/local/etc/php7.0

					Если php файл запускается вне сервера, указать путь можно так:
					1) php -c C:\php\php.ini C:\scripts\file.php 
					2) php -S 127.0.0.1:80 -c C:\php\php.ini 
			
			*/

			/*	Параметры языка PHP
					
			//-- Директивы управления параметрами
					
					engine 	         - (On/Off) Вкл/выкл выполнения php скриптов (On по умолчанию)
					precision        - Кол-во знаков отводящееся под дробное число, если вывод не форматируется с исп printf()
					output_buffering - (On/Off/число байтов) Вкл/выкл/сброс буфферизации вывода 
					short_open_tag   - (On/Off) исп коротких тэгов <? ?> (по умолчанию off)

					output_buffering (если, к примеру, текст превысит размер буфера, то будет ошибка)

			//-- Директивы ограничения ресурсов

					max_execution_time	- (Макс кол-во времени, отводимое на выполнени скрипта при 0 - выполняется бессрочо) По умолч - 30 сек
					max_input_time			-	Макс кол-во отводимое на разбор GET и POST данных и файлов (По умолч 60 сек)
					memory_limit				-	Макс кол-во памяти, выделяемое под 1 экземпляр скрипта 
																(Ошибка о преышении ресурса памяти:  Allowed memory size of 134217728 bytes exhausted )
			
			//-- Директивы Управления загрузкой ресурсов
					file_uploads				- (On/Off) по HTTP загрузку файлов через file 
					upload_tmp_dir			- Каталог пременных файлов
					upload_max_filesize	- Максимальный размер загружаемого файла
					post_max_size				- Максимальный размер POST данных
			*/

			/*
					Набор бибиотек:

					 BC Math, GMP - Для работы с большими числами (превшающими 8 байт)
					 CURL         - Низкоуровневые сетевые операции
					 DBA, dBase   - Работа с плоскими файлами?
					 FTP 					- Доступ по протоколу ftp
					 GeoIP 				- Определение метоположения по IP-адресу
					 GD, Gmagick 	-	Работа с изображениями
					 iconv 				- Преобразование кодировок
					 IMAP 				-	Работа с почтовыми протоклами imap
					 LDAP 				-	Доступ к иерархическим базам данных
					 Libxml      	-	Поддержка работы с xml
					 SimpleXML    - Простая работа с XML
					 Mcrypt 			- Шифрование
					 PDF 					-	Расширение для создания PDF-файлов
					 PDO 					-	Для доступа к реляционным БД
					 SNM 					-	Поддержка протокола SNMP
					 V8js 				- Серверная интерпретация JS кода
					 Yaml  				-	Работа с Yaml файлами (Удобнее XML)
					 Rar,Zip,Zlib -	Сжатие данных
			*/

?>