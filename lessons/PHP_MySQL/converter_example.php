<?php // convert.php  $f = $c = '';

  if (isset($_POST['f'])) 
  	$f = sanitizeString($_POST['f']);  

  if (isset($_POST['c'])) 
  	$c = sanitizeString($_POST['c']);

  if ($f != '')  
  {    
  	$c = intval((5 / 9) * ($f - 32));    
  	$out = "$f °f равно $c °c";  
  }  
  elseif($c != '')  
 	{    
 		$f = intval((9 / 5) * $c + 32);    
 		$out = "$c °c равно $f °f";  }  
 	else
 	 $out = "";

  echo <<<_END
  <html>    <head>       <title>Программа перевода температуры</title>    </head>    
  <body>    <pre>        
Введите температуру по Фаренгейту или по Цельсию  и нажмите кнопку Перевести <b>$out</b>
<form method="POST" action="converter_example.php">
По Фаренгейту	<input type="text" name="f" size="7">            
По цельсию	<input type="text" name="c" size="7">                      
<input type="submit" value="Перевести">       
	  </form>	</pre> 
  </body>  </html> 
_END;
 echo <<<_END
 <input type='text' name='name' size='50' placeholder='Имя и фамилия'>
 <input type='time' name='alarm' value='07:00' min='05:00' max='09:00'> 
 <input type='time' name='meeting' value='12:00'  min='09:00' max='16:00' step='3600'>
 Выберите цвет <input type='color' name='color'>
 	<input type='number' name='age'> 
		<input type='range' name='num' min='0' max='100' value='50' step='1'>
_END;
function sanitizeString($var)  
  {    
  	$var = stripslashes($var);          
  	$var = strip_tags($var);   
  	$var = htmlentities($var);    
  	return $var;  
  } 

