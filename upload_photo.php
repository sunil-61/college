<?php
session_start();
$conn = mysqli_connect("localhost","root","","student");

if(!isset($_SESSION['userid'])){
    header("Location: login.html");
    exit();
}

$uid = $_SESSION['userid'];
$msg = "";

if(isset($_POST['upload'])){

    if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0){

        $file_name = $_FILES['photo']['name'];
        $file_tmp  = $_FILES['photo']['tmp_name'];
        $file_size = $_FILES['photo']['size'];

        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed = array("jpg","jpeg","png","gif");

        if(in_array($ext, $allowed)){

            if($file_size < 2*1024*1024){ 

                $new_name = time().".".$ext;

                move_uploaded_file($file_tmp, "profile_photo/".$new_name);

                $update = "UPDATE user SET photo='$new_name' WHERE userid='$uid'";
                mysqli_query($conn,$update);

                $msg = "Photo Uploaded Successfully";

            } else {
                $msg = "File size must be less than 2MB";
            }

        } else {
            $msg = "Only JPG, JPEG, PNG, GIF allowed";
        }

    } else {
        $msg = "Please select a photo";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Upload Profile Photo</title>
<style>
body{
    font-family: Arial;
    background:#f2f2f2;
}
.box{
    width:400px;
    margin:80px auto;
    padding:30px;
    background:white;
    border-radius:10px;
    box-shadow:0 0 10px gray;
    text-align:center;
}
input{
    margin:15px 0;
}
button{
    padding:10px 20px;
    background:darkblue;
    color:white;
    border:none;
    cursor:pointer;
}
button:hover{
    background:navy;
}
.msg{
    color:red;
}
</style>
</head>

<body>

<div class="box">
<h2>Upload Profile Photo</h2>

<p class="msg"><?php echo $msg; ?></p>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="photo" required><br>
    <button type="submit" name="upload">Upload Photo</button>
</form>

<br>
<a href="user.php">Back to Profile</a>

</div>

</body>
</html>
