<?php
			

			/*
					
					PHP-FPM - Fast CGI менеджер процессов, позволяющий обработать запросы
					на интерпретацию PHP-скиптов от nginx.
			
			*/

			/*	Установка
					
					$ sudo apt-get update
					$ sudo apt-get upgrade
					$ sudo apt-get install php7-fpm

				// Управление (как и у nginx):
					$ sudo service php7-fpm start
					$ sudo service php7-fpm stop
					$ sudo service php7-fpm restart
					$ sudo service php7-fpm reload  // пеечитать конфигурационные файлы 


				// Убедиться, что процессы запущены:
					$ ps aux | grep php7-fpm

			*/

			/*  Конфигурационные файлы:
					
					Обычное расположение:
					/etc/php7/cli/php.ini
					/etc/php7/apache2/php.ini (для Apache)
					/etc/php7/fpm/php 				(для FPM, используемый nginx)

					Уточнитьь местоположение можно, используя phpinfo()

					Установка глобальных настроек:
						/etc/php7/fpm/php-fpm.conf

						Пример (полный набор директив в документации):
							[global]
							pid = /var/run/php5-fpm.pid
							error_log = /var/log/php5-fpm.log
							emergency_restart_threshold = 0
							emergency_restart_interval = 0
							include = /etc/php5/fpm/pool.d/*.conf
						
						Директива include подключает пул PHP-FPM-процессов из папки pool.d
						В папке може храниться файл somename.conf, который будет обслуживать все сайты.
						Но можно и для каждого сайта форировать свой отдельный condf.
						Название пула как правило - доменое имя.

						Внутри кофнфигурацонного файла на этот пул(доменное имя) можно ссылаться, используя $pool
						Пример:
							[example.com]

							user = www-data
							group = www-data

							listen = /var/www/$pool/fastcgi.sock  // Задает способ обмена с другими серверами (через сокет)
							// Можно через IP и port 				: listen = 127.0.0.1:9000  (только для локальном хосте)
							// Если nginx на другом сервере : listen = 0.0.0.0:9000 или 9000

							listen.owner = www-data  // Владелец файла сокета
							listen.group = www-data
							
							// Праметры создания рабочих процессов.
							pm = dynamic
							pm.max_children = 5
							pm.start_servers = 2
							pm.min_spare_servers = 1
							pm.max_spare_servers = 3
							 
							security.limit_extensions = .php .php3 .php4 .php5
							 
							php_admin_value[sendmail_path] = /usr/sbin/sendmail -t -i -f admin@example.com
							php_admin_value[error_log] = /var/log/fpm-php/$pool.www.log
							php_admin_flag[log_errors] = on
							php_admin_value[memory_limit] = 32M

			*/

			/*  Подключение к nginx.
					
					В связи с тем, что у нас можт быть несколько пулов PHP-FPM, различным
					виртуальм хостам следует назначать разлчные пулы.

					Пусть поднято 2 пула с конфигами:
							pool.d/example.com.conf
							pool.d/example.net.conf

					Запуск PHP-FPM с этими файлами риведет к созданию 2х наборов процессов PHP-FPM.

					Один набор принимает запросы по сокету: /var/www/exarnple.com/fastcgi.sock
																			 другой по: /var/www/example.net/fastcgi.sock
					Проверка сокетов:
					$ ps aux | grep php-fpm 
					->обслуживаются 2 домена, что можо увидеть по процессам.

			*/
?>