<?php
			function mailx($mail)
			{
				// Разделим тело сообщени и заголовки
				list ($head, $body) = preg_split("/\r?\n\r?\n/s", $mail, 2); 

				//  Выделяем Заголовок To
				$to = "";
				if (preg_match('/^To:\s*([^\r\n]*)[\r\n]*/m', $head, $p)) 
				{
					$to 	= @$p[1]; // Сохраним
					$head = str_replace($p[0], "", $head); // Удалим из исходной строки
				} 

				//  Выделяем Заголовок Subject
				$subject = "";
				if (preg_match('/^Subject:\s*([^\r\n]*)[\r\n]*/m', $head, $p)) 
				{
					$to 	= @$p[1]; // Сохраним
					$head = str_replace($p[0], "", $head); // Удалим из исходной строки
				} 

				// Отправим почту
				mail($to, $subject, $body, trim($head)); 
				echo "$to $subject $body $head";
			}
?>