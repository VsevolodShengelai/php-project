<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Изменить инвентарь игрока</title>
</head>
<body>
    <?php include 'navigation.php'; ?>
    <div class="container mt-3">
        <h2>Изменить инвентарь игрока</h2>
        <?php
        require_once 'server/connect.php';

        // Обработка обновления инвентаря
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['resources'])) {
            $player_id = $_POST['player_id'];
            foreach ($_POST['resources'] as $resource_id => $amount) {
                if ($stmt = mysqli_prepare($link, "UPDATE players2resources SET amount = ? WHERE player_id = ? AND resource_id = ?")) {
                    mysqli_stmt_bind_param($stmt, "iii", $amount, $player_id, $resource_id);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                }
            }
            echo "<div class='alert alert-success' role='alert'>Инвентарь успешно обновлен.</div>";
        }

        // Форма для ввода логина игрока
        ?>
        <form action="edit_inventory.php" method="post" class="mb-3">
            <div class="mb-3">
                <label for="playerLogin" class="form-label">Введите логин игрока:</label>
                <input type="text" class="form-control" id="playerLogin" name="player_login" required>
                <button type="submit" class="btn btn-primary mt-2">Найти игрока</button>
            </div>
        </form>

        <?php
        if (isset($_POST['player_login'])) {
            $player_login = mysqli_real_escape_string($link, $_POST['player_login']);
            $player_query = mysqli_query($link, "SELECT player_id FROM players WHERE player_login = '$player_login'");
            if ($player = mysqli_fetch_assoc($player_query)) {
                $player_id = $player['player_id'];
                $resources = mysqli_query($link, "SELECT pr.resource_id, r.resource_type, pr.amount FROM players2resources pr JOIN resources r ON pr.resource_id = r.resource_id WHERE pr.player_id = $player_id");

                echo "<form action='edit_inventory.php' method='post'>";
                echo "<input type='hidden' name='player_id' value='$player_id'>";
                echo "<table class='table'><thead><tr><th>Ресурс</th><th>Количество</th></tr></thead><tbody>";
                while ($resource = mysqli_fetch_assoc($resources)) {
                    echo "<tr>
                            <td>{$resource['resource_type']}</td>
                            <td><input type='number' name='resources[{$resource['resource_id']}]' value='{$resource['amount']}' class='form-control'></td>
                          </tr>";
                }
                echo "</tbody></table>";
                echo "<button type='submit' class='btn btn-primary'>Сохранить изменения</button>";
                echo "</form>";
            } else {
                echo "<div class='alert alert-danger'>Игрок с таким логином не найден.</div>";
            }
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
