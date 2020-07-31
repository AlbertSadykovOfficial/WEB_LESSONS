


		/*
			Методы обьекта XMLHttpRequest:
				abort() 								— отмена текущего запроса к серверу.
				getAllResponseHeaders() — получить все заголовки ответа от сервера.
				getResponseHeader(«имя_заголовка») — получить указаный заголовок.

				open(«тип_запроса»,«URL»,«асинхронный»,«имя_пользователя»,«пароль»)
						«имя_пользователя»,«пароль» обычно не исп, т.к это не безопасно

				send(«содержимое») — послать HTTP запрос на сервер и получить ответ.
				setRequestHeader(«имя_заголовка»,«значение») — установить значения заголовка запроса.


			Свойства объекта XMLHttpRequest:
				onreadystatechange 	- Задает обработчик, который изменяется при изменении статуса объекта.
				readyState 					- статус объекта.
				responseText 				- представление ответа сервера в виде обычного текста (строки).
				responseXML 				- объект документа, совместимый с DOM, полученного от сервера.
				status 							- состояние ответа от сервера.
				statusText 					- текстовое представление состояния ответа от сервера.


			Создание объекта:
			 Gecko-совместимые (Konqueror`е и Safari):
				let Request = new XMLHttpRequest(); 

			 Internet Explorer:	
				let Request = new ActiveXObject("Microsoft.XMLHTTP");
				или	
				let Request = new ActiveXObject("Msxml2.XMLHTTP"); 

			Пример создания запроса:

				function CreateRequest()
				{
				    var Request = false;

				    if (window.XMLHttpRequest)
				    {
				        //Gecko-совместимые браузеры, Safari, Konqueror
				        Request = new XMLHttpRequest();
				    }
				    else if (window.ActiveXObject)
				    {
				        //Internet explorer
				        try
				        {
				             Request = new ActiveXObject("Microsoft.XMLHTTP");
				        }    
				        catch (CatchException)
				        {
				             Request = new ActiveXObject("Msxml2.XMLHTTP");
				        }
				    }
				 
				    if (!Request)
				    {
				        alert("Невозможно создать XMLHttpRequest");
				    }
				    
				    return Request;
				} 
		*/

		/*  Запрос к серверу
					
					Алгоритм запроса к серверу выглядит так:
					  1) Проверка существования XMLHttpRequest.
					  2) Инициализация соединения с сервером.
					  3) Посылка запрса серверу.
					  4) Обработка полученных данных.
					
					(Смотри файлы sendRequest.js  и readFile.js)

					От сервера можно получить следующие данные:
						1) Обычный текст
						2) JSON
						3) XML
		*/