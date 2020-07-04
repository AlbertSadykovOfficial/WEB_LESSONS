<?php 

	$page_title = 'PHP - ошибки';

	include('../web/grouping/header.html');

	function fail($str)
	{
		echo "<p>Пожалуйста, укажите $str.</p>";
		echo '<p><a href="post.php">Написать сообщение</a></p>';
		include('../web/grouping/footer.html');
		exit();
	}

// addslashes(); Экранирует апострофы и кавычки

	if(isset($_POST['message']))
	{
		if (!empty(trim($_POST['first_name']))) 
		{$first_name = addslashes($_POST['first_name']);}
		else{fail('Имя');}

		if (!empty(trim($_POST['last_name']))) 
		{$last_name = addslashes($_POST['last_name']);}
		else{fail('Фамилию');}	

		if (!empty(trim($_POST['subject']))) 
		{$subject = addslashes($_POST['subject']);}
		else{fail('Тему');}

		if (!empty(trim($_POST['message']))) 
		{$message = addslashes($_POST['message']);}
		else{fail('текст сообщения');}
	}

	require('connect_db.php');

	$sql = "INSERT INTO forum
	(first_name, last_name, subject, message, post_date) 
	VALUES
	('$first_name', '$last_name', '$subject', '$message', NOW()) ";

	$result = mysqli_query ($dbc, $sql);

	if (mysqli_affected_rows($dbc)!=1) 
	{
		echo '<p>Ошибка</p>'.mysqli_error($dbc);
		mysqli_close($dbc);
	}else
	{
		mysqli_close($dbc);
		header('Location: forum.php');

	}
//	include('../web/grouping/footer.html');