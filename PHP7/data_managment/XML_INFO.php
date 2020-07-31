<?php

			/*
					XML как HTML, но строже и даже может выдавать ошибки. Часто исп в RSS лентах

					Внутри тегов не разрешается испольовать <,>,&
					Если содержимое тега долно храниться без преобразвания, то есть скция CDATA
					<description><![CDATA[ <strong> HELLO </strong> ]]</description>

					Подключить можно RSS в head
					<link href='rss.xml' rel='alternate' type='application/rss+xml' /> 
			*/

			/*
						Получить доступ к содержимому через PHP можно так:

						final public SimpleXMLElement::__construct(
									string $data [,									// Содерание XML файла или URL к нему, если data_is_url = true
									int $option = 0 [,							// Параметры (удаление пустых узлов, разворачивать пустые теги и др.)
									bool $data_is_url = false [,
									string $ns = ''[,								// Для пространсва имен, лио префикс, если is_prefix = true
									bool $is_prefix = false ]]]]
						);
					
					Пример:
						$content= file_get_contents('rss.xml');
						$rss = new SimpleXMLElement($content};
						echo $rss->channel->title.'<br />' ; // PHP 
						
						$rss->channel->item->count(); // Кол-во элементов

						foreach(Srss->channel->item as $item) { 
							echo $item->title. "<br />"; 
						}
					

					
					Доступ к атрибутам:
					
					public SimpleXMLElement SimpleXMLElemant::attributes([
								string $ns = NULL [,
								bool $is_prefix = false
										])
					
					Примеры:
					foreach($rss->channel->item[0]->enclosure->attributes() as $name => $value) 
					{
							echo "{$name} = {$value}<br />"; 
					}

					foreach($rss->channel->item as $item)
					{
							echo  $item->enclosure['url'] ."<br />"; 
					}

			*/


			/*		XPath 
						
						XPath как регулярные выражения. 
						Позволяет сократить цепочку для доступа к элементам.

						public array SimpleXMLElemant::xpath(string $path)


						Пример:
						$rss = new SimpleXMLElement($content);
						foreach($rss->xpath('//enclosure') as $enclosure) 
						{
								echo $enclosure['url'].'<br />'; 

						}

			*/

			/*  Формирование XML
					
					Добавить элемент с именем name и значением value с протсранством имен namespace
						public SimpleXMLElement SimpleXMLElement::addChild (
												string $name[, 
												string $value[,
												string $namespace]])

					public void SimpleXMLElement::addAttribute(
												string $name[, 
												string $value[,
												string $namespace]])
					
					// Верент XML-документ в виде строки
					// Если указан filename, то документ сохраняется в файл
					// Так можно формировать RSS канал, используя MySQL
						public mixed SimpleXMLElement::asXML([string $filename])
			*/


?>