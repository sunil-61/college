<?php
session_start();
$conn = mysqli_connect("localhost","root","","student");

if(!isset($_SESSION['userid'])){
    header("Location: login.html");
    exit();
}
elseif(isset($_POST['logout'])){
    header("Location: login.html");
    exit();
}

$uid = $_SESSION['userid'];
$q = "SELECT * FROM user WHERE userid='$uid'";
$run = mysqli_query($conn, $q);
$data = mysqli_fetch_assoc($run);
?>

<html>
<head>
<title>Student Dashboard</title>

<style>
body{
    font-family: Arial;
    background:#f4f6f9;
}

.container{
    width: 75%;
    margin: 40px auto;
    position: relative;
    background:white;
    padding: 30px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

.profile-pic{
    position: absolute;
    top: 30px;
    right: 30px;
}

.profile-pic img{
    height: 140px;
    width: 140px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #2c3e50;
}

button{
    padding:10px 18px;
    margin:5px;
    border:none;
    border-radius:5px;
    cursor:pointer;
    background:#2c3e50;
    color:white;
}

button:hover{
    background:#34495e;
}

.links{
    margin-top:30px;
}
</style>

</head>

<body>

<div class="container">

<h2>Welcome, <?php echo $data['uname']; ?></h2>

<div class="profile-pic">
    <img src="profile_photo/<?php echo !empty($data['photo']) ? $data['photo'] : 'default.png'; ?>">
</div>

<table border="1" cellpadding="10" width="60%">
<tr><td>User ID</td><td><?php echo $data['userid']; ?></td></tr>
<tr><td>Mobile</td><td><?php echo $data['mobile']; ?></td></tr>
<tr><td>Email</td><td><?php echo $data['email']; ?></td></tr>
</table>

<br>

<?php
$academic = mysqli_query($conn,"
SELECT student_academic.*, course.course_name,
course.duration_type, course.total_units, course.fees_per_unit
FROM student_academic
JOIN course ON student_academic.course_id = course.id
WHERE student_academic.userid='$uid'
");

$acad = mysqli_fetch_assoc($academic);

if(!$acad){
    echo "<br><button onclick=\"window.location.href='academic_setup.php'\">Setup Academic Info</button>";
}
?>

<?php if($acad){ ?>

<hr>
<h3>Academic Information</h3>

<table border="1" cellpadding="10" width="60%">
<tr><td>Course</td><td><?php echo $acad['course_name']; ?></td></tr>
<tr><td>Duration</td><td><?php echo $acad['duration_type']; ?></td></tr>
<tr><td>Current <?php echo $acad['duration_type']; ?></td>
<td><?php echo $acad['current_unit']; ?></td></tr>
<tr><td>Roll Number</td><td><?php echo $acad['roll_number']; ?></td></tr>
<tr><td>NCC</td><td><?php echo $acad['ncc']; ?></td></tr>
</table>

<button onclick="window.location.href='update_academic.php'">
Update Academic Info
</button>


<hr>
<h3>Attendance</h3>

<?php
$total = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as total 
FROM attendance 
WHERE userid='$uid'
"));

$present = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as total 
FROM attendance 
WHERE userid='$uid' AND status='Present'
"));

$totalDays = $total['total'];
$presentDays = $present['total'];

$percentage = 0;

if($totalDays > 0){
    $percentage = ($presentDays / $totalDays) * 100;
}
?>

<table border="1" cellpadding="10" width="60%">
<tr><td>Total Classes</td><td><?php echo $totalDays; ?></td></tr>
<tr><td>Present</td><td><?php echo $presentDays; ?></td></tr>
<tr><td>Attendance %</td><td><?php echo round($percentage,2); ?>%</td></tr>
</table>

<br>

<h3>Fees Details</h3>

<?php
$total = $acad['fees_per_unit'] * $acad['total_units'];
$current = $acad['fees_per_unit'];
?>

<table border="1" cellpadding="10" width="60%">
<tr><td>Fees Per <?php echo $acad['duration_type']; ?></td>
<td>₹ <?php echo $current; ?></td></tr>

<tr><td>Total Course Fees</td>
<td>₹ <?php echo $total; ?></td></tr>
</table>

<br>

<a href="syllabus/<?php echo $acad['course_name']; ?>.pdf" target="_blank">
<button>View Syllabus</button>
</a>

<?php } ?>

<?php
$bus = mysqli_query($conn,"
SELECT bus_routes.location, bus_routes.fees
FROM student_bus
JOIN bus_routes ON student_bus.route_id = bus_routes.id
WHERE student_bus.userid='$uid'
");

$busData = mysqli_fetch_assoc($bus);

if(!$busData){
    echo "<br><button onclick=\"window.location.href='bus_select.php'\">Select Bus</button>";
}
?>

<?php if($busData){ ?>

<hr>
<h3>Bus Details</h3>

<table border="1" cellpadding="10" width="60%">
<tr><td>Route</td><td><?php echo $busData['location']; ?></td></tr>
<tr><td>Bus Fees</td><td>₹ <?php echo $busData['fees']; ?></td></tr>
</table>

<?php } ?>

<hr>
<h3>Previous Marksheet History</h3>

<table border="1" cellpadding="10" width="70%">
<tr>
<th>Semester/Year</th>
<th>Roll Number</th>
<th>PDF</th>
<th>Date</th>
</tr>

<?php
$ms = mysqli_query($conn,"
SELECT * FROM marksheet
WHERE userid='$uid'
ORDER BY semester_year ASC
");

while($row = mysqli_fetch_assoc($ms)){
?>
<tr>
<td><?php echo $row['semester_year']; ?></td>
<td><?php echo $row['roll_number']; ?></td>
<td>
<a href="marksheets/<?php echo $row['pdf_file']; ?>" target="_blank">
View PDF
</a>
</td>
<td><?php echo $row['upload_date']; ?></td>
</tr>
<?php } ?>
</table>

<br>
<button onclick="window.location.href='upload_marksheet.php'">
Upload New Marksheet
</button>




<form method="post">
    <button name="logout">Logout</button>
</form>

<?php
if(isset($_POST['logout'])){
    session_destroy();
    header("Location: login.html");
}
?>

<hr>

<h3>University Services</h3>

<div class="links">
    <a href="https://mlsuresults.sumsraj.com/" target="_blank">
        <button>Check Result</button>
    </a>

    <a href="https://mlsuexamination.sumsraj.com/default.aspx" target="_blank">
        <button>Download Admit Card</button>
    </a>

    <a href="https://mlsu.ac.in/Examination-Time-table" target="_blank">
        <button>View Time Table</button>
    </a>

    <a href="https://mlsu.ac.in/News" target="_blank">
        <button>Latest Notices</button>
    </a>
</div>

<hr>

<h3>Extra Student Tools</h3>

<button onclick="window.location.href='updateuser.php'">Update Profile</button>
<button onclick="window.location.href='change_password.php'">Change Password</button>
<button onclick="window.location.href='upload_photo.php'">Upload New Photo</button>
<button onclick="window.location.href='book_bank.php'">Book Bank</button>
<button onclick="window.location.href='pay_fees.php'">Pay Fees</button>
<button onclick="window.location.href='report_card.php'">View Report Card</button>
<button onclick="window.location.href='complaint.php'">Submit Complaint</button>
<button onclick="window.location.href='feedback.php'">Give Feedback</button>
<button onclick="window.location.href='generate_certificate.php'">Final Certificate</button>

</div>

</body>
</html>
