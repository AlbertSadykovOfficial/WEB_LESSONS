function ReadFile(filename, container)
{
    //Создаем функцию обработчик
    var Handler = function(Request)
    {
        document.getElementById(container).innerHTML = Request.responseText;
    }
    
    //Отправляем запрос
    SendRequest("GET",filename,"",Handler);
    
} 
