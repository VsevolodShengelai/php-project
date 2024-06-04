<?php
// Проверка, авторизован ли пользователь
session_start();
$isLoggedIn = isset($_SESSION['user']); // или другой метод проверки авторизации
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav me-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Просмотр статистики
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink1">
                        <li><a class="dropdown-item" href="view_players.php">Вывести общую информацию по игрокам</a></li>
                        <li><a class="dropdown-item" href="view_purchase_report.php">Вывести отчёт по покупкам</a></li>
                        <li><a class="dropdown-item" href="#">Вывести записи на турнир</a></li>
                        <li><a class="dropdown-item" href="view_guilds.php">Вывести список гильдий</a></li>
                        <li><a class="dropdown-item" href="view_guild_members.php">Посмотреть состав гильдий</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Менеджмент проекта
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                        <li><a class="dropdown-item" href="edit_inventory.php">Изменить инвентарь игрока</a></li>
                        <li><a class="dropdown-item" href="edit_tournaments_requests.php">Принять заявку на учатие в турнире</a></li>
                    </ul>
                </li>
            </ul>
            <?php if ($isLoggedIn): ?>
            <form class="d-flex ms-auto" action="server/logout.php" method="post">
                <button class="btn btn-outline-danger" type="submit">Выход</button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</nav>
