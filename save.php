<?php
$conn = mysqli_connect('localhost','root','','student');

if(isset($_POST['save'])) {

    $userid = $_POST['userid'];
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $p = $_FILES['photo']['name'];
    $tn = $_FILES['photo']['tmp_name'];
    $t = "profile_photo/".basename($p);

    $sql = "INSERT INTO `user` (userid, uname, pass, mobile, email, photo) VALUES ('$userid', '$uname', '$pass', '$mobile', '$email', '$p')";
    $res = mysqli_query($conn, $sql);

    if($res) {
        if(move_uploaded_file($tn,$t) && mysqli_query($conn,$sql)){
            echo "<script>alert('Moved Succesfully')</script>";
        }
        header("Location: login.html");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
