<?php
// Проверка, авторизован ли пользователь
session_start();
$isLoggedIn = isset($_SESSION['user']); // или другой метод проверки авторизации
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Player Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="player_dashboard.php">Просмотр профиля</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view_tournaments.php">Просмотр турниров</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view_rewards.php">Мои награды</a>
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
