<?php

		/*
				memcached - сервер, располагающий данные в оперативной памяти в виде пар: ключ => значение

				Предаставляет собой NoSQL решение, хранящее данные в документах.
				Так же: MongoDB, Redis, HBase, Riak, CouchDB

				Для работы с memcached есть 2 решения:
				1) Memache
				2) Memcached

		*/
		/*
				Далее подразумевается работа в Ubuntu

				Установка:
				$ sudo apt-get install memcached 

				+ Пакет php
				$ sudo apt-get install php7-memcached 

				Параметры config
				 1)По умолчанию сервер исп порт 11211
				 	его можно изменить в /etc/memcached.conf (-p 11211)
				 2) logfile - путь к журнальному файлу
				 3) -m  - сколько оперативной памяти в мегабайтах может потреблять сервер
				 4) -1	- IP адрес или доменное имя сервера ( 0.0.0.0 - откроет сервер для внешних обращений)

		*/

		/* 	SESSION
				Сесии по умолчанию хранятся во временом каталоге на жестком диске.
				Имя файла совпадает с SID. 

				Постоянно читать и записывать в этот файл давольно длительно, поэтому их реализуют 
				через оперативныую память.

				В php.ini надо найти [Session] и установить параметры:
				session.save handler = 'memcached' 			//Меняем файловый обработчик с file(по умолчанию) на memcached
				session.save_path = 'localhost:11211'  // Задаем сетевой адрес memcached сервера
				или
				session.save_path = 'mem00.domain.com:11211, mem01.domain.com:11211' (для нескольких серверов)

				Обычно адрес memcached сервера совпадает с сервером приложения, но для больших проектов (не с 1 сервером)
				возможно будет лучше вынести его за пределы - в отдельный сервер, чтобы он обслуживал другие Web-сервера

		*/

		/* 	CONNECT
				
				Если параметр не указан, то обьект класса уничтожается сборщиком мусора
				Указание параметра позволяет создать пул соединений, которые не уничтожаются после завершния сценария
				Это экономит время на постоянно создаини/уничтожении соединений
					
					public Memcached::__construct([string $persistent_id]) 

				После Создания можно указать адрес Connect.
				Метод может быть вызван Многократно и задать множество серверов
				Параметр weight - задает весовой коэф сервера (Если у 1:10, а у 2:100, то ко 2 серверу будем обращаться в 10 раз чаще)
				public bool Mamcached::addServer(string $boat, int $port [,int $weight = 0]); // По одиночке
				public bool Mamcached::addServers(array $servers); // Массивом

				<?php
						$m = new Memcached();

						$m->addServers(
												['meml.domain.com', 11211, 10],
												['mem2.domain.com', 11211, 100]);
				?>
				

				Получить массив со списком серверв, назнаенных через addServe(r/rs)
				public array Mamcached::getServerList(void)
				
				Очистить амассив серверов
				public bool Memcachad::resetserverList(void) 
				
				Закрыть все открытые соединения
				public bool Memcachad::quit(void) 
		*/

		/* Работа с данными

				<?php # connect.php
					$m = new Memcached(); 
					$m->addServer('localhost', 11211); 
				?>
				
		//--Поместить параметр value под ключ key на время раыное expiration в секундах
				Если значение времени больше 30 дней (30*24*60*60), то она превращаетсяв UNIXSTAMP метку времени (отсчет с 01.01.1970)
				// true - значение добавлено, false - нет (если значение с таким ключом имееся сервер его проигнорирует и вернет false)
				
				public bool Mamcached::add(string $key, mixed $value [, int $expiration ]) 
				
				Пример:
					$m->add("key", "value");
					$m->get("key");

		//-- Поместить в начало/конец значения строку
				
				public bool Mamcached::prapend(string $key, string $value); // Начало 
				public bool Mamcached::append(string $key, string $value);	// Конец
				
				Пример:
				  $m->append("key", "123");
		*/


		/*	Оработка Ошибок
				
				// Текстовое сообщение последней ошибки
				public string Mamcached::getRasultMessage (void)

				Пример:
				if(!$m->add("key", "value")) echo $m->getResultMessage() ."<br />"; 
				if(!$m->add("key", "value")) echo $m->getResultMessage() ."<br />";  // NOT STORED (Не сохранено, т.к уе есть)

				// Кодовое сообщение последней ошибки

				public int Mamcached::getResultCode (void) 

				Пример:
				if (!($key= $m->get('key')){
					if($m->getResultCode() == Memcached::RES_NOTFOUND)
					{ // ... //}}
		*/

		/*	Замена данных
				
				// Подойдет для переустановки времени текущего значения или замены , или создания нового
				public bool Mamcached::set(string $key, mixed $value[, int $expiretions]); // 1 значение
				public bool Mamcached::setMulti(array $items [ , int $expiretions]) 			// Массив значений
				
				// Аналогичен set, но сли значения с таким ключом не существует, то ничего не сделает и вернет false
				public bool Mamcached::replace(string $key, mixed $value [, int $expiretions]) 
				
				Увеличить/уменьшить значение в ключе key на offset, 
				если ключ не существует, то содается со значением initial_value.
				Особенность: Необходимость включения бинарного протокола

				public int Mamcached::(in/de)crement(
																		string $key[,
																		int $offset = 1[,
																		int $initial_value = 0[,
																		int $expiry = 0 ]]]
																		);
				Пример:
				$m->setOption(Memcached::OPT_BINARY_PROTOCOL, true); // обраьная ф-ция getOption ()
				echo $m->increment("number", 1, 0); 
		*/

		/*	Извлечение данных:
				
				По ячейке:
				public mixed Memcached::get(string $key)

				public mixed Mamcached::getMulti(array $keys)

				Извлечение данных:

				// Вернет строку из результирующег набора, созданного getDelayed
				// Каждый последующий вызов возвраает слудующую строку, при ичерпании -  false. 

					public bool Mamcached::getDelayed(array $keys); // Захватить данные 
					public array Maacached::fetch(void);		// Извлеч очередную строку 
					public array Mamcached: :fetchAll(void) // Извлечь все полученные записи

				Пример:
					$m->getDelayed(array_keys($values)); 
					while ($result = $m->fetch()) {} 
		*/

		/*  Удаление Данных
				
				// time задаст время нахождения в секундах в очереди на удаление 
				// (чтобы сразу не могли создать то е значение при помощи add(), но при этом set() работать будет)
					
					public bool Mamcached::delete(string $key [, int $time = 0 ])
					public bool Mamcached::deleteMulti(array $keys [, int $time = 0 ]) 
		*/

		/* Установка Времени Жизни
				
				public bool Mamcached::touch(string $key, int $expiration) 
		
		*/

		/*	Работа с несколькими серверами
			
				<?php # Соединение с несколькими серверами
						$m= new Memcached();  
						$m->addServers([
										['localhost', 11211, 10], 
										['localhost', 11212, 10],]);
				?>

				Аналоги add и set 
				(Добавляется первый парметр - server_key)
				server_key может быть любой произвольнойс строкой, Memcached вычисляет ХЭШ строки
				и на основании него определяет куда кинуть данные, соответсвенно - один хэш - 
				в один сервер попадут данные
				
				public bool Mamcached::addByKey( 
															string $server_key, 
															string $key,
															mixed $value[, 
															int $expiretions]);

				
				// Определить на какой из серверов попадает значение с ключом $server_key
				// Результат - ассоциативный массив с параметрами сервера
					public array Mamcached::getServerByKey(string $sever_key)

					Пример:
					$server = $m->getServerByKey($key);
					$key => {$server[ 'host']}:{$server[ 'port']}


				Извлечь значение:
				public mixed Mamcached::getByKay(string $server_key, string $key);

				! Лучше создать ассоциативый массив сервер=>ключ для легкого и интуитивного извлечения

				Удалить:
				public bool Mamcached::daleteByKey(string $server_key, string $key [, int $time = 0 ]));
				public bool Mamcached::daleteMultiByKey(string $server_key, array $key [, int $time = 0 ]))
		*/
?>