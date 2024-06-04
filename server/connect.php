<?php
//Соединение с базой данных


$link = mysqli_connect('localhost','root','','php-project');

if ($link == false){
    print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
}
else {
    //print("Соединение установлено успешно");
}




