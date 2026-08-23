// CREATE - lisa
$nimi = "Karl";

$sql = "INSERT INTO kasutajad (nimi) VALUES ('$nimi')";
$conn->query($sql);


// READ - näita
$sql = "SELECT * FROM kasutajad";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo $row["id"] . " - " . $row["nimi"] . "<br>";
}


// UPDATE - muuda
$id = 1;
$nimi = "Jaan";

$sql = "UPDATE kasutajad SET nimi='$nimi' WHERE id=$id";
$conn->query($sql);


// DELETE - kustuta
$id = 1;

$sql = "DELETE FROM kasutajad WHERE id=$id";
$conn->query($sql);



CREATE → INSERT
READ   → SELECT
UPDATE → UPDATE
DELETE → DELETE


