<?php
		
		// Любой текст, хоть из БД
		$text = "Cookies need love like everything does."; 

		// Адреса Получателей
		$tos = ["a@mail.ru", "albertsadykov@ro.ru"]; 

		// Считываем шаблон
		$tpl = file_get_contents("mail.eml"); 

		foreach ($tos as $to) 
		{ 
			$mail = $tpl; 
			$mail = strtr($mail, [
							"{TO}"		=> $to,
							"{TEXT}" 	=> $text
														]);
			// Разделим тело сообщени и заголовки
			list ($head, $body) = preg_split("/\r?\n\r?\n/s", $mail, 2); 

			// Отправляем почту 
			//(Плохой прием из-за передачи пустых header'ов(Обрабатывают не все почтовые программы))
			// появятся 2 пустых header'а в начале To и From, которые потом продублируются
			mail("","", $body, $head); 
		}
?>