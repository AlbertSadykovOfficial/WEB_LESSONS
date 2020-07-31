<!DOCTYPE html>
<html lang='ru'>
  <head>
  <title>Список пользователей</title>
  <meta charset='utf-8'>
  <link rel="stylesheet" href="list.css">
  <script type="text/javascript" src="../../jquery.js" ></script>
  <script type="text/javascript">
    // Назначить обработчики события click
    // после загрузки документа
    $(function(){
      $(".jumbotron > div > a").on("click", function(){
        // Формируем ссылку для AJAX-обращения
        var url = "user.php?id=" + $(this).data('id');
        // Отправляем AJAX-запрос и выводим результат
        $.ajax({
          url: encodeURI(url)
        }).done(function(data){
          $('#info').html(data).removeClass("hidden");
        });
      })
    });
  </script>
  </head>
  <body>
    <div id="list">
      <?php
        // Устанавливаем соединение с базой данных
        require_once("connect.php");

        $query = "SELECT * FROM users
                  ORDER BY name";
        $usr = $connection->query($query);

          echo "<div class='jumbotron'>";
          $x = $usr->num_rows;
          for ($i=1; $i <= $x; $i++)
          {
            $user = $usr->fetch_array(MYSQLI_ASSOC);
            echo "<div><a href='#' ".
                 "data-id='".$user['id']."'>".
                 htmlspecialchars($user['name'])."</a></div>";
          }
          echo "</div>";
      ?>
    </div>
    <div id='info' class='hidden'></div>
  </body>
</html>
