<?php
			
			function mailenc($mail)
			{

				// Разделим тело сообщени и заголовки
				list ($head, $body) = preg_split("/\r?\n\r?\n/s", $mail, 2);

				//  Определяем кодировку по заголовку
				$encoding = "";
				$re =  '/^Content-type:\s*\S+\s*;\s*charset\s*=\s*(\S+)/mi';
				if (preg_match($re, $head, $p)) $encoding= $p[1]; 

				foreach (preg_split('/\r?\n/s', $head) as $line) 
				{
					$newhead = ""; 
					if (preg_match('/^To:\s*([^\r\n]*)[\r\n]*/m', $head, $p)) 
					{
						//Кодируем заголовок
						$line			= mailenc_header($line, $encoding); 
						$newhead .= "$line\r\n"; 
					} 
				}
				return "$newhead\r\n$body"; 
			}

			//Коируем в строке максимально остпное число символов
			// начинающуюся с недопустимого символа и НЕ
			// Включающую Email(адреса обрамляются < >)
			// Если в строке нет ни одного недопустимого символа преобразования не произойдет

			function mailenc_header($header, $encoding = 'UTF-8')
			{
				return preg_replace_callback(
							'/([\x7F-\xFF][^<>\r\n]*)/s',
							function ($p) use($encoding){
								// Пробелы в конце не кодируем
								preg_match('/^(.*?)(\s*)$/s', $p[1], $sp);
								return "=?$encoding?B?".base64_encode($sp[1])."?=".$sp[2];  
							},
							$header);
			}
?>