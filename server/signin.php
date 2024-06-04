<?php
    session_start();
    require_once 'connect.php';

    $response = file_get_contents($url);
    $responseKeys = json_decode($response, true);
    header('Content-type: application/json');

    $login = $_POST['login'];
    $password = $_POST['password'];

    // Проверяем в таблице админов
    $resultAdmin = mysqli_query($link, "SELECT * FROM `admins` WHERE `admin_login` = '$login'");
    $admin = mysqli_fetch_assoc($resultAdmin);

    // Проверяем в таблице пользователей
    $resultPlayer = mysqli_query($link, "SELECT * FROM `players` WHERE `player_login` = '$login'");
    $player = mysqli_fetch_assoc($resultPlayer);

    if ($admin && $password == $admin['admin_password']) {
        // Авторизация для админа
        $_SESSION['user'] = [
            'id' => $admin['admin_id'],
            'name' => $admin['admin_login'],
            'type' => 'admin'
        ];
        header('Location: ../admin_dashboard.php');
    } elseif ($player && $password == $player['player_password']) {
        // Авторизация для пользователя
        $_SESSION['user'] = [
            'id' => $player['player_id'],
            'name' => $player['player_login'],
            'type' => 'player'
        ];
        header('Location: ../player_dashboard.php');
    }
    else{
        $_SESSION['message'] = 'Не верный логин или пароль';
        header('Location: ../index.php'); 
    }
?>