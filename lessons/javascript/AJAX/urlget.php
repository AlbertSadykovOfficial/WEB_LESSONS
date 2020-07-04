<?php 
// Если не работает, то раскомментируй в php.ini :
//	extension=php_openssl.dll
		 if (isset($_GET['url'])) 
		 	{    
		 		echo file_get_contents("http://".SanitizeString($_GET['url']));  // Ф-ция загрузки файла или вэб-страницы
		 	}
  	
  	function SanitizeString($var)  
  	{    
  		$var = strip_tags($var);    
  		$var = htmlentities($var);    
  		
  		return stripslashes($var);  
  	} 

 ?>