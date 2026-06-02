<?php

$db_server = 'localhost';
$db_andmebaas = 'autorent';
$db_kasutaja = 'root';
$db_salasona = '';

$yhendus = new mysqli($db_server, $db_kasutaja, $db_salasona, $db_andmebaas);

if (!$yhendus) {
    die('Ei saa ühendust andmebaasiga');
}

?>