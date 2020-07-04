<?php 

	$page_title = 'PHP-форум';
	// Чтобы стили заработали, пришлось поправить header док, может стили не будут работать в других примерах из-за этого, нуно игрться с папками
	include('../web/grouping/header.html');

	require('connect_db.php');

	$sql = 'SELECT * FROM forum';
	$result = mysqli_query($dbc, $sql);

	if (mysqli_num_rows($result) > 0) 
	{ // Таблица со списком всех собщений
			echo '<table><tr><th>Автор</th><th>Тема</th><th id="msg">Сообщение</th></tr>';
			
			while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
			 {
				echo '<tr><td>'.
				$row['first_name'].' '.
				$row['last_name'].'<br>'.
				$row['post_date'].'</td><td>'.
				$row['subject'].'</td><td>'.
				$row['message'].'</td><td>';
				}
				echo '</table>';
		
	}else{
		echo '<p>В настоящее время сообщений нет.</p>';
	}

	echo '<p><a href="post.php">Написать сообщение</a></p>';
	mysqli_close($dbc);
	include('../web/grouping/footer.html');
