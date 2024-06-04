<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <?php include 'navigation.php'; ?>

    <div class="container mt-5">
        <h1>Общая статистика</h1>
        <?php
        require_once 'server/connect.php';

        // Получение общего количества игроков
        $result = mysqli_query($link, "SELECT COUNT(*) AS total_players FROM players");
        $total_players = mysqli_fetch_assoc($result)['total_players'];

        // Получение общего количества турниров
        $result = mysqli_query($link, "SELECT COUNT(*) AS total_tournaments FROM tournaments");
        $total_tournaments = mysqli_fetch_assoc($result)['total_tournaments'];

        // Получение общего количества гильдий
        $result = mysqli_query($link, "SELECT COUNT(*) AS total_guilds FROM guilds");
        $total_guilds = mysqli_fetch_assoc($result)['total_guilds'];
        ?>
        <!-- Dashboard Widgets -->
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Общее количество игроков</h5>
                        <p class="card-text"><?php echo $total_players; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Количество турниров</h5>
                        <p class="card-text"><?php echo $total_tournaments; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Количество гильдий</h5>
                        <p class="card-text"><?php echo $total_guilds; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
