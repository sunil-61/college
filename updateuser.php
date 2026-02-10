<?php
session_start();
$conn = mysqli_connect("localhost","root","","student");

if(!isset($_SESSION['userid'])){
    header("Location: login.html");
    exit();
}

$uid = $_SESSION['userid'];

// Data fetch karna
$q = "SELECT * FROM user WHERE userid='$uid'";
$res = mysqli_query($conn,$q);
$data = mysqli_fetch_assoc($res);

// Update logic
if(isset($_POST['update'])){

    $uname  = $_POST['uname'];
    $mobile = $_POST['mobile'];
    $email  = $_POST['email'];

    // Photo update check
    if(!empty($_FILES['photo']['name'])){
        $photo = $_FILES['photo']['name'];
        $temp  = $_FILES['photo']['tmp_name'];

        move_uploaded_file($temp, "profile_photo/".$photo);

        $update = "UPDATE user SET 
                    uname='$uname',
                    mobile='$mobile',
                    email='$email',
                    photo='$photo'
                   WHERE userid='$uid'";
    }
    else{
        $update = "UPDATE user SET 
                    uname='$uname',
                    mobile='$mobile',
                    email='$email'
                   WHERE userid='$uid'";
    }

    mysqli_query($conn,$update);
    echo "<script>alert('Profile Updated Successfully'); window.location.href='user.php';</script>";
}
?>

<html>
<head>
<title>Update Profile</title>

<style>
body{
    font-family:Arial;
    background:#f4f6f9;
}
.container{
    width:40%;
    margin:50px auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}
input{
    width:100%;
    padding:8px;
    margin:10px 0;
}
button{
    padding:10px 15px;
    background:#2c3e50;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
}
button:hover{
    background:#34495e;
}
img{
    border-radius:50%;
    height:100px;
    width:100px;
    object-fit:cover;
}
</style>
</head>

<body>

<div class="container">
<h2>Update Profile</h2>

<form method="post" enctype="multipart/form-data">

<label>Name:</label>
<input type="text" name="uname" value="<?php echo $data['uname']; ?>" required>

<label>Mobile:</label>
<input type="text" name="mobile" value="<?php echo $data['mobile']; ?>" required>

<label>Email:</label>
<input type="email" name="email" value="<?php echo $data['email']; ?>" required>

<label>Current Photo:</label><br>
<img src="profile_photo/<?php echo !empty($data['photo']) ? $data['photo'] : 'default.png'; ?>"><br><br>

<label>Change Photo:</label>
<input type="file" name="photo">

<br>
<button type="submit" name="update">Update Profile</button>

</form>
</div>

</body>
</html>
