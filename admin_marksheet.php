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
<title>All Marksheets</title>
<style>
body{font-family:Arial;background:#f4f6f9;}
.container{
width:80%;margin:60px auto;background:white;padding:30px;
border-radius:10px;box-shadow:0 0 10px gray;
}
table{width:100%;border-collapse:collapse;}
td,th{padding:8px;border:1px solid gray;text-align:center;}
th{background:#2c3e50;color:white;}
</style>
</head>

<body>
<div class="container">
<h2>All Student Marksheets</h2>

<table>
<tr>
<th>User ID</th>
<th>Semester</th>
<th>Roll</th>
<th>PDF</th>
<th>Date</th>
</tr>

<?php
$res = mysqli_query($conn,"SELECT * FROM marksheet ORDER BY upload_date DESC");
while($row = mysqli_fetch_assoc($res)){
?>
<tr>
<td><?php echo $row['userid']; ?></td>
<td><?php echo $row['semester_year']; ?></td>
<td><?php echo $row['roll_number']; ?></td>
<td>
<a href="marksheets/<?php echo $row['pdf_file']; ?>" target="_blank">
View
</a>
</td>
<td><?php echo $row['upload_date']; ?></td>
</tr>
<?php } ?>
</table>

<br>
<a href="admin.html">Back</a>
</div>
</body>
</html>
