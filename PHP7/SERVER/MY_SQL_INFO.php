<?php
		
		/*  
				В именах БД и таблиц допускается испоьзование  символов _ и %,
				при обращени к таким таблицам, такие символы слеуте экранировать:
				GRANT ALL ON 'list\_user' .*TO 'wet'@'localhost'; 


		*/

		/*  Администрирование MySQL.


				Установка (UNIX):
				$ sudo apt-get update
				$ sudo apt-get upgrade
				$ sudo apt-get install mysql-server

				Постинсталяционная настройка:
				$ sudo mysql_secure_installation
					Будет предложено:
					1) Изменить Пароль: Y/(N)
					2) Удалить Анонимного пользователя без пароля: (Y)/N
					3) Запретить удаленное обращение от имени root: (Y)/N
					4) Удалить БД test: (Y)/N
					5) Перезагрузть привелегии: (Y)/N

		*/

		/*  Управление

				// Управление (как и у nginx):
					$ sudo service mysql start
					$ sudo service mysql stop
					$ sudo service mysql restart
					$ sudo service mysql reload  // пеечитать конфигурационные файлы

				// Убедиться, что MySQL сервер запущен:
					$ ps aux | grep mysqld

		*/

		/*  Конфигурационный файл

				Путь: /etc/mysql/my.cnf

				формат файла - ini, что означает то, что комментарий начинается с: # или ;

				Один конфигурационный файл может быть предназначен для некольких сереров,
				поэтому файл делят на секции:
					[mysqld]  			- Сервер MySQL
					[server]				- Сервер MySQL
					[mysqld-5.6]		- Сервер MySQL 5.6
					[mysqld_safe]   - Утилита запуска mysqld_safe
					[client]        - Любая клиентская утилита, обащающаяся к серверу.
					[mysql]         - Консольный клент mysql
					[mysqldump]     - Утилита созданя дампов
					[mysqlhotcopy]  - Утилита 'горячего' копирования бинарных файлов БД.

				Наличие секции mysqld, а так же секций для отдельных версий обусловлено тем, что
				с каждой новой версией появляется все бльше и больше параметров запуска и конф файл 
				управляет несколькими серверами.

				Пример, файл : my.cnf
				(P.S. Оставлять значени конфига по умолчанию крайне не рекомендуется)
				Обьемы БД разные, не эффективно тратить много оперативной памяти под малые БД.
				Сервер без спроса память не берет, поэтому разраотчики не могут выставить все эффективно.

				MySQL поддерживает несколько типв движков:
				MyISAM - быстрый движок, не поддерживающий транзакции, эффективен на чтение,
								не эффективен на запись, т.к для записи блокируеся вся таблица. (эффективен на небольших обьемах данных)

				InnoDB - движок, поддерживающий транзакции, обеспечиающий посрочную блокировку,
								за счет чего эффективен на запись (рекомендуется,т.к выигрывает на больших обьемах данных)
				Директива default-storage-engine 

		*/

		/*  Выделение памяти

				Данные таблицы можно разделить на две группы:
					1) Данные таблицы
					2) Индексы (копии столбца, соддержимое которых поддреживается в отсортированном состоянии)
											благодря чему поиск осуществляестя быстрее

						Организация индексов представлена в виде бинарного дерева, при чем, че правее положение,
						том меньше число. (Рисунок в паке - ОРГАНИЗАЦИЯ ИНДЕКСА)
						Чтобы еще больше увеличить скорость, их стараются хранить в оперативной памяти. 
				
				MyISAM И InnoDB по разному кэшируют индексы и данные.

				MyISAM хранит индексы и данные раздельно
				InnoDB хранит индексы и данные в едином абличном пространстве

		//--MyISAM
				В MyISM индексы и данные хранятся отдельно в 2х разных файлах, при этом кэшированию
				подвергаются только индексы. Данные таблицы Кэшируется ОС, поэтому важно, чтобы была 
				дотсупна свободная опертивная память. Обьем паяти под кэш индексов определяет дире-
				ктива key_buffer. Под кэш следует выделять 25-50% оперативно памяти, однако больше 
				4ГБ все равн не получить(даже если система 64-bit).

				Оценка эффективности кэша:
				mysql> STATUS LIKE 'Key%';
					Состав:
					 Key_blocks_used   - кол-во занятых в блоке Ключей
					 Key_blocks_unused - кол-во свбодных ключей 
					 										 (если она долго неизменна и выше 0, то величину key_buffer можно уменьшать)
					 Key_write_requests- кол-во записей в кэш
					 Key_writes        - В обход кэша
					 Key_read_requests - кол-во считываний из кэш
					 Key_reads         - В обход кэша
					
					 Если Key_read_requests и Key_write_requests различаются на 3-4 порядка, то кэш эффекивен.
					 Соотношение чтение кэша (Key_read_requests) и его обхода (Key_reads) должны отличаться на 2-3 порядка.
		
		//--InnoDB
				key_buffer только для MyISAM, т.к. InnoDB более старая и не использует своременные системы кэширования Linux,
				вместо этого используются собсвенные механизмы кэширования. Индексы и файлы хранятся вместе в едином табличном
				пространстве и кэшируются они так же вместе. Память, выделяемая под InnoDB определяется директивой 
				innodb_buffer_pool_size. Так как кэш идет в обход ОС, то моно исчерпывать пои всю Оперативную Память сервера.
				Под Кэш рекомендуется выделять 50-80% оперативной памяти сервера. 
				При этом не следует выделять такое кол-во памяти, которое превшает обьем БД сервера.

				Оценка эффективности:
				mysql> SHOW STATUS LIKE 'Innodb_buffer_pool_%';
					Состав:
					 Innodb_buffer_pool__pages_total   - Кол-во доступных блоков в кэше,которые состоят из:
					 Innodb_buffer_pool_pages_data     - занятые
					 Innodb_buffer_pool_pages_free     - свободные
					 Innodb_buffer_pool_write_requests - кол-во записей в кэш
					 Innodb_buffer_pool_read_requests  - кол-во считываний из кэш
					 Innodb buffer_pool_reads          - В обход кэша

				Т.к InnoDB самостоятельно кэширут и индексы и файлы, то нет необходимости в повторном кэшировании от ОС.
				Для отключения двойного кэширования в секецию mysqld конфига следуте прописать:
				innodb_flush_method=O_DIRECT 

		*/

		/*

				Кэш запросов - объем опреативной памяти, выделенной для запросов и их результирующих таблиц.
											 Кэширования подвергаютсятольео SELECT-запросы.

				В конф.файле кэш=запросов включается директивой query_cache_type со значениями:
					OFF/ON
					DEMAND - кэшируются только те запросы, у которых укзаан модификатор SQL_CACHE:
					
				// Подвергнуть кэшированию
					SELECT SQL_CACHE * FROM catalog WHERE id = 5; 
				
				// Не подвергнать кэшированию
					SELECT SQL_NO_CACHE * FROM users; 

					Директивы управления параметрами кэша:
					query_cache_size  - Общий обьем оперативной памяти, выделенный под кэш
					query_cache_limit - Максимальный размер результирующей таблицы, которая сохранится в кэш.


					mysql> SHOW STATUS LIKE 'Qcache%'
						Состав:
						 Qcache_free_blocks - кол-во свобоных блоков в кэше
						 ...
						 ... 
					
					Отношение Qcache_hits к общему кол-ву всатвок в кэше Qcache_inserts позволяет оценить эффективность.
					Высококе и постоянно увеличивающееся значение Qcache_lowmem_prunes говорит о том, что механизм 
					не смог разместить результаты запроса по причине не хватки памяти и освободил место, удалив пред.резлт.
					
					Память потребления MySQL складывается из памяти ядра и памяти, выделяемой каждому соединению.
					Память ядра складываетя из кэшей Qcahce и допольнительных:
						innodb_additional_mem_size - внутренние данные InnoDB
						innodb_log_buffer_size     - кэш журнала транзакции

					core =  query_cache_size + key_buffer + innodb_buffer_pool_size 

					Каждое соединения может здаействовать доп память для выполнения запросов. 
					Набор директив, которые влияют на выделение памяти кадому соединению:
						read_buffer_size     - кэш под полные сканы таблиц
						read_rnd_buffer_size - кэш сортирвки с участием индексов
						sort_buffer_size     - кэш сортироки данных
						thread_stack         - кэш потоков
						join_buffer_size     - кэш JOIN соединений с участием индексов

					Директива max_connection ограничивает максимвльное кол-во соединений.

					Посмотреть структуру потребления Оперативной памяти можно на картинке (ПОТРЕБЛЕНИЕ ПАМЯТИ MYSQL) 

		*/

		/*	ПОЛЬЗОВАТЕЛЬЬСКИЙ КОНФИГ

				Каждый пользователь может завести свой собственный конфигурационный файл:
					[client]
					user               = dev
					password           = password
					max_allowed_packet = 16MB

				Далее следует установить на файлправа доступа, не позволяющие вносить
				другим пользователям изменения:
				$	chmod 0600 .my.cnf
		
		*/

		/*  Создание/Удлние пользователя

				Сидеть под root может быть опасно, еть возможность накосячит,
				поэтому следует сидеть всем под пользоваелями:

				CREATE USER ' username'@'localhost' IDENTIFIED BY 'password';

				Новому пользователю назначаются минимальные права, их можно потом повысить.

				Удалить польователя:
				DROP USER 

		*/

		/*  Удаленный доступ к MySQL

				Учетная запись составная и имеет вид: 
					'username'@'host'
					,где host - имя хоста с которого пользователю разрешено обращаться к MySQL 

				Если имя и хост не содержат спец символов, то можно обращаться и так:
					username@host

				Пользователю может быть разрешено обращение не тольок с одного хоста, поэтому
				существует спопосб задавать диапазоны значений с помошью %:

					 Доступ пользователя wet со всех доменов:
					  wet@'%' или просто wet
					 С доменов, имеющих поддомен .sample.ru
					 	wet@'%.sample.ru'
					 С доменов, которые начинаются с 2.28.:
					 	wet@'2.28.%'

		*/
		
		/*  Привелегии

				GRANT - назначить привелегии пользователю
				REVOKE- удалить привелегии пользователя

				Если учетная запись в операторе GRANT не существует, то она создается:
				Дать права для всех Баз Данных (*.*)
				GRANT ALL ON *.* TO 'wet'@'localhost' IDENTIFIED BY 'pass'; 

				В случае отстутствия (IDENTIFIED BY) Пароль - пустая строка

				ALL дает все привелегии, можно назначиь и конкретные (читай в документации)
				Также слово ALL не используется совместно с другими клчевыми словами.
				
				// Включить все привелегии стразу:
					GRANT ALL ON *.* TO superuser;
					GRANT GRANT OPTION ON *.* TO superuser; 

				// Разрешить пользователю editor доступ на просмотр, заполнение, реактирование и удаление
					GRANT SELECT, INSERT, DELETE, UPDATE ON*.* TO editor;

				// Если в качетве пользователья приложение, только которое удаляет и изменет записи:
					GRANT INSERT, UPDATE ON *.* TO program; 
				

				Ключевое слово ON задает уровень привелегий:
					ON *.*    - Глобальный уровень
					ON *      - Если текущая БД не выбрана, то * === *.
					ON db.*   - Уровень БД
					ON db.tbl - Уровень таблицы
					ON db.tbl ( SELECT, INSERT, UPDATE ) - Уровень столбца, список указывается через запятую
					
					Пример (Усановить привелегии на уровне БД):
					GRANT ALL ON test. * TO editor

					Наделить всеми привелегиями для дотупа к таблице:
					GRANT ALL ON test .user TO manager;

				SHOW DATABASES и SUPER могут быть установлены лишь на глобальном уровне
				Если у пользователья нет привленгий на БД, то она не отобразится в SHOW DATABASES


				GRANT OPTIONS - спосбность наделять других пользователей правами на передачу пользовательских прав.
												Обычно эту опцию специально выносят в отдельный запрос:  WITH GRANT OPTION:
												// wet наделяется правами вызова опертора GRANT ALL для предоставления привелегий
												// другим пользователям на БД test и ее таблицы.
												GRANT ALL ON test.* TO 'wet'@'localhost' WITH GRANT OPTION; 
					! Пользователь, имещий GRANT OPTION способен наделять других теми правами, которыми обладает сам.
					При чем действует GRANT OPTION как ссылка, т.е если права wet повысятся, то и права тех, кому wet
					дал свои права тое повысятся.

				REVOKE - отмена привелегий.
					Синтаксис схож с GRANT, но (TO) меняется на (FROM):
					REVOKE DELETE, UPDATE ON shop.* FROM 'wet'@'localhost'; 

		*/

		/* Восстановление пароля
				
				Если утерян парольобчычного пользователя, то восстановить его можно через root:
				SET PASSWORD FOR user= PASSWORD('password') 

				Если утерян пароль root, необходимо в my.cnf в секцию mysql добавить директиву:
				 skip-grant-tables 

				В этом режиме sql игнорирует все привелегии и все БД доступны без привелегий.
				Поэтому операцию SET PASSWORD можно использовать любому пользователю на любого пользователя.

				По завершении всех работ, следует перезагрузить MySQL, убрав skip-grant-tables.

		*/

		/*  Перенос БД с одного сервера на другой

				При переносе Данных следует блокировать Данные, чтобы при перенсе они не повредились 
				из-за изменения от чьего-то лица.

				FLUSH TABLES WITH READ LOCK; 
				
				Для того, чтобы блокировка оставалась действительной, следует не выходить из под 
				пользователя и ждать, пока копирование не завершится.Затем можно снять блокировку:
				UNLOCK TABLES;

				В дистрибутиве mysql для всех тих дйствий есть специальный скрипт (mysqlhotcopy):
				// Копируем таблицу base в новое место 
				$ mysqlhotcopy base /to/new/path 

				!!! mysqlhotcopy работает лишь с MyISAM
		
		*/

		/* Создание SQL-дампа

			Дамп - текстовый файл с инструкцияи восстановления

			Утилита восстановления mysqldump
				
				Создать резервнуб копию БД:
				$ mysqldump base > base.sql
				(Данные отправляются в выходной поток браузера, для их перехвата служит (>))
				Для того, чтобы не перезаписывать sql файл, а дописывать данные в конец исп (>>):
				$ mysqldump base >> base.sql

				Создать Дамп Несколькиз БД (-B или  --databases):
				$ mysqldump -B base mysql > base_mysql.sql 

				Сохранения Дампа всех БД (-A или --all-databases)
				$ mysqldump --all-databases > all_clatabases.sql 


				Развернуть Дамп в пакетном режиме:
				$ mysql test < base.sql 
				Развернуть Дамп в диалоговом режиме:
				mysql > SOURCE base.sql; 

		*/

?