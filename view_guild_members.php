<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Состав гильдии</title>
</head>
<body>
    <?php include 'navigation.php'; ?>
    <div class="container mt-3">
        <h2>Посмотреть состав гильдий</h2>
        <form action="view_guild_members.php" method="get">
            <div class="mb-3">
                <label for="guild" class="form-label">Выберите гильдию:</label>
                <select name="guild_id" id="guild" class="form-control">
                    <?php
                    require_once 'server/connect.php';
                    $query = "SELECT guild_id, guild_name FROM guilds ORDER BY guild_name";
                    $result = mysqli_query($link, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $selected = (isset($_GET['guild_id']) && $_GET['guild_id'] == $row['guild_id']) ? 'selected' : '';
                        echo "<option value='{$row['guild_id']}' {$selected}>{$row['guild_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Показать состав</button>
        </form>

        <?php
        if (isset($_GET['guild_id'])) {
            $guild_id = $_GET['guild_id'];

            $query = "SELECT p.player_id, p.player_login, gr.guild_rank_name, p2g.date_of_entry
                      FROM players p
                      JOIN players2guilds p2g ON p.player_id = p2g.player_id
                      LEFT JOIN guild_rank gr ON p2g.rank_id = gr.guild_rank_id
                      WHERE p2g.guild_id = ?";
            if ($stmt = mysqli_prepare($link, $query)) {
                mysqli_stmt_bind_param($stmt, "i", $guild_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                echo "<table class='table table-striped mt-4'><thead><tr><th>ID игрока</th><th>Логин игрока</th><th>Звание</th><th>Дата вступления</th></tr></thead><tbody>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>{$row['player_id']}</td><td>{$row['player_login']}</td><td>{$row['guild_rank_name']}</td><td>{$row['date_of_entry']}</td></tr>";
                }
                echo "</tbody></table>";
                mysqli_stmt_close($stmt);
            } else {
                echo "Ошибка: " . mysqli_error($link);
            }
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
