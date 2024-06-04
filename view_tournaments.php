<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Просмотр турниров</title>
</head>
<body>
    <?php include 'navigation-player.php'; ?>
    <div class="container mt-3">
        <h2>Список турниров</h2>
        <?php
        require_once 'server/connect.php';
        session_start();

        $player_id = $_SESSION['user']['id']; // Предполагается, что ID пользователя хранится в сессии

        // Проверка, если игрок уже подал заявку или участвует в турнире
        $query_check = "
        SELECT 1
        FROM tournament_requests
        WHERE player_id = '$player_id'
        UNION
        SELECT 1
        FROM players2tournaments
        WHERE player_id = '$player_id';
        ";
        $result_check = mysqli_query($link, $query_check);
        $is_registered = mysqli_num_rows($result_check) > 0;

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$is_registered) {
            $tournament_id = $_POST['tournament_id'];

            // Вставка заявки на участие в турнире
            $query = "
            INSERT INTO tournament_requests (player_id, tournament_id)
            VALUES ('$player_id', '$tournament_id')
            ON DUPLICATE KEY UPDATE request_type = CURRENT_TIMESTAMP;
            ";
            mysqli_query($link, $query);

            echo "<div class='alert alert-success'>Вы успешно зарегистрировались на турнир.</div>";

            // Обновление статуса регистрации
            $is_registered = true;
        }

        // Подготовка запроса к базе данных для получения списка турниров
        $query = "
        SELECT t.tournament_id, t.tournament_name, t.tournament_details
        FROM tournaments t
        ORDER BY t.tournament_name DESC;
        ";
        $result = mysqli_query($link, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $tournament_id = $row['tournament_id'];
                echo "
                <div class='card mb-3'>
                    <div class='card-header'>
                        Турнир: {$row['tournament_name']}
                    </div>
                    <div class='card-body'>
                        <p>Детали турнира: {$row['tournament_details']}</p>";
                        
                if ($is_registered) {
                    echo "<p class='text-success'>Вы уже зарегистрированы на один из турниров или подали заявку.</p>";
                } else {
                    echo "
                        <form method='post' action=''>
                            <input type='hidden' name='tournament_id' value='{$tournament_id}'>
                            <button type='submit' class='btn btn-primary'>Зарегистрироваться</button>
                        </form>";
                }

                echo "
                    </div>
                </div>";
            }
        } else {
            echo "<p>Нет доступных турниров.</p>";
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
