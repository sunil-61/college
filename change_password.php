<?php
session_start();
$conn = mysqli_connect("localhost","root","","student");

if(!isset($_SESSION['userid'])){
    header("Location: login.html");
    exit();
}

$uid = $_SESSION['userid'];

if(isset($_POST['change'])){

    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];

    $q = "SELECT pass FROM user WHERE userid='$uid'";
    $res = mysqli_query($conn,$q);
    $data = mysqli_fetch_assoc($res);

    if($old_pass == $data['pass']){

        if($new_pass == $confirm_pass){

            $update = "UPDATE user SET pass='$new_pass' WHERE userid='$uid'";
            mysqli_query($conn,$update);

            echo "<script>alert('Password Changed Successfully'); window.location.href='user.php';</script>";

        } else {
            echo "<script>alert('New Password and Confirm Password do not match');</script>";
        }

    } else {
        echo "<script>alert('Old Password Incorrect');</script>";
    }
}
?>

<html>
<head>
<title>Change Password</title>
<style>
body{
    font-family: Arial;
    background: #f2f2f2;
}
.box{
    width: 400px;
    margin: 80px auto;
    padding: 30px;
    background: white;
    border-radius: 10px;
    box-shadow: 0px 0px 10px gray;
}
input{
    width: 100%;
    padding: 8px;
    margin: 10px 0;
}
button{
    padding: 10px;
    width: 100%;
    background: darkblue;
    color: white;
    border: none;
    cursor: pointer;
}
button:hover{
    background: navy;
}
.msg{
    color: red;
    text-align: center;
}
</style>
</head>

<body>

<div class="box">
<h2>Change Password</h2>

<p class="msg"><?php echo $msg; ?></p>

<form method="post">
    <input type="password" name="old_pass" placeholder="Enter Old Password" required>
    <input type="password" name="new_pass" placeholder="Enter New Password" required>
    <input type="password" name="confirm_pass" placeholder="Confirm New Password" required>

    <button type="submit" name="change">Change Password</button>
</form>

</div>

</body>
</html>
