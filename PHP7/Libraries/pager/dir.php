<?php #	 Постраничная навигация по папке

			// Автозагрузка классов:
			spl_autoload_register(function($class){
						require_once("src/{$class}.php");
			});
			// Папку в этом каталоге создай photos (т.к фото будет браться именно оттуда)
			$obj = new ISPager\DirPager(
									new ISPager\PagesList(),
									'photos',
									3,
									2);
			foreach($obj->getitems() as $img) 
			{
				echo "<img src='$img' /> "; 
			}

			// постраничная Навигация
			echo "<p>$obj<lp>"; 

?>