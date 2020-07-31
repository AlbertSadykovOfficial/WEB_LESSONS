<?php

		include_once "lib/mailx.php";

		// Любой текст, хоть из БД
		$text = "Cookies need love like everything does."; 

		// Адреса Получателей ,
		$tos = ["a@mail.ru","albertsadykov@ro.ru"]; 

		// Считываем шаблон
		$tpl = file_get_contents("mail.eml"); 

		foreach ($tos as $to) 
		{ 
			$mail = $tpl; 
			$mail = strtr($mail, [
							"{TO}"		=> $to,
							"{TEXT}" 	=> $text
														]);
		// Файл milx.php в lib
			mailx($mail);
		}
//echo "$mail";
?>