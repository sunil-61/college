<?php
session_start();
$conn = mysqli_connect("localhost","root","","student");

if(!isset($_SESSION['userid'])){
    header("Location: login.html");
    exit();
}

$uid = $_SESSION['userid'];

/* Academic Info */
$academic = mysqli_query($conn,"
SELECT student_academic.*, course.total_units
FROM student_academic
JOIN course ON student_academic.course_id = course.id
WHERE student_academic.userid='$uid'
");

$acad = mysqli_fetch_assoc($academic);

if(!$acad){
    echo "<h3>Academic info not found!</h3>";
    exit();
}

/* Check Fees */
$feesPaid = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) as total 
FROM student_fees 
WHERE userid='$uid'
")
);

/* Check Marksheet */
$marks = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) as total 
FROM marksheet 
WHERE userid='$uid'
")
);

$eligible = false;

if($feesPaid['total'] == $acad['total_units'] &&
   $marks['total'] == $acad['total_units']){
    $eligible = true;
}

/* Generate Certificate */
if(isset($_POST['generate']) && $eligible){

    date_default_timezone_set("Asia/Kolkata");
    $date = date("Y-m-d H:i:s");

    mysqli_query($conn,"
    INSERT INTO certificate (userid,issue_date)
    VALUES ('$uid','$date')
    ");

    echo "<script>
    alert('Certificate Generated');
    window.location.href='generate_certificate.php';
    </script>";
}
?>

<html>
<head>
<title>Final Certificate</title>
<style>
body{font-family:Arial;background:#f4f6f9;}
.box{
width:600px;margin:60px auto;background:white;padding:40px;
border-radius:10px;box-shadow:0 0 10px gray;text-align:center;
}
button{padding:10px 20px;background:#2c3e50;color:white;border:none;}
</style>
</head>

<body>

<div class="box">

<h2>Final Course Completion Certificate</h2>

<?php if($eligible){ ?>

<form method="post">
<button name="generate">Generate Certificate</button>
</form>

<?php } else { ?>

<p style="color:red;">
Complete all Fees Payments & Marksheet Uploads to Generate Certificate
</p>

<?php } ?>

<br>
<a href="user.php">Back</a>

</div>

</body>
</html>
