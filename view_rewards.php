<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Мои награды</title>
</head>
<body>
    <?php include 'navigation-player.php'; ?>
    <div class="container mt-3">
        <h2>Мои награды</h2>
        <?php
        require_once 'server/connect.php';
        session_start();

        $player_id = $_SESSION['user']['id']; // Предполагается, что ID пользователя хранится в сессии

        // Подготовка запроса к базе данных для получения наград игрока
        $query = "
        SELECT r.reward_datetime, t.tournament_name, res.resource_type, res.resource_image, r.amount
        FROM rewards_transactions r
        JOIN tournaments t ON r.tournament_id = t.tournament_id
        JOIN resources res ON r.resource_id = res.resource_id
        WHERE r.player_id = ?
        ORDER BY r.reward_datetime DESC;
        ";
        
        if ($stmt = mysqli_prepare($link, $query)) {
            mysqli_stmt_bind_param($stmt, "i", $player_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $resource_image_path = 'assets/images/resources/' . $row['resource_image'];
                    echo "
                    <div class='card mb-3'>
                        <div class='card-header'>
                            Турнир: {$row['tournament_name']}
                        </div>
                        <div class='card-body'>
                            <img src='{$resource_image_path}' alt='{$row['resource_type']}' class='img-fluid' style='max-width: 100px;'>
                            <p>Ресурс: {$row['resource_type']}</p>
                            <p>Количество: {$row['amount']}</p>
                            <p>Дата награды: {$row['reward_datetime']}</p>
                        </div>
                    </div>
                    ";
                }
            } else {
                echo "<p>У вас нет наград.</p>";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "<p>Ошибка запроса к базе данных.</p>";
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
