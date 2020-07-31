<?php

			/*
					
					nginx - Web-север, который как и все современный Web-серверы обходит Apache
					в плане экономия ресурсов, разработан Игорем Сысоевым.

					Apache не спасает даже FastCGI.

					Главные достоинства: меньшее потребление памяти, отсутствие завязки намедленный
					жесткий диск, возможность большого количесва соединений, гибкие возможности настрйоки.
					Проектировался для поддеожания до 10 000 соединений.

					Для обслуживания PHP-скриптов совместно с nginx используется менеджер процессв FastCGI.


					(Далее подразумевается работа с Ubuntu)

					// Обновим пакеты установщиков:
						$ sudo apt-gat update 

					// Обновим систему (Рекомндуется)
						$ sudo apt-get upgrade

					// Установим nginx:
						$ sudo apt-get install nginx

					// Управление:
						$ sudo service nginx start
						$ sudo service nginx stop
						$ sudo service nginx restart
						$ sudo service nginx reload  // пеечитать конфигурационные файлы

					// Убедиться, что процессы запущены:
						$ ps aux | grep nginx
			*/

			/*  Конфигурационные файлы:

					Расположение: /etc/nginx
					
					Локальная секция помещается в скобки, Глобальная - нет
					<секция>{
						<директива> <значение>ж
					}

					Пример: файл nginx.conf
					include позволяет подключать дргие конфигурационные файлы.
						nginx.conf     - главный файл
						fastcgi_params - переменные окружения для FastCGI (требуестя для корректной работы PHP)
						mime.types     - mime типы поддерживаемые сервером
						sites-available- папка конфигурационных файлов для виртуальных хостов (Один сайт - один файл)
						sites-enabled  - ссылки на конфиги не из sites-available (подключаются все кнфиги, что указаны тут)

						Наиболее используемые директиы главного конфига:
							user 							- пользовватель и группа от имени которых запускаются процессы
							worker_processes  - кол-во рабочих процессов, обрабатывающих соединение со стороны клиента.
							pid 							- путь к файлу, к которому хранится иденификатор главного процесса nginx.
							worker_connection - максимальное количество соединений для рабочего процесса

							Пример:
							user USER GROUP
							
							Максимальное количесвто обрабатывемых соединений nginx:
							worker_processes * worker_connection


						Секция http определяет параметры HTTP-протокола (имеет много директив, читай документацию):
							Основноые:
								client_max_body_size - максимальный размер запроса клиента. При привышении (Err=403)
								default_type         - MIME тип по умолчанию, в случае, если сервер не может определить его сам
								keepalive_timeout    - Сколько времени соединение моетоставаться открытм (время в секундах)
								aio                  - разещшение использования всинхронного ввода/выввода файлов
								sendfile             - разрешение на использование sendfile для копир. из 1 файлового дискриптора в другой
								gzip                 - разрешение на сжатие ответа методом gzip (on/off)
								gzip_disable         - запрещает gzip сжатие для User-Agent, совпадающими с регуляр выражениями
								limit_rate           - ограничивает скорость передачи клиенту в байтах/сек. 0 - отлючит ограничение
								tcp_delay            - разр/запр исп параметра TCP_NODELAY для соед keep-alive
								tcp_nopush           - (учит при исп sendfile) разрешает отправлять заголовки HTTP одним ответом и передавать файл 									 полными
						
						Секция type, ранящая MIME-типы давольно большая, поэтому, обычно, выносится в отдельный файл.
			
			*/

			/*  Иерархия секций
					
					Файлы виртального хоста размещаются:  /etc/nginx/sites-available/
					Для активации в /etc/nginx/sites-enabled/, необзодимо создать ссылку (ln - s):
					$ sudo ln -s /etc/nginx/sites-available/example.com  /etc/nginx/sites-enabled/example.com 

					Когда серверу потсупает запрос, то ответ сначала собирается из более специализированных
					секций (location...), затем собирает более общие (server -> http)
					Так, location ответчает за папки и файлы, server за сайт, а http влияют на весь сервер.

					Один сервер может обслуживать несколько сайтов, поэтому клиенты отправляют заголовок 
					с доменнымименем сайта, чтобы сервер мог определить к кому идет обращение.
					Набор директив, обслуживащих такой отдельный сайт назваются ВИРТУАЛЬНЫМ ХОСТОМ.
					В nginx за это отвечает секция server, внутри который, при помощи директивы listen 
					указвается порт прослушки, а при помощи server_name - доменные имена, относящися к
					текущему виртуальному хосту:

						// С указанием IP-адресса
						server {
								listen 192.168.0.1:80;
								server_name example.com www.example.com;
						}
						// С  указанием порта и указанием инлексного файла.
						server {
								listen 80;
								server_name example.net www.example.net;
								index index.html; 
						}
						// Обработка любых доменов 3 уровня.
						server {
								listen 80;
								server_name example.net *.example.net;
						}
						// Использование регулярных выражений:
						server {
								listen 80;
								server_name	~^www\.example\.org$;
						} 

						// root опрееделяет Директиву виртуаьного зта на жеском диске:
						server {
								listen 80;
								server_name example.com www.example.com;
								root /var/lib/www/example.org/www;
						}

						// error_page - путь к файлу при опрделенном HTTP состоянии
						server {
								error_page 404 /404.html; 
								error_page 500 /500.html;
						}

			*/

			/* 	Журнальные файлы:

					Хранят информацию о неполадках.

					Наиболее используемыежурнальные файлы:
						error_log  - ошибки 														(только в глобальной секции)
						access_log - сообщения обращений к севреру
						log_format - содержит формат журнальных сайтов  (в server и location)

					Если error_log определена еще и в журналах хоста, то в error_log будут записываться ошибки уровня сервера.
					ОтСЮДА: Если виртуальный хост не стартует, ищи проблемы именно в  error_log.
						Второй параметр error_log позволяет задать уровень сообщений попадающих в журнал:
							 debug, info, notice, warn, error, crit, alert, emerg.

							 Пример:
							 error_log /path/to/log debug; 

					Директива access_log определяет имя файла для журнала обращений. (Одна строчка файла - одно обращение)
						access_log /var/www/self.edu.ru/log/backend.access.log; 
					
						Формат строки опрееляется директивой log_format
						log_format '$remote_addr|$time_local|$request|$status|$http_user_agent'; 
						Есть много параметров, о них можно прочитать в документации.
					
						Только на уровне http.
						Для изменения формата логов на уровне виртальных хостов, строку формировани можо передать в
						качестве второго параметра директивы:
						access_log /path/to/access.log '$time_local|$request|$status|$http_user_agent'; 
					
			*/

			/*  Местоположения

					Можно задавать поведение папок/файлов с опредеенными расширениями
					Синтаксис:
						location [mode] uri {...} 
						
						Модификаторы:
						=  - буквальное сравнение
						~  - сопоставление с рег выраж с учетом регистра
						~* - сопоставл с рег выраж без учета регистра
						^~ - - в случае первого нахождения поиск прекраается (по умолчанию ищет самый длинный)

					Подключить директивы: include/etc/nginx/templates/default

					Пример:

					// Закрыть доступ к файлам .htaccess и .htpassword
					location ~ /\.ht {
					 		deny all; 
					}
					
					//Не мпомещаем в журнальный файл обращения к favicon
					location = /favicon.ico { 
							log_not_found off; 
							access_log off;
					}

					// Не помещаем в журнальный файл обращения к robot.txt
					location = /robots.txt {
							allow all; 
							log_not_found off; 
							access_log off;
					}
					
					// Не помещаем в журнальный файл обращения к файлам
					// начинаюзимся с apple-touch
					location ~ /apple-touch- {
							log_not_found off; 
							access_log off
					}
					
				
					Именованные местоположения:

					server {
					  listen   80;
					  root /var/www/example.org/www;
					  access_log /var/www/example.org/log/access.log;
					  error_log  /var/www/example.org/log/error.log;
					  
					  server_name example.org www.example.org;

					  include /etc/nginx/templates/default;

					  location ~* \.php$ {
					    try_file $uri $uri/ @php;
					  }
					  location @php {
					    proxy_pass http://localhost:9000;
					    include fastcgi_params;
					    fastcgi_index index.php;
					  }
					}

					try_file 	ищет указанные в параметрах файлы. Если файл не найден по пути $uri,
										директива ищет папку $uri/,  
										если папка не найдена, то управление передается именнованому местоположению @php

					Если приложение в основном сотоит из php файлов, то исп местоположений может быть излишним
					Можно воспользоваться подкючением PHP-FPM через сокеты.
					Если PHP-FPM и nginx на одном сервере, то нет нужды занимать порты, лучше сделать бмен анными
					черз сокеты, например: /var/run/php5-fpm.sock

					server {
					  listen   80;
					  root /var/www/example.info/www;
					  access_log /var/www/example.info/log/access.log;
					  error_log  /var/www/example.info/log/error.log;
					  
					  server_name example.info www.example.info;

					  include /etc/nginx/templates/default;

					  location ~ \.php$ {
					    try_files $uri = 404;
					    fastcgi_pass   unix:/var/run/php5-fpm.sock;
					    fastcgi_index index.php;
					    include fastcgi_params;
					  }
					}
			*/

?>