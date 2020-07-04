// Проверка на Браузер для подключения AJAX

 function ajaxRequest()  
 {    
 	try // Браузер не относится к семейству IE?    
 	{		// Да        
 			var request = new XMLHttpRequest()    
 	}
 	catch(e1){        
 		try // Это IE 6+?
 		{   // Да            
 			request = new ActiveXObject("Msxml2.XMLHTTP")        
 		}        
 		catch(e2){            
 			try // Это IE 5?            
 			{   // Да                
 				request = new ActiveXObject("Microsoft.XMLHTTP")            
 			}            
 			catch(e3) // Данный браузер не поддерживает AJAX            
 			{                
 				request = false            
 			}	        
 		}    
 	}    
 	return request  
 }