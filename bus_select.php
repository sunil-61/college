<?php
session_start();
$conn = mysqli_connect("localhost","root","","student");

if(!isset($_SESSION['userid'])){
    header("Location: login.html");
    exit();
}

$uid = $_SESSION['userid'];

if(isset($_POST['save'])){
    $route = $_POST['route'];

    mysqli_query($conn,"DELETE FROM student_bus WHERE userid='$uid'");

    mysqli_query($conn,"
        INSERT INTO student_bus (userid,route_id)
        VALUES ('$uid','$route')
    ");

    echo "<script>alert('Bus Selected Successfully');
    window.location.href='user.php';</script>";
}
?>

<html>
<head>
<title>Select Bus</title>
<style>
body{font-family:Arial;background:#f4f6f9;}
.box{width:400px;margin:60px auto;background:white;padding:30px;
border-radius:10px;box-shadow:0 0 10px gray;}
select{width:100%;padding:8px;margin:10px 0;}
button{padding:8px;background:#2c3e50;color:white;border:none;}
</style>
</head>
<body>

<div class="box">
<h2>Select Bus Route</h2>

<form method="post">

<select name="route" required>
<option value="">Select Route</option>

<?php
$res = mysqli_query($conn,"SELECT * FROM bus_routes");
while($row = mysqli_fetch_assoc($res)){
?>
<option value="<?php echo $row['id']; ?>">
<?php echo $row['location']; ?> - ₹ <?php echo $row['fees']; ?>
</option>
<?php } ?>

</select>

<button name="save">Save</button>

</form>
</div>
</body>
</html>
