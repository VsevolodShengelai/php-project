<?php
    session_start();
    require_once 'connect.php';
    require_once 'functions.php';

    $login = clear_data($_POST['login']);
    $password = clear_data($_POST['password']);
    $confirm_password = clear_data($_POST['confirm_password']);

    /*
    На будущее: добавить больше условий к паролю
    Сейчас ограничение только по длине
    */ 

    $errors = [];
    $error_flag = 0;

    if (!is_valid_login($login)){
        $errors['login'] = 'Строка должна начинаться с буквы и заканчиваться ею. Длина строки - 4 до 31 символов';
        $error_flag = 1;
    } elseif (!is_login_unique($login, $link)){
        $errors['login'] = 'Этот логин уже занят';
        $error_flag = 1;
    }
    if (strlen($password) < 4){
        $errors['password'] = 'Слишком короткий пароль';
        $error_flag = 1;
    }
    if (strlen($confirm_password) < 4){
        $errors['confirm_password'] = 'Слишком короткий пароль';
        $error_flag = 1;
    }
    

    if ($password === $confirm_password and !$error_flag){
        //print("Пароли совпадают");
        
        mysqli_query($link, "INSERT INTO `players` 
        (`player_login`, `player_password`) VALUES 
        ('$login', '$password')");
        
        $_SESSION['message'] = 'Регистрация прошла успешно';
        header('Location: ../index.php'); 
    }
    else{
        if ($password !== $confirm_password){
            $errors['password'] = 'Пароли не совпадают';
            $errors['confirm_password'] = 'Пароли не совпадают';
        }
        $_SESSION['errors'] = $errors;
        $_SESSION['POST'] = $_POST;
        //die($errors['login']);
        //print("Пароли НЕ совпадают");
        //die('пароли не совпадают'); //Передать это сообщение на клент
        header('Location: ../registration.php'); 
    }