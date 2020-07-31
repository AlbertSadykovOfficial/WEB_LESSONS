<?php
		
	// Функция Делает то же самое, что include,
	// но перехватывает вывод в бразер

		function template($_fname, $vars) 
		{
			// Перехватываем выхоной поток
			ob_start(); 
				// Запускаем файл как программу на PHP
				extract($vars, EXTR_OVERWRITE); 
				include($_fname);

			// Получаем перехваченный текст
			$text = ob_get_contents();  

			ob_end_clean(); 
			return $text;
		}

?>