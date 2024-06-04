<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Запросы на участие в турнире</title>
</head>
<body>
    <?php include 'navigation.php'; ?>
    <div class="container mt-3">
        <h2>Запросы на участие в турнире</h2>
        <?php
        require_once 'server/connect.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $player_id = $_POST['player_id'];
            $tournament_id = $_POST['tournament_id'];
            $action = $_POST['action'];

            if ($action == 'confirm') {
                // Подтверждение заявки: добавляем запись в таблицу players2tournaments
                $query = "
                INSERT INTO players2tournaments (player_id, tournament_id)
                VALUES ('$player_id', '$tournament_id')
                ON DUPLICATE KEY UPDATE registration_date = CURRENT_TIMESTAMP;
                ";
                mysqli_query($link, $query);
            }

            // Удаление заявки из таблицы tournament_requests
            $query = "
            DELETE FROM tournament_requests
            WHERE player_id = '$player_id' AND tournament_id = '$tournament_id';
            ";
            mysqli_query($link, $query);

            // Перенаправление на ту же страницу для предотвращения повторной отправки формы
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        // Подготовка запроса к базе данных для получения заявок
        $query = "
        SELECT tr.player_id, p.player_login, tr.tournament_id, t.tournament_name, tr.request_type
        FROM tournament_requests tr
        JOIN players p ON tr.player_id = p.player_id
        JOIN tournaments t ON tr.tournament_id = t.tournament_id
        ORDER BY tr.request_type DESC;
        ";
        $result = mysqli_query($link, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "
                <div class='card mb-3'>
                    <div class='card-header'>
                        Игрок: {$row['player_login']} запросил участие в турнире: {$row['tournament_name']}
                    </div>
                    <div class='card-body'>
                        <p>Дата запроса: {$row['request_type']}</p>
                        <form method='post' action=''>
                            <input type='hidden' name='player_id' value='{$row['player_id']}'>
                            <input type='hidden' name='tournament_id' value='{$row['tournament_id']}'>
                            <button type='submit' name='action' value='confirm' class='btn btn-success'>Подтвердить</button>
                            <button type='submit' name='action' value='decline' class='btn btn-danger'>Отклонить</button>
                        </form>
                    </div>
                </div>
                ";
            }
        } else {
            echo "<p>Нет запросов на участие в турнире.</p>";
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
