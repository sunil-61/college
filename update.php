<?php
session_start();
$conn = mysqli_connect("localhost","root","","student");

if(!isset($_SESSION['userid']) || $_SESSION['userid'] != "admin"){
    header("Location: login.html");
    exit();
}

$data = null;

/* =========================
   1️⃣ Agar view.php se aaye
   ========================= */
if(isset($_GET['userid'])){

    $gid = $_GET['userid'];

    if($gid != "admin"){
        $sel = "SELECT * FROM user WHERE userid='$gid'";
        $run = mysqli_query($conn,$sel);
        $data = mysqli_fetch_assoc($run);
    }
}

/* =========================
   2️⃣ Search button se aaye
   ========================= */
if(isset($_POST['search'])){
    $gid = $_POST['userid'];

    if($gid != "admin"){
        $sel = "SELECT * FROM user WHERE userid='$gid'";
        $run = mysqli_query($conn,$sel);
        $data = mysqli_fetch_assoc($run);
    } else {
        echo "<h3 style='color:red;text-align:center;'>Admin record cannot be modified!</h3>";
    }
}

/* =========================
   3️⃣ Update Record
   ========================= */
if(isset($_POST['update'])){

    $gid    = $_POST['hid'];
    $uname  = $_POST['uname'];
    $pass   = $_POST['pass'];
    $mobile = $_POST['mobile'];
    $email  = $_POST['email'];

    if($gid != "admin"){

        $upd = "UPDATE user SET 
                uname='$uname',
                pass='$pass',
                mobile='$mobile',
                email='$email'
                WHERE userid='$gid'";

        mysqli_query($conn,$upd);

        echo "<script>alert('Record Updated Successfully'); window.location.href='view.php';</script>";
        exit();

    } else {
        echo "<h3 style='color:red;text-align:center;'>Admin record cannot be changed!</h3>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Update User</title>

<style>
body{
    font-family:Arial;
    background:#f4f6f9;
}

.container{
    width:40%;
    margin:60px auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 0 15px rgba(0,0,0,0.1);
}

input{
    width:100%;
    padding:8px;
    margin:8px 0;
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

h2{
    text-align:center;
}
</style>
</head>

<body>

<div class="container">

<h2>Update User Record</h2>

<!-- Search Box (Optional) -->
<form method="POST">
    <input type="text" name="userid" placeholder="Search User ID">
    <button type="submit" name="search">Search</button>
</form>

<br>

<?php if($data){ ?>

<form method="POST">
<input type="hidden" name="hid" value="<?php echo $data['userid']; ?>">

<label>User ID</label>
<input type="text" value="<?php echo $data['userid']; ?>" disabled>

<label>User Name</label>
<input type="text" name="uname" value="<?php echo $data['uname']; ?>" required>

<label>Password</label>
<input type="text" name="pass" value="<?php echo $data['pass']; ?>" required>

<label>Mobile</label>
<input type="text" name="mobile" value="<?php echo $data['mobile']; ?>" required>

<label>Email</label>
<input type="email" name="email" value="<?php echo $data['email']; ?>" required>

<br>
<button type="submit" name="update">Update Record</button>
<button type="button" onclick="window.location.href='view.php'">Back</button>

</form>

<?php } ?>

</div>

</body>
</html>
