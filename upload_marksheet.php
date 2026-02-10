<?php
session_start();
$conn = mysqli_connect("localhost","root","","student");

if(!isset($_SESSION['userid'])){
    header("Location: login.html");
    exit();
}

$uid = $_SESSION['userid'];

if(isset($_POST['upload'])){

    $sem = $_POST['semester'];
    $roll = $_POST['roll'];

    $file = $_FILES['pdf']['name'];
    $tmp = $_FILES['pdf']['tmp_name'];
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    if($ext == "pdf"){

        $newname = time()."_".$file;
        move_uploaded_file($tmp,"marksheets/".$newname);

        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d H:i:s");

        mysqli_query($conn,"
        INSERT INTO marksheet
        (userid,semester_year,roll_number,pdf_file,upload_date)
        VALUES
        ('$uid','$sem','$roll','$newname','$date')
        ");

        echo "<script>alert('Marksheet Uploaded');
        window.location.href='upload_marksheet.php';</script>";

    } else {
        echo "<script>alert('Only PDF allowed');</script>";
    }
}
?>

<html>
<head>
<title>Upload Marksheet</title>
<style>
body{font-family:Arial;background:#f4f6f9;}
.box{
width:400px;margin:60px auto;background:white;padding:30px;
border-radius:10px;box-shadow:0 0 10px gray;
}
input{width:100%;padding:8px;margin:8px 0;}
button{padding:8px;background:#2c3e50;color:white;border:none;}
</style>
</head>

<body>
<div class="box">
<h2>Upload Marksheet</h2>

<form method="post" enctype="multipart/form-data">

<input type="number" name="semester"
placeholder="Semester/Year Number" required>

<input type="text" name="roll"
placeholder="Roll Number" required>

<input type="file" name="pdf" required>

<button name="upload">Upload</button>

</form>

<br>
<a href="user.php">Back</a>
</div>
</body>
</html>
