<?php
include("config.php");
session_start();

?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5" style="max-width:400px;">
<h3 class="mb-3">Konto loomine</h3>

<form method="POST">

<div class="mb-3">
<label>Eesnimi</label>
<input type="text" name="first_name" class="form-control">
</div>

<div class="mb-3">
<label>Perekonnanimi</label>
<input type="text" name="last_name " class="form-control">
</div>

<div class="mb-3">
<label>Kasutajanimi</label>
<input type="text" name="username" class="form-control">
</div>

<div class="mb-3">
<label>Parool</label>
<input type="password" name="password" class="form-control">
</div>

<button class="btn btn-dark w-100">Loo konto</button>

</form>