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

        if($userid == "library" && $pass == "12345678") {  
            header("Location: library_page.php");
            exit();
        }
        elseif($userid == "admin" && $pass == "27591684") {
            header("Location: library_page.php");
            exit();
        } 
        else {
            header("Location: library.html");
            exit();
        }

    } 
    else {     
        echo "<script>alert('Invalid Library ID and password!'); window.location='library.html';</script>";
    }
}
?>

