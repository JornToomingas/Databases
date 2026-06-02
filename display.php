<?php
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "autorent";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT mark, model FROM cars";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo "<table><tr><th>Mark</th><th>Mudel</th></tr>";
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "<tr><td>".$row["mark"]."</td><td>".$row["model"]."</td><td>muuda</td></tr>";
  }
  echo "</table>";
} else {
  echo "0 results";
}

$conn->close();
?>