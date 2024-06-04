<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Отчет по покупкам</title>
</head>
<body>
    <?php include 'navigation.php'; ?>
    <div class="container mt-3">
        <h2>Отчет по покупкам</h2>
        <form action="view_purchase_report.php" method="post" class="mb-3">
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <label for="startDate" class="col-form-label">Дата начала:</label>
                    <input type="date" id="startDate" name="startDate" class="form-control" required>
                </div>
                <div class="col-auto">
                    <label for="endDate" class="col-form-label">Дата окончания:</label>
                    <input type="date" id="endDate" name="endDate" class="form-control" required>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Показать отчет</button>
                </div>
            </div>
        </form>

        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['startDate'], $_POST['endDate'])) {
                require_once 'server/connect.php';
                $startDate = $_POST['startDate'];
                $endDate = $_POST['endDate'] . ' 23:59:59';

                $query = "SELECT pt.log_id, p.player_login, r.resource_type, pt.amount, pt.resource_price, 
                                COALESCE(d.discount_value, 0) as discount_value, 
                                (pt.resource_price - COALESCE(d.discount_value, 0)) * pt.amount AS final_price,
                                pt.transaction_datetime
                        FROM purchase_transactions pt
                        JOIN resources r ON pt.resource_id = r.resource_id
                        JOIN players p ON pt.player_id = p.player_id
                        LEFT JOIN discounts d ON pt.discount_id = d.discount_id
                        WHERE pt.transaction_datetime BETWEEN ? AND ?
                        ORDER BY pt.transaction_datetime DESC";

                if ($stmt = mysqli_prepare($link, $query)) {
                    mysqli_stmt_bind_param($stmt, "ss", $startDate, $endDate);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    echo "<table class='table'><thead><tr><th>Log ID</th><th>Логин игрока</th><th>Тип ресурса</th><th>Количество</th><th>Цена за единицу</th><th>Скидка</th><th>Цена после скидки</th><th>Дата транзакции</th></tr></thead><tbody>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$row['log_id']}</td>
                                <td>{$row['player_login']}</td>
                                <td>{$row['resource_type']}</td>
                                <td>{$row['amount']}</td>
                                <td>\${$row['resource_price']}</td>
                                <td>\${$row['discount_value']}</td>
                                <td>\${$row['final_price']}</td>
                                <td>{$row['transaction_datetime']}</td>
                            </tr>";
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
