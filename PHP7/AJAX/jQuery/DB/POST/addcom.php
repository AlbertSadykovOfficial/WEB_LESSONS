<?php
  // Устанавливаем соединение с базой данных
  require_once("connect.php");

    // 1. Проверяем переданы ли POST-параметры, 
    // если ответ положительный, помещаем новое
    // сообщение в базу данных
    if(!empty($_POST))
    {
      $error = [];
      if(empty($_POST['nickname'])) {
        $error[] = "Отстуствует автор";
      }
      if(empty($_POST['content'])) {
        $error[] = "Отстуствует сообщение";
      }
      // Если нет ошибок, помещаем сообщение
      // в базу данных
      if(empty($error))
      {
        $nick = $_POST['nickname'];
        $content = $_POST['content'];
        $query = "INSERT INTO
                    comments
                  VALUES (
                    NULL,
                    '$nick',
                    '$content',
                    NOW(),
                    1)";
        $usr = $connection->query($query);
      }
    }
    // 2. Выводим сообщения в порядке убывания
    // даты из размещения
    $query = "SELECT * 
              FROM comments
              WHERE is_visible = 1
              ORDER BY created_at DESC";
    $com = $connection->query($query);
    $com_len = $com->num_rows;
    for ($i=1; $i<=$com_len; $i++)
    {
      $comments = $com->fetch_array(MYSQLI_ASSOC);
      // Обрабатываем сообщения перед выводом,
      // чтобы исключить вставку JavaScript-кода
      $comments['nickname'] = htmlspecialchars($comments['nickname']);
      $comments['content'] = nl2br(htmlspecialchars($comments['content']));
      // Выводим сообщение
      echo "<div>".
           "<span class='author'>{$comments['nickname']}</span>".
           "<span class='date'>{$comments['created_at']}</span>".
           "<span class='content'>{$comments['content']}</span>".
           "</div>";
    }