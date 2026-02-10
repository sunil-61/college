<?php
session_start();
$conn = mysqli_connect("localhost","root","","student");

if(!isset($_SESSION['userid'])){
    header("Location: login.html");
    exit();
}

$uid = $_SESSION['userid'];

/* Fetch Current Academic Info */
$res = mysqli_query($conn,"
SELECT * FROM student_academic 
WHERE userid='$uid'
");

$data = mysqli_fetch_assoc($res);

/* Update Academic Info */
if(isset($_POST['update'])){

    $course = $_POST['course'];
    $unit   = $_POST['unit'];
    $roll   = $_POST['roll'];
    $ncc    = $_POST['ncc'];

    mysqli_query($conn,"
    UPDATE student_academic SET
    course_id='$course',
    current_unit='$unit',
    roll_number='$roll',
    ncc='$ncc'
    WHERE userid='$uid'
    ");

    echo "<script>
    alert('Academic Information Updated');
    window.location.href='user.php';
    </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Update Academic Info</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container mt-5">

<h3 class="text-center">Update Academic Information</h3>

<div class="card p-4 shadow">

<form method="post">

<label>Course</label>
<select name="course" class="form-control" required>

<?php
$courses = mysqli_query($conn,"SELECT * FROM course");
while($row = mysqli_fetch_assoc($courses)){
    $selected = ($row['id'] == $data['course_id']) ? "selected" : "";
    echo "<option value='".$row['id']."' $selected>".$row['course_name']."</option>";
}
?>

</select>

<br>

<label>Current Semester/Year</label>
<input type="number" name="unit" 
class="form-control"
value="<?php echo $data['current_unit']; ?>" required>

<br>

<label>Roll Number</label>
<input type="text" name="roll"
class="form-control"
value="<?php echo $data['roll_number']; ?>" required>

<br>

<label>NCC</label>
<select name="ncc" class="form-control">
<option value="No" <?php if($data['ncc']=="No") echo "selected"; ?>>No</option>
<option value="Yes" <?php if($data['ncc']=="Yes") echo "selected"; ?>>Yes</option>
</select>

<br>

<button name="update" class="btn btn-primary">
Update
</button>

<a href="user.php" class="btn btn-secondary">
Back
</a>

</form>

</div>
</div>

</body>
</html>
