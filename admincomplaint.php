<?php
session_start();
$conn = mysqli_connect("localhost","root","","student");

if(!isset($_SESSION['userid']) || $_SESSION['userid'] != "admin"){
    header("Location: login.html");
    exit();
}

$q = "SELECT * FROM complaint ORDER BY id DESC";
$res = mysqli_query($conn,$q);
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Complaint Panel</title>
<style>
body{font-family:Arial;background:#f4f6f9;}
.container{
    width:80%;
    margin:50px auto;
}
table{
    width:100%;
    border-collapse:collapse;
}
th,td{
    padding:10px;
    border:1px solid gray;
}
th{
    background:#2c3e50;
    color:white;
}
</style>
</head>
<body>

<div class="container">
<h2>All Student Complaints</h2>

<table>
<tr>
    <th>ID</th>
    <th>User ID</th>
    <th>Name</th>
    <th>Complaint</th>
    <th>Date & Time</th>
</tr>

<?php
while($row = mysqli_fetch_assoc($res)){
?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td>
    <a href="admin_view_user.php?userid=<?php echo $row['userid']; ?>">
        <?php echo $row['userid']; ?>
    </a>
    </td>
    <td><?php echo $row['uname']; ?></td>
    <td><?php echo $row['message']; ?></td>
    <td><?php echo $row['date_time']; ?></td>
</tr>
<?php } ?>

</table>

<br>
<a href="admin.html">Back to Admin Panel</a>

</div>

</body>
</html>
