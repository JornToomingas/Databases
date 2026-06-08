<?php
include("config.php");

if(isset($_POST['delete_id'])){
    $id = $_POST['delete_id'];

    mysqli_query($yhendus, "DELETE FROM cars WHERE id='$id'");

    header("Location: index.php");
    exit;
}

if(isset($_POST['update_id'])){
    $id = $_POST['update_id'];

    $mark = $_POST['mark'];
    $model = $_POST['model'];
    $engine = $_POST['engine'];
    $fuel = $_POST['fuel'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    mysqli_query($yhendus,"
        UPDATE cars SET
        mark='$mark',
        model='$model',
        engine='$engine',
        fuel='$fuel',
        price='$price',
        description='$description'
        WHERE id='$id'
    ");

    header("Location: index.php");
    exit;
}

$edit_id = isset($_GET['edit_id']) ? $_GET['edit_id'] : 0;

$result = mysqli_query($yhendus, "SELECT * FROM cars");
?>
