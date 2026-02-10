<?php
session_start();
$conn = mysqli_connect("localhost","root","","student");

if(!isset($_SESSION['userid'])){
    header("Location: login.html");
    exit();
}

$uid = $_SESSION['userid'];

$q = "SELECT uname FROM user WHERE userid='$uid'";
$res = mysqli_query($conn,$q);
$data = mysqli_fetch_assoc($res);
$uname = $data['uname'];

$msg = "";

if(isset($_POST['submit'])){

    $message = $_POST['message'];
    date_default_timezone_set("Asia/Kolkata");
    $date_time = date("Y-m-d H:i:s");

    $insert = "INSERT INTO complaint (userid, uname, message, date_time)
               VALUES ('$uid', '$uname', '$message', '$date_time')";
    
    mysqli_query($conn,$insert);

    $msg = "Complaint Submitted Successfully";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Submit Complaint</title>
<style>
body{font-family:Arial;background:#f2f2f2;}
.box{
    width:400px;
    margin:80px auto;
    padding:30px;
    background:white;
    border-radius:10px;
    box-shadow:0 0 10px gray;
}
textarea{
    width:100%;
    height:100px;
}
button{
    padding:10px 20px;
    background:darkred;
    color:white;
    border:none;
    cursor:pointer;
}
.msg{color:green;}
</style>
</head>
<body>

<div class="box">
<h2>Submit Complaint</h2>

<p class="msg"><?php echo $msg; ?></p>

<form method="post">
    <textarea name="message" placeholder="Write your complaint here..." required></textarea>
    <br><br>
    <button type="submit" name="submit">Submit</button>
</form>

<br>
<a href="user.php">Back to Dashboard</a>
</div>

</body>
</html>
