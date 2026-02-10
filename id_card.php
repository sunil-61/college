<?php
session_start();
$conn = mysqli_connect("localhost","root","","student");

$uid = $_SESSION['userid'];

$q = mysqli_query($conn,"
SELECT user.uname, user.photo, student_academic.roll_number
FROM user
JOIN student_academic ON user.userid = student_academic.userid
WHERE user.userid='$uid'
");

$data = mysqli_fetch_assoc($q);
?>

<html>
<head>
<title>ID Card</title>
<style>
.card{
width:350px;
border:2px solid black;
padding:20px;
text-align:center;
margin:50px auto;
}
img{
width:100px;
height:100px;
border-radius:50%;
}
</style>
</head>
<body>

<div class="card">
<h3>University ID Card</h3>

<img src="profile_photo/<?php echo $data['photo']; ?>"><br><br>

Name: <?php echo $data['uname']; ?><br>
Roll No: <?php echo $data['roll_number']; ?><br>
User ID: <?php echo $uid; ?><br>

<br>
<button onclick="window.print()">Print</button>
</div>

</body>
</html>
