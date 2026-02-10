<?php
session_start();
$conn = mysqli_connect("localhost","root","","student");

if(!isset($_SESSION['userid'])){
    header("Location: login.html");
    exit();
}

$uid = $_SESSION['userid'];

if(isset($_POST['save'])){

    $course_id = $_POST['course'];
    $unit = $_POST['unit'];
    $roll = $_POST['roll'];
    $ncc = $_POST['ncc'];

    mysqli_query($conn,"
        INSERT INTO student_academic 
        (userid, course_id, current_unit, roll_number, ncc)
        VALUES
        ('$uid','$course_id','$unit','$roll','$ncc')
    ");

    echo "<script>alert('Academic Details Saved'); window.location.href='user.php';</script>";
}
?>

<html>
<head>
<title>Academic Setup</title>
<style>
body{font-family:Arial;background:#f4f6f9;}
.box{
width:400px;margin:60px auto;background:white;padding:30px;
border-radius:10px;box-shadow:0 0 10px gray;
}
input,select{width:100%;padding:8px;margin:8px 0;}
button{padding:10px;background:#2c3e50;color:white;border:none;}
</style>
</head>

<body>
<div class="box">
<h2>Setup Academic Info</h2>

<form method="post">

<select name="course" required>
<option value="">Select Course</option>

<?php
$c = mysqli_query($conn,"SELECT * FROM course");
while($row = mysqli_fetch_assoc($c)){
?>
<option value="<?php echo $row['id']; ?>">
<?php echo $row['course_name']; ?>
</option>
<?php } ?>
</select>

<input type="number" name="unit" placeholder="Current Semester/Year" required>

<input type="text" name="roll" placeholder="Roll Number" required>

<select name="ncc">
<option value="No">NCC - No</option>
<option value="Yes">NCC - Yes</option>
</select>

<button name="save">Save</button>

</form>
</div>
</body>
</html>
