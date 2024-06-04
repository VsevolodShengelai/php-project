<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Список гильдий</title>
</head>
<body>
    <?php include 'navigation.php'; ?>
    <div class="container mt-3">
        <h2>Список гильдий</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID гильдии</th>
                    <th>Название гильдии</th>
                    <th>Описание гильдии</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once 'server/connect.php'; // Подключение к базе данных
                $query = "SELECT guild_id, guild_name, guild_description FROM guilds";
                $result = mysqli_query($link, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>{$row['guild_id']}</td><td>{$row['guild_name']}</td><td>{$row['guild_description']}</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
