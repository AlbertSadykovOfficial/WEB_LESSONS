<?php

			/*
					Размер Изображения:

					list getimagesize(string $filename)
						Параметры:
						 0 - Ширина
						 1 - Высота
						 2 - Формат изображения (1-GIF...)
						 3 - height=sx width=sy - для встраяивания в html
						 4 - Число битов, требуемое для хранения информации о кадом пикселе изображения
						 5 - Число цветовых каналов  (RBG - 3, CMYK - 4)
						 6 - MIME тип

			//--
					Библиотека 
						ImageMagic (php.ini: extansion-php_gd2.dll)
			//--

			//--Создать изображение:

					Пустое палитровое(с ограниченным набором цветов) изоюбражение
					resource imageCreate(int $x, int $y)
					
					Полноцветное изображение
					resource imagaCreateTrueColor(int $x, int $y) 

					проверка на тип
					bool imageisTrueColor(resouroe $im) 
		
			//--Загрузить изображение
					resource imagaCreateFromPng (string $filename) 
					resouroe imageCreateFromJpeg(string $filename) 
					resource imageCreateFromGif (string $filename)

			//-- Информация:
					int imageSX(int $im)
					int imageSY(int $im) 
			
			//--Сохранить изображение:
					Изоражение в процессе работы с ним конвертруется в общее, несжатое изображение,
					поэтому мы спокойно можем созхранять исходный png формат в gif или jpeg
					int imagePng(resouroe $i.m [, strinq $filename] [,int $quality])
					int imagaJpeg(resouroe $i.m [,string $filename] [,int $quality]) 
					int imageGif (resource $i.m [ , strinq $filename] )

			//-- О цветах:
					Цвет RGB надо преобразовывать в 16 формат и обратно
					$txtcolor = "FFFFOO"; 
					sscanf($txtcolor, "%2x%2x%2x", $red, $green, $blue); 
					$txtcolor = sprintf("%2x%2xl2x", $red, $green, $blue); 

					Сделать прозрачным некоторый цвет:
						int imagaColorTransparent (int $im [ , $int col] ) 
				
			//--Копирование изображений:
					
					Картинку src_img поместить в dst_img, при этом:
					 Выбрать облась исходного изображения: src_X src_Y, src_W, src_H
					 Втиснуть все это в область 					 dst_X dst_Y  dst_W  dst_H
					
				//Прямое изменение:
					int imageCopyResized(int $dst_img, int $src_img, int $dst_X, int $dst_Y
					 										 int $src_X, 	 int $src_Y,   int $dst_W, int $dst_H
					 										 int $src_W, 	 int $src_H,
																		)

				//Сглаживающее изменени:
					int imageCopyResempled(int $dst_img, int $src_img, int $dst_X, int $dst_Y
					 										 int $src_X, 	 int $src_Y,   int $dst_W, int $dst_H
					 										 int $src_W, 	 int $src_H,
																		)

					Пример:
					<?php 
							
							$from = imageCreateFromJpeg( "sample2.jpg");
							$to 	= imageCreateTrueColor(2000, 2000);
							imageCopyResampled($to, $from, 0, 0, 0, 0, imageSX($to), imageSY($to), imageSX($from), imageSY($from));

							header("Content-type: image/jpeg");  
							imageJpeg($to); 
					?>

					Прямоугольник (чтобы закрасить прозрачным цветом картинку):
						int imageFilledRectangle(int $im, int $x1, int $y1, int $x2, int $y2, int $col) 

					Пример (прозрачный фон):
						$i = imageCreate(1OO, 100); 
						$c = imageColorAllocate ($i, 1, 255, l); 
						imageFilledRectangle($i, 0, 0, imageSX($i)-1, imageSY($i)-1, $c); 
						imageColorTransparent($i, $c); 

					Линия:
						int imageLine(int $im, int $x1, int $y1, int $x2, int $y2, int $col); // col - цвет

					Заливка одноцветной области:
						int imageFill(int $im, int $x, int $y, int $col)
			
					!!! Если вместо цвета всем функциям указать  IMG_COLOR_TILED,
					!!! То можно будет исп катринку как фон
						
						// Установить текущую текстуру закраски для картинки
						int imageSetTile(resouroe $im, resource $tile) 

					// Узнать какой цвет пикаселя(чтобы, к примеру потом сделать область таких пикселей прозрачной):
					//  Вернет идетнтификатор цвета 
					 		resource imageColorAt(int $im, int $x, int $y)
			*/

?>