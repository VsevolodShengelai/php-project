<?php

require_once 'connect.php';

function clear_data($val){
    //Удаляет пробелы (или другие символы) из начала и конца строки
    $val = trim($val);
    //Удаляет экранирование символов
    $val = stripslashes($val);
    //Удаляет теги HTML и PHP из строки
    $val = strip_tags($val);    
    //Преобразует специальные символы в HTML-сущности
    $val = stripslashes($val);
    return $val;
}

/*
Набор запросов к БД для дальнейшей проверки уникальности логина, почты, телефона
*/
// Возращает false - не уникален, возвращает true - уникален
function is_login_unique($login, $link){
    $query_login = "SELECT COUNT(*) FROM `users` WHERE `login` = '$login'";
    $result_login = mysqli_query($link, $query_login);
    $count_login = mysqli_fetch_array($result_login)[0];
    if ($count_login > 0){
        return false;
    }
    else{
        return true;
    }
}
function is_telephone_unique($telephone, $link){
    $query_telephone = "SELECT COUNT(*) FROM `users` WHERE `telephone` = '$telephone'";
    $result_telephone = mysqli_query($link, $query_telephone);
    $count_telephone = mysqli_fetch_array($result_telephone)[0];
    if ($count_telephone > 0){
        return false;
    }
    else{
        return true;
    }
}
function is_email_unique($email, $link){
    $query_email = "SELECT COUNT(*) FROM `users` WHERE `email` = '$email'";
    $result_email = mysqli_query($link, $query_email);
    $count_email = mysqli_fetch_array($result_email)[0];
    if ($count_email > 0){
        return false;
    }
    else{
        return true;
    }
}

function is_valid_login($login){
    /*
    Формат логина
    1) Строка начинается с любой буквы в любом алфавите (Unicode)
    2) Затем содержит от 4 до 31 символов любого типа (включая буквы, цифры, пробелы и специальные символы)
    */
    $pattern_login = '/^[^\W\d_][\p{L}\d\s\p{P}]{2,29}\p{L}$/u';
    return preg_match($pattern_login, $login);
}
function is_valid_telephone($telephone){
    /*
    Международный формат номера
    1) В начале могут быть пробелы, после них может быть "+" (а может и не быть)
    2) Дальше должна идти группа цифр в количестве от 10 до 14.
    3) До и после каждой цифры может быть один из 8 знаков ("-", " ", "_", "(", ")", ":", "=", "+")
    */
    $pattern_phone = '/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/';
    return preg_match($pattern_phone, $telephone);
}
function is_valid_email($email){
    /*
    Формат e-mail адреса
    */
    $pattern_email = '/^[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}$/i';
    return preg_match($pattern_email, $email);
}
