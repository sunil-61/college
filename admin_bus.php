<?php
session_start();
$conn = mysqli_connect("localhost","root","","student");

if(!isset($_SESSION['userid']) || $_SESSION['userid'] != "admin"){
    header("Location: login.html");
    exit();
}

if(isset($_POST['add'])){
    $location = $_POST['location'];
    $fees = $_POST['fees'];

    mysqli_query($conn,"INSERT INTO bus_routes (location,fees)
                        VALUES ('$location','$fees')");
}
?>

<html>
<head>
<title>Manage Bus Routes</title>
<style>
body{font-family:Arial;background:#f4f6f9;}
.box{width:400px;margin:60px auto;background:white;padding:30px;
border-radius:10px;box-shadow:0 0 10px gray;}
input{width:100%;padding:8px;margin:8px 0;}
button{padding:8px;background:#2c3e50;color:white;border:none;}
table{margin-top:20px;width:100%;}
td{padding:6px;border:1px solid gray;}
</style>
</head>
<body>

<div class="box">
<h2>Bus Route Management</h2>

<form method="post">
<input type="text" name="location" placeholder="Location Name" required>
<input type="number" name="fees" placeholder="Bus Fees" required>
<button name="add">Add Route</button>
</form>

<h3>Available Routes</h3>

<table>
<tr><td>Location</td><td>Fees</td></tr>

<?php
$res = mysqli_query($conn,"SELECT * FROM bus_routes");
while($row = mysqli_fetch_assoc($res)){
?>
<tr>
<td><?php echo $row['location']; ?></td>
<td>₹ <?php echo $row['fees']; ?></td>
</tr>
<?php } ?>
</table>

<br>
<a href="admin.html">Back</a>
</div>
</body>
</html>
