<?php

// muutujad
$nimi = "Karl";
$vanus = 18;

echo $nimi;
echo "Tere " . $nimi;


// if
if ($vanus >= 18) {
    echo "Täiskasvanu";
} else {
    echo "Alaealine";
}


// vormist
$nimi = $_POST["nimi"];
$id = $_POST["id"];


// array
$autod = ["BMW", "Audi", "Toyota"];


// foreach
foreach ($autod as $auto) {
    echo $auto;
}


// CRUD

// lisa
$sql = "INSERT INTO kasutajad (nimi) VALUES ('$nimi')";
$conn->query($sql);


// näita
$sql = "SELECT * FROM kasutajad";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo $row["nimi"];
}


// muuda
$sql = "UPDATE kasutajad SET nimi='$nimi' WHERE id=$id";
$conn->query($sql);


// kustuta
$sql = "DELETE FROM kasutajad WHERE id=$id";
$conn->query($sql);


// põhilised asjad

// $ = muutuja
// echo = näita
// . = ühenda tekst
// == = võrdne
// === = täpselt võrdne
// > = suurem
// < = väiksem
// && = ja
// || = või

?>

CREATE → INSERT
READ   → SELECT
UPDATE → UPDATE
DELETE → DELETE


