<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>User Dashboard</title>
</head>
<body>
    <?php include 'navigation-player.php'; ?>
    <?php
    require_once 'server/connect.php';
    $player_id = $_SESSION['user']['id']; // или $_SESSION['player_id'], если используется сессия
    
    $query = "
    SELECT p.player_login, r.resource_type, pr.amount, g.guild_name, gr.guild_rank_name, t.tournament_name, t.tournament_details
    FROM players p
    LEFT JOIN players2resources pr ON p.player_id = pr.player_id
    LEFT JOIN resources r ON pr.resource_id = r.resource_id
    LEFT JOIN players2guilds p2g ON p.player_id = p2g.player_id
    LEFT JOIN guilds g ON p2g.guild_id = g.guild_id
    LEFT JOIN guild_rank gr ON p2g.rank_id = gr.guild_rank_id
    LEFT JOIN players2tournaments p2t ON p.player_id = p2t.player_id
    LEFT JOIN tournaments t ON p2t.tournament_id = t.tournament_id
    WHERE p.player_id = ?
    ORDER BY r.resource_type;
    ";

    $resources = [];
    $guild_info = "";
    $tournament_info = "";

    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $player_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)) {
            $player_login = $row['player_login'];
            $guild_info = $row['guild_name'] . " - " . $row['guild_rank_name'];
            $tournament_info = $row['tournament_name'] . ": " . $row['tournament_details'];
            $resources[] = $row['resource_type'] . ": " . $row['amount'];
        }
        mysqli_stmt_close($stmt);
    }
    ?>
    <div class="container mt-5">
        <h1>Статистика игрока: <?php echo $player_login; ?></h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Гильдия и ранг</h5>
                <p class="card-text"><?php echo $guild_info; ?></p>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Текущий турнир</h5>
                <p class="card-text"><?php echo $tournament_info; ?></p>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Ресурсы</h5>
                <ul>
                <?php foreach ($resources as $resource) {
                    echo "<li>$resource</li>";
                } ?>
                </ul>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
