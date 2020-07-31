<?php // formtest.php  
 if (isset($_POST['name'])) 
 	$name = $_POST['name'];  
 else 
 	$name = "(Не введено)";

echo <<<_END
<html><head>        <title>Form Test</title>    </head>
    
<body> 
	Вас зовут: $name <br>
		<form method="POST" action="formtest.php">        
		Как Вас зовут? 
		<input type="text" name="name" value="(Введите значение)">   <!-- Значене по умолчанию -->      
		<input type="submit">    
		</form>    
</body>  
</html>  
_END;


		/* Типы элементов ввода данных

			Текстовое поле 
			<input type="text" name="имя" size="размер" maxlength="длина" value="значение"> 

			Текстовая область
			<textarea name="имя" cols="ширина" rows="высота" wrap="тип"> </textarea>
			Тип 		Описание
			off 	| Текст не переносится, и строки появляются в строгом соответствии с тем, как их вводит пользователь 
			soft 	| Текст переносится, но отправляется на сервер одной длинной строкой без символов возврата каретки и перевода строки 
			hard 	| Текст переносится и отправляется на сервер в формате переноса с «мягким» возвратом в начало следующей строки и переводом строки
			
			Флажки
			<input type="checkbox" name="имя" value="значение" checked="checked"> 
			 
			 Отправка нескольких значений с помощью массива  
			 Ванильное <input type="checkbox" name="ice[]" value="Vanilla"> 
			 Шоколадное <input type="checkbox" name="ice[]" value="Chocolate"> 
			 Земляничное <input type="checkbox" name="ice[]" value="Strawberry">

			 $ice = $_POST['ice']; // $ice[0] => Ванильное $ice[1] => Шоколадное $ice[2] => Землянично
		
			Переключател
			 8.00-12.00<input type="radio" name="time" value="1"> 
			 12.00-16.00<input type="radio" name="time" value="2" checked="checked"> 
			 16.00-20.00<input type="radio" name="time" value="3">
			
			Скрытые поля 
				echo '<input type="hidden" name="submitted" value="yes">' 
			// Допустим строка введена пользователем, тогда при первом запуске php 
				submitted не будет находиться в массиве POST
			
			Списки <select>
			<select name="имя" size="размер" multiple="multiple"> 
			// Можно убрать size и multiple
			Овощи 
			<select name="veg" size="5" multiple="multiple"> 
					<option value="Горох">Горох</option> 
					<option selected="selected" value="Фасоль">Фасоль</option> 
					<option value="Морковь">Морковь</option> 
					<option value="Капуста">Капуста</option> 
					<option value="Брокколи">Брокколи</option> 
			</select> 

			Теги label
			 В эти теги можно заключить элемент формы, обеспечивая его выбор щелчком на любой видимой части, содержащейся между открывающим и закрывающим тегами <label>. 
			 <label>8.00-12.00<input type="radio" name="time" value="1"></label>

			Кнопка отправки 
			<input type="submit" value="Поиск"> 
			<input type="image" name="submit" src="image.gif"> // Кнопка- картинка
*/

/*	Атрибут autocomplete
 	 При включении атрибута autocomplete заново вызываются ранее введенные пользователем данные
 	<form>,
  <input>: color, date, email, password, range, search, tel, text или url. 

  <form action='converter_example.php' method='post' autocomplete='on'>  
  <input type='text' name='username'>  
  <input type='password' name='password' autocomplete='off'> 
  </form>


		Атрибут autofocus 
		Установке фокуса на элемент при загрузке страницы. 
		<input>, <textarea> или <button>, 
		например: <input type='text' name='query' autofocus='autofocus'>
	
	Атрибут placeholder 
	Помещает в пустое поле ввода подсказку: 
	<input type='text' name='name' size='50' placeholder='Имя и фамилия'>

	Атрибут required 
	Предназначен для обеспечения обязательного заполнения поля перед отправкой формы: 
	<input type='text' name='creditcard' required='required'> 

	Атрибуты подмен
	<form action='url1.php' method='post'> 				// Исходный адресс
	<input type='text' name='field'> 
	<input type='submit' formaction='url2.php'> 	// Адресс подмены
	</form> 

	Атрибут form 
	В HTML5 элементы <input> уже не нужно помещать в элементы <form>, 
	поскольку форму, к которой применяется элемент ввода, можно указать, 
	предоставив этому элементу атрибут form. 

	<form action='myscript.php' method='post' id='form1'> </form>
	<input type='text' name='username' form='form1'>

	Атрибут list

		Выберите нужный сайт: 
		<input type='url' name='site' list='links'>

		<datalist id='links'>  
			<option label='Google' value='http://google.com'>  
			<option label='Yahoo!' value='http://yahoo.com'>  
			<option label='Bing' value='http://bing.com'>  
			<option label='Ask' value='http://ask.com'> 
		</datalist> 
	
		Атрибуты Step, min и max

		<input type='time' name='alarm' value='07:00' min='05:00' max='09:00'> 
		<input type='time' name='meeting' value='12:00'  min='09:00' max='16:00' step='3600'> 1 sec

		Тип ввода color
		Выберите цвет <input type='color' name='color'>

		Типы ввода number и range
		<input type='number' name='age'> 
		<input type='range' name='num' min='0' max='100' value='50' step='1'>

		Окно выбора даты и времени 
		При выборе типа ввода date, month, week, time, datetime или datetimelocal 
		<input type='time' name='time' value='12:34'>


	
*/

?>

