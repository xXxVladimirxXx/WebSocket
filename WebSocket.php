<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="UTF-8">
			<title>WebSocket</title>
	</head>
<body>
	<h2>Пример работы с WebSocket</h2>
		<form action="" name="messages">
			<div class="row">Имя: <input type="text" name="fname"></div>
            <div class="row">Текст: <input type="text" name="msg"></div>
            <div class="row"><input type="submit" value="Поехали"></div>
		</form>
        <div id="status"></div>
    <script>
    window.onload = function() {
    var socket = new WebSocket("ws://echo.websocket.org");
    var status = document.querySelector("#status");

    //Открытие соединения
    socket.onopen = function(event) {
        status.innerHTML = "Соединения успешно!";
    }
    //Закрытие соединения
    socket.onclose = function(event) {
        if( event.wasClean) {
            status.innerHTML = "Соединения закрыто";
        } else {
            status.innerHTML = "Соединения как-то закрыто";
        };
        status.innerHTML += "<br>код: " + event.code + "причина: " + event.reason;
    }
    //Получение данных
    socket.onmessage = function(event) {
        let message = JSON.parse(event.data);
        status.innerHTML = `Пришли данные: <b>${message.name}</b>: ${message.msg}`;
    };
    //Возникновение ошибки
    socket.onerror = function(event) {
        status.innerHTML = "Ошибка : " + event.message;
    }

    document.forms["messages"].onsubmit = function(){
        let message = {
            name: this.fname.value,
            msg: this.msg.value
        }

        socket.send(JSON.stringify(message));
        return false;
    }
}

    </script>
</body>
</html>