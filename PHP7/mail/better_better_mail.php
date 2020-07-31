<?php

	include_once "lib/mailx.php";
	include_once "lib/mailenc.php";
	include_once "lib/template.php";

	$text = "Well, now, ain't t his a surprise?";
	$tos = ["Пупкин Василий <poupkinne@mail.ru>, Садыков <albertsadykov@ro.ru>"]; 

	$tpl = file_get_contents("mail.eml"); 

	foreach ($tos as $to) 
	{ 
		// Разворачиваем шаблон
		$mail = template("mail.php.eml", [
						"{TO}"		=> $to,
						"{TEXT}" 	=> $text
													]);
		$mail = mailenc($mail);
		mailx($mail); 
	}
?>