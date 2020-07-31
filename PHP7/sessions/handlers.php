<?php
				// ПЕРЕОПРЕДЕЛЕНИЕ ОБРАБОТЧИКОВ

			
			// Вернет полное имя файла временного хранилища сессии
			// Если нуно изменить каталог хранения сессий - то менять тут
			function ses_fname($key)
			{
				return dirname(__FILE__)."/sessiondata/".session_name()."/$key"; 
			}


			// Фунции - заглушки
			function ses_open()
			{
				return true;
			}
			function ses_close()
			{
				return true;
			}

			function ses_read($key)
			{
				// Получаем имя файла и открываем файл
				$fname = ses_fname($key);
				return @file_get_contents($fname); 
			}

			// Запись данных сессии во временное хранилище
			function ses_read($key)
			{	
				$fname = ses_fname($key);
				return @file_get_contents($fname);
			}

			function ses_write($key)
			{
				$fname = ses_fname($key);

				// Создаем каталоги (при наличии - игнорируем ошибки)
				@mkdir(dirname(dirname($fname)), 0777);
				@mkdir(dirname($fname), 0777);  

				// Создаем файл и записывае в него данные сессии
				@file_put_contents($fname, $val);
				return true;
			}

			function ses_destroy($key)
			{
				return @unlink(ses_fname($key)); 
			}

			// Сборка мусора

			function ses_gc($maxlifetime) 
			{
				$dir = ses_fname(".");

				// Доступ к каталогу текущей группы
					foreach (glob("$dir/*") as $fname) 
					{
						// Файл слишком стрый?
						if (time() - filemtime($fname) >= $maxlifetime)
						{
							@unlink ($fname); 
							continue;
						}
					}

					//  Если каталог не пуст, он не удалится- будет предупреждение
					// Подавляем его, иначе просто все удаляется
					@rmdir($dir);
					return true; 
			}

			session_set_save_handler(
								"ses_open", "ses_close",  
								"ses_read", "ses_write", 
								"ses_destroy", "ses_gc" 
							);

			//Для примера подклчаемя к группе сессий
			session_name("test1");
			session_start(); 

			// Уыеличим счетчик
			$_SESSION['count'] = @$_SESSION['count'] + 1; 
?>

				<h2>Счетчик</h2>
				Вы открываали страницу:
				<?=$_SESSION['count']?> раз(а).<br /> 
				Закройте Браузер, чтобы сбросить сессию
				<a href="<?=$_SERVER['SCRIPT_NAME']?>" target="_blank">Открыть дочернее окно Брузера</a>
