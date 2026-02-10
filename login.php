<?php
session_start();  

$conn = mysqli_connect('localhost','root','','student');
$userid = $_POST['userid'];
$pass = $_POST['pass'];

if(isset($_POST['submit'])) {

    $qry = "SELECT * FROM user WHERE userid='$userid' AND pass='$pass'";
    $res = mysqli_query($conn, $qry);

    if(mysqli_num_rows($res) > 0) {

        $_SESSION['userid'] = $userid;  

        if($userid == "admin" && $pass == "27591684") {  
            header("Location: admin.html");
            exit();
        } else {
            header("Location: user.php");
            exit();
        }

    } 
    else {     
        echo "<script>alert('Invalid user id and password!'); window.location='login.html';</script>";
    }
}
?>
