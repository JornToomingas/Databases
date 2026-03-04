<?php
include("config.php");

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET["id"]);

$stmt = mysqli_prepare($yhendus, "SELECT * FROM cars WHERE id = ?");
if (!$stmt) {
    die("SQL error: " . mysqli_error($yhendus));
}

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$auto = mysqli_fetch_assoc($result);

if (!$auto) {
    echo "Autot ei leitud!";
    exit();
}
?>

<!doctype html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <title><?php echo $auto["mark"] . " " . $auto["model"]; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- menüü -->
  <nav class="navbar navbar-expand-lg bg-body-tertiary  border-bottom">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">Autorent</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Avaleht</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Autod</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Hinnad</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Kontakt</a>
        </li>

      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Otsi..." aria-label="Search" name="search">
        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
      </form>
    </div>
  </div>
</nav>
<!-- /menüü -->

<div class="container py-5">
    <div class="row">
        
<div class="col-md-6">
    <img src="https://loremflickr.com/800/500/<?php echo $auto['mark']; ?>" class="img-fluid" alt="<?php echo $auto['mark']; ?>">
</div>

        <div class="col-md-6">
            <h2><?php echo $auto["mark"] . " " . $auto["model"]; ?></h2>

            <ul class="list-group mb-3">
                <li class="list-group-item">
                    <strong>Aasta:</strong> <?php echo $auto["year"]; ?>
                </li>
                <li class="list-group-item">
                    <strong>Mootor:</strong> <?php echo $auto["motor"]; ?>
                </li>
                <li class="list-group-item">
                    <strong>Kaigukast:</strong> <?php echo $auto["transmission"]; ?>
                </li>
                <li class="list-group-item">
                    <strong>Kirjeldus:</strong> <?php echo $auto["description"]; ?>
                </li>
                <li class="list-group-item">
                    <strong>Kütus:</strong> <?php echo $auto["fuel"]; ?>
                </li>
                <li class="list-group-item">
                    <strong>Istmed:</strong> <?php echo $auto["seats"]; ?>
                </li>
                <li class="list-group-item">
                    <strong>Hind:</strong> <?php echo $auto["price"]; ?> €/päev
                </li>
            </ul>

            <a href="index.php" class="btn btn-secondary">Tagasi</a>
            <button class="btn btn-dark">Broneeri</button>
        </div>

    </div>
</div>

</body>
</html>