<?php

$conn = mysqli_connect("localhost","root","","student");

$query = "SELECT * FROM staff WHERE type='Teaching'";
$result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Teaching Staff</title>
<style>
body{
    font-family: Arial;
    background:#f4f4f4;
}
.staff-box{
    width:80%;
    margin:20px auto;
    background:white;
    padding:20px;
    box-shadow:0px 0px 10px gray;
    display:flex;
}
.staff-box img{
    width:150px;
    height:180px;
    margin-right:20px;
}
table{
    width:100%;
}
td{
    padding:5px;
}
.title{
    text-align:center;
    font-size:25px;
    font-weight:bold;
}
</style>
</head>

<body>

<div class="title">TEACHING STAFF</div>

<?php
while($row=mysqli_fetch_assoc($result)){
?>

<div class="staff-box">
    <img src="staff_images/<?php echo $row['photo']; ?>">
    <table>
        <tr><td><b>Name</b></td><td><?php echo $row['name']; ?></td></tr>
        <tr><td><b>DOB</b></td><td><?php echo $row['dob']; ?></td></tr>
        <tr><td><b>Father Name</b></td><td><?php echo $row['father_name']; ?></td></tr>
        <tr><td><b>Mother Name</b></td><td><?php echo $row['mother_name']; ?></td></tr>
        <tr><td><b>Designation</b></td><td><?php echo $row['designation']; ?></td></tr>
        <tr><td><b>Qualification</b></td><td><?php echo $row['qualification']; ?></td></tr>
        <tr><td><b>Contact</b></td><td><?php echo $row['contact']; ?></td></tr>
        <tr><td><b>Email</b></td><td><?php echo $row['email']; ?></td></tr>
        <tr><td><b>PAN</b></td><td><?php echo $row['pan']; ?></td></tr>
        <tr><td><b>Joining Date</b></td><td><?php echo $row['joining_date']; ?></td></tr>
    </table>
</div>

<?php } ?>

</body>
</html>
