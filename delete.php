<?php
session_start();
$conn = mysqli_connect("localhost","root","","student");

if(!isset($_SESSION['userid']) || $_SESSION['userid'] != "admin"){
    header("Location: login.html");
    exit();
}

$data = null;
$back = "admin.html";

/* =========================
   Back Button Logic
   ========================= */
if(isset($_GET['from']) && $_GET['from'] == "view"){
    $back = "view.php";
}

/* =========================
   Direct Delete from view.php
   ========================= */
if(isset($_GET['userid'])){

    $gid = $_GET['userid'];

    if($gid != "admin"){

        mysqli_query($conn,"DELETE FROM user WHERE userid='$gid'");

        echo "<script>alert('User Deleted Successfully'); window.location.href='view.php';</script>";
        exit();

    } else {
        echo "<h3 style='color:red;text-align:center;'>Admin account cannot be deleted!</h3>";
    }
}

/* =========================
   Search User
   ========================= */
if(isset($_POST['search'])){

    $gid = $_POST['userid'];

    if($gid != "admin"){
        $sel = "SELECT * FROM user WHERE userid='$gid'";
        $run = mysqli_query($conn,$sel);
        $data = mysqli_fetch_assoc($run);
    } else {
        echo "<h3 style='color:red;text-align:center;'>Admin record cannot be deleted!</h3>";
    }
}

/* =========================
   Delete After Confirm
   ========================= */
if(isset($_POST['delete'])){

    $gid = $_POST['hid'];

    if($gid != "admin"){

        mysqli_query($conn,"DELETE FROM user WHERE userid='$gid'");

        echo "<script>alert('User Deleted Successfully'); window.location.href='view.php';</script>";
        exit();

    } else {
        echo "<h3 style='color:red;text-align:center;'>Admin account cannot be deleted!</h3>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Delete User</title>

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

.delete-btn{
    background:red;
}

.delete-btn:hover{
    background:darkred;
}

h2{
    text-align:center;
}
</style>

</head>

<body>

<div class="container">

<h2>Delete User Record</h2>

<!-- Search Form -->
<form method="POST">
    <input type="text" name="userid" placeholder="Enter User ID to delete">
    <button type="submit" name="search">Search</button>
</form>

<br>

<?php if($data){ ?>

<form method="POST">
<input type="hidden" name="hid" value="<?php echo $data['userid']; ?>">

<label>User ID</label>
<input type="text" value="<?php echo $data['userid']; ?>" disabled>

<label>User Name</label>
<input type="text" value="<?php echo $data['uname']; ?>" disabled>

<label>Email</label>
<input type="text" value="<?php echo $data['email']; ?>" disabled>

<br>
<button type="submit" name="delete" class="delete-btn"
        onclick="return confirm('Are you sure you want to delete this user?')">
        Delete User
</button>

<button type="button" onclick="window.location.href='<?php echo $back; ?>'">
    Back
</button>
</form>

<?php } ?>

</div>

</body>
</html>
