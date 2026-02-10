<?php
session_start();
$conn = mysqli_connect("localhost","root","","student");

if(!isset($_SESSION['userid']) || $_SESSION['userid'] != "admin"){
    header("Location: login.html");
    exit();
}

if(!isset($_GET['userid'])){
    echo "User not found";
    exit();
}

$uid = $_GET['userid'];

$q = "SELECT * FROM user WHERE userid='$uid'";
$res = mysqli_query($conn,$q);
$data = mysqli_fetch_assoc($res);

if(!$data){
    echo "No user found";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>User Profile</title>
<style>
body{font-family:Arial;background:#f2f2f2;}
.container{
    width:50%;
    margin:60px auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 0 10px gray;
}
img{
    height:150px;
    width:150px;
    border-radius:50%;
    object-fit:cover;
}
table{
    width:100%;
    margin-top:20px;
}
td{
    padding:8px;
}
</style>
</head>
<body>

<div class="container">

<h2>User Full Profile</h2>

<center>
<img src="profile_photo/<?php echo !empty($data['photo']) ? $data['photo'] : 'default.png'; ?>">
</center>

<table border="1">
<tr><td>User ID</td><td><?php echo $data['userid']; ?></td></tr>
<tr><td>Name</td><td><?php echo $data['uname']; ?></td></tr>
<tr><td>Mobile</td><td><?php echo $data['mobile']; ?></td></tr>
<tr><td>Email</td><td><?php echo $data['email']; ?></td></tr>
</table>

<br>
<a href="admin.html">Back to Admin</a><br>
<a href="library_page.php">Back to Library</a>

</div>

</body>
</html>
