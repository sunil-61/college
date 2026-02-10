<?php
session_start();
$conn = mysqli_connect("localhost","root","","student");

if(!isset($_SESSION['userid']) || $_SESSION['userid'] != "admin"){
    header("Location: login.html");
    exit();
}
?>

<html>
<head>
<title>Book Bank Students</title>
<style>
body{font-family:Arial;background:#f4f6f9;}
.container{
width:70%;margin:60px auto;background:white;padding:30px;
border-radius:10px;box-shadow:0 0 10px gray;
}
table{width:100%;border-collapse:collapse;}
td,th{padding:8px;border:1px solid gray;text-align:center;}
th{background:#2c3e50;color:white;}
</style>
</head>

<body>
<div class="container">
<h2>Book Bank Students</h2>

<table>
<tr>
<th>User ID</th>
<th>Years</th>
<th>Status</th>
</tr>

<?php
$res = mysqli_query($conn,"SELECT * FROM book_bank");
while($row = mysqli_fetch_assoc($res)){
$status = ($row['year_count']>=3) ?
"Eligible for Refund" : "Active";
?>
<tr>
<td><?php echo $row['userid']; ?></td>
<td><?php echo $row['year_count']; ?></td>
<td><?php echo $status; ?></td>
</tr>
<?php } ?>
</table>

<br>
<a href="admin.html">Back</a>
</div>
</body>
</html>
