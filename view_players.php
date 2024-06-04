<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Список игроков</title>
</head>
<body>
    <?php include 'navigation.php'; ?>
    <div class="container mt-3">
        <h2>Список игроков</h2>
        <?php
        require_once 'server/connect.php';
        // Подготовка запроса к базе данных
        $query = "
        SELECT p.player_id, p.player_login, g.guild_name, gr.guild_rank_name,
            GROUP_CONCAT(DISTINCT CONCAT(r.resource_type, ': ', pr.amount) SEPARATOR ', ') AS resources
        FROM players p
        LEFT JOIN players2guilds p2g ON p.player_id = p2g.player_id
        LEFT JOIN guilds g ON p2g.guild_id = g.guild_id
        LEFT JOIN guild_rank gr ON p2g.rank_id = gr.guild_rank_id
        LEFT JOIN players2resources pr ON p.player_id = pr.player_id
        LEFT JOIN resources r ON pr.resource_id = r.resource_id
        GROUP BY p.player_id, p.player_login, g.guild_name, gr.guild_rank_name
        ORDER BY p.player_id;
        ";
        $result = mysqli_query($link, $query);
        
        while ($row = mysqli_fetch_assoc($result)) {
            $guild_name = !empty($row['guild_name']) ? $row['guild_name'] : '-';
            $guild_rank_name = !empty($row['guild_rank_name']) ? $row['guild_rank_name'] : '-';
            $resources = !empty($row['resources']) ? $row['resources'] : '-';
            echo "
            <div class='card mb-3'>
                <div class='card-header'>Игрок: {$row['player_login']}</div>
                <div class='card-body'>
                    <p>Гильдия: {$guild_name}</p>
                    <p>Звание: {$guild_rank_name}</p>
                    <p>Ресурсы: {$resources}</p>
                </div>
            </div>
            ";
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
