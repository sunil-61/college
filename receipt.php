<?php
session_start();
$conn = mysqli_connect("localhost","root","","student");

if(!isset($_SESSION['userid'])){
    header("Location: login.html");
    exit();
}

if(!isset($_GET['id'])){
    echo "Invalid Receipt";
    exit();
}

$id = $_GET['id'];

$q = mysqli_query($conn,"
SELECT * FROM student_fees WHERE id='$id'
");

$data = mysqli_fetch_assoc($q);

if(!$data){
    echo "Receipt Not Found";
    exit();
}
?>

<html>
<head>
<title>Fee Receipt</title>
<style>
body{font-family:Arial;background:#f4f6f9;}
.box{
width:500px;margin:60px auto;background:white;padding:30px;
border-radius:10px;box-shadow:0 0 10px gray;
}
h2{text-align:center;}
table{width:100%;margin-top:20px;}
td{padding:8px;}
button{padding:8px;background:#2c3e50;color:white;border:none;}
</style>
</head>

<body>

<div class="box">

<h2>Fee Receipt</h2>

<table border="1">
<tr>
<td>Receipt ID</td>
<td><?php echo $data['id']; ?></td>
</tr>

<tr>
<td>User ID</td>
<td><?php echo $data['userid']; ?></td>
</tr>

<tr>
<td>Unit (Semester/Year)</td>
<td><?php echo $data['unit_number']; ?></td>
</tr>

<tr>
<td>Amount Paid</td>
<td>₹ <?php echo $data['amount']; ?></td>
</tr>

<tr>
<td>Payment Date</td>
<td><?php echo $data['payment_date']; ?></td>
</tr>
</table>

<br>

<center>
<button onclick="window.print()">Print / Save as PDF</button>
</center>

</div>

</body>
</html>
