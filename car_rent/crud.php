<?php
//Andmebaasiga ühendumine
$conn = new mysqli("localhost", "root", "", "car_rent");
 
if($conn->connect_error){
	die("connection failed: " . $conn->connect_error);
}
 
//Kustutamine 
if(isset($_GET['delete'])){
	$id = $_GET['delete'];
	$conn->query("DELETE FROM cars WHERE id = $id");
	header("Location: crud.php");
	exit;
}
 
//Update
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$mark = $_POST['mark'];
	$model = $_POST['model'];
	$motor = $_POST['motor'];
	$fuel = $_POST['fuel'];
	$price = $_POST['price'];
 
	if(!empty($_POST['id'])){
		// Auto andmete uuendamine (UPDATE cars)
		$id = $_POST['id'];
		$conn->query("UPDATE cars SET mark='$mark', model='$model', motor='$motor', fuel='$fuel', price='$price' WHERE id=$id");
	}else{
		//Uus auto (INSERT INTO cars)
		$conn->query("INSERT INTO cars (mark, model, motor, fuel, price) VALUES ('$mark', '$model', '$motor', '$fuel', '$price')");
	}
 
	header("Location: crud.php");
	exit;
}
 
//Kas me muudame midagi??? :d
$editRow = array("id"=>"", "mark"=>"", "model"=>"", "motor"=>"", "fuel"=>"", "price"=>"");
if(isset($_GET['edit'])){
	$id = $_GET['edit'];
	$res = $conn->query("SELECT * FROM cars WHERE id = $id");
	$editRow = $res->fetch_assoc();
}
 
//Kõik autod korraga :O
$cars = $conn->query("SELECT * FROM cars");
 
?>
 
<!DOCTYPE html>
<html>
<head>
<title>crud Mario jaoks ;)</title>
</head>
<body>
 
<h2><?php if($editRow['id']){ echo "Edit Car"; }else{ echo "Add Car"; } ?></h2>
 
<form action="crud.php" method="post">
<input type="hidden" name="id" value="<?php echo $editRow['id']; ?>">
 
Mark: <input type="text" name="mark" value="<?php echo $editRow['mark']; ?>">
<br><br>
Model: <input type="text" name="model" value="<?php echo $editRow['model']; ?>">
<br><br>
Motor: <input type="text" name="motor" value="<?php echo $editRow['motor']; ?>">
<br><br>
Fuel: <input type="text" name="fuel" value="<?php echo $editRow['fuel']; ?>">
<br><br>
Price: <input type="text" name="price" value="<?php echo $editRow['price']; ?>">
<br><br>
 
<input type="submit" value="<?php echo $editRow['id'] ? 'Update' : 'Add'; ?>">
</form>
 
<br>
<hr>
 
<h2>All Cars</h2>
 
<table border="1" cellpadding="6">
<tr>
<th>Mark</th>
<th>Model</th>
<th>Motor</th>
<th>Fuel</th>
<th>Price</th>
<th>Actions</th>
</tr>
 
<?php
while($row = $cars->fetch_assoc()){
	echo "<tr>";
	echo "<td>" . $row['mark'] . "</td>";
	echo "<td>" . $row['model'] . "</td>";
	echo "<td>" . $row['motor'] . "</td>";
	echo "<td>" . $row['fuel'] . "</td>";
	echo "<td>" . $row['price'] . "</td>";
	echo "<td>";
	echo "<a href='crud.php?edit=" . $row['id'] . "'>Edit</a> | ";
	echo "<a href='crud.php?delete=" . $row['id'] . "' onclick=\"return confirm('Olete kindel t tahate kustutada?')\">Delete</a>";
	echo "</td>";
	echo "</tr>";
}
?>
 
</table>
 
</body>
</html>
