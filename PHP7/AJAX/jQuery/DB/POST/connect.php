<?php ## Соединение с базой данных
  $dbhost = 'localhost';
  $dbname = 'test'; // Должна быть создана
  $dbuser = 'root';
  $dbpass = '';



  $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  if ($connection->connect_error) die($connection->connect_error);
?>