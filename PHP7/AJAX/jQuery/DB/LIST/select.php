<?php ## Формирование пунктов второго выпадающего списка
  // Устанавливаем соединение с базой данных
  require_once("connect.php");
  $id = $_GET['id'];
  $query = "SELECT * 
            FROM catalogs
            WHERE
              parent_id = $id AND
              is_active = 1
            ORDER BY pos";
  $cat = $connection->query($query);
  $cat_len = $cat->num_rows;
  echo "<option value='0'>Выберите подраздел</option>";
  for ($i=1; $i<=$cat_len; $i++)
  {
    $catalog = $cat->fetch_array(MYSQLI_ASSOC);
    echo "<option value='{$catalog['id']}'>{$catalog['name']}</option>";
  }