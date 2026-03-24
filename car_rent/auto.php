<?php 
include("config.php");
session_start();

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$car_id = intval($_GET["id"]);
$message = ""; // Siia salvestame rohelise või punase teate

// Võtame auto andmed Sinu tabeli väljadega
$stmt = mysqli_prepare($yhendus, "SELECT * FROM cars WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $car_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$auto = mysqli_fetch_assoc($result);

if (!$auto) {
    exit("Autot ei leitud!");
}

// Kui vajutatakse "Broneeri" nuppu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['start_date'], $_POST['end_date'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $start = new DateTime($start_date);
    $end = new DateTime($end_date);

    if ($start > $end) {
        $message = "<div class='alert alert-danger'>Alguskuupäev peab olema enne lõppkuupäeva.</div>";
    } else {
        // Arvutame päevad ja hinna (Sinu 'price' välja põhjal)
        $days = $start->diff($end)->days + 1;
        $total_price = $days * $auto['price'];

        // Kasutaja ID (kui sessioonis pole, paneme prooviks 1)
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;

        // Kontrollime saadavust (Etapp 9 loogika)
        $check = mysqli_prepare($yhendus, "SELECT id FROM reservations WHERE car_id = ? AND status = 'active' AND (? <= end_date) AND (? >= start_date)");
        mysqli_stmt_bind_param($check, "iss", $car_id, $end_date, $start_date);
        mysqli_stmt_execute($check);
        $check_result = mysqli_stmt_get_result($check);

        if (mysqli_num_rows($check_result) > 0) {
            $message = "<div class='alert alert-danger'>See auto on juba sel ajal broneeritud.</div>";
        } else {
            // SALVESTAME BRONEERINGU
            $stmt2 = mysqli_prepare($yhendus, "INSERT INTO reservations (user_id, car_id, start_date, end_date, total_price, status) VALUES (?, ?, ?, ?, ?, 'active')");
            mysqli_stmt_bind_param($stmt2, "iissd", $user_id, $car_id, $start_date, $end_date, $total_price);
            
            if(mysqli_stmt_execute($stmt2)) {
                // ROHELINE SÕNUM
                $message = "<div class='alert alert-success mt-3'>✅ Broneering õnnestus! Koguhind: " . number_format($total_price, 2) . " €</div>";
            }
        }
    }
}
?>

<!doctype html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <title><?php echo $auto["mark"] . " " . $auto["model"]; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-5">
    <?php echo $message; ?> <div class="row mt-4">
        <div class="col-md-6">
            <img src="https://loremflickr.com/800/500/car,<?php echo $auto['mark']; ?>" class="img-fluid rounded">
        </div>

        <div class="col-md-6">
            <h2><?php echo $auto["mark"] . " " . $auto["model"]; ?></h2>
            <ul class="list-group mb-3">
                <li class="list-group-item"><strong>Aasta:</strong> <?php echo $auto["year"]; ?></li>
                <li class="list-group-item"><strong>Mootor:</strong> <?php echo $auto["motor"]; ?></li>
                <li class="list-group-item"><strong>Kaigukast:</strong> <?php echo $auto["transmission"]; ?></li>
                <li class="list-group-item"><strong>Kirjeldus:</strong> <?php echo $auto["description"]; ?></li>
                <li class="list-group-item"><strong>Kütus:</strong> <?php echo $auto["fuel"]; ?></li>
                <li class="list-group-item"><strong>Istmed:</strong> <?php echo $auto["seats"]; ?></li>
                <li class="list-group-item"><strong>Hind:</strong> <?php echo $auto["price"]; ?> €/päev</li>
            </ul>


            <form method="POST" class="border p-3 rounded bg-light">
                <div class="mb-3">
                    <label class="form-label">Algus:</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Lõpp:</label>
                    <input type="date" name="end_date" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Broneeri kohe</button>
            </form>
            <a href="index.php" class="btn btn-secondary mt-3">Tagasi</a>
        </div>
    </div>
</div>

</body>
</html>