<?php

	include_once "lib/mailx.php";
	include_once "lib/mailenc.php";

	$text = "Well, now, ain't t his a surprise?";
	$tos = ["Пупкин Василий <poupkinne@mail.ru>, Садыков <albertsadykov@ro.ru>"]; 

	$tpl = file_get_contents("mail.eml"); 

	foreach ($tos as $to) 
	{ 
		$mail = $tpl; 
		$mail = strtr($mail, [
						"{TO}"		=> $to,
						"{TEXT}" 	=> $text
													]);
		$mail = mailenc($mail);
		mailx($mail); 
	}
?>