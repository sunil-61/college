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
<title>All Student Fees</title>
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
<h2>All Student Fees</h2>

<table>
<tr>
<th>User ID</th>
<th>Unit</th>
<th>Amount</th>
<th>Date</th>
<th>Receipt</th>
</tr>

<?php
$res = mysqli_query($conn,"
SELECT * FROM student_fees
ORDER BY payment_date DESC
");

while($row = mysqli_fetch_assoc($res)){
?>
<tr>
<td><?php echo $row['userid']; ?></td>
<td><?php echo $row['unit_number']; ?></td>
<td>₹ <?php echo $row['amount']; ?></td>
<td><?php echo $row['payment_date']; ?></td>
<td>
<a href="receipt.php?id=<?php echo $row['id']; ?>" target="_blank">
View
</a>
</td>
</tr>


<?php } ?>
</table>

<br>
<a href="admin.html">Back</a>
</div>
</body>
</html>
