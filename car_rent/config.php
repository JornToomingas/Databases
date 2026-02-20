<?php

// Andmebaasi ühenduse andmed
$db_server = 'localhost';
$db_andmebaas = 'autorent';
$db_kasutaja = 'jtoomingas';
$db_salasona = 'Passw0rd';

// Ühenduse loomine
$yhendus = new mysqli($db_server, $db_kasutaja, $db_salasona, $db_andmebaas);

// Ühenduse kontroll
if (!$yhendus) {
    die('Ei saa ühendust andmebaasiga');
}

?>