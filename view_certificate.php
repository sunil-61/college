<?php
session_start();
$conn = mysqli_connect("localhost","root","","student");

if(!isset($_SESSION['userid'])){
    header("Location: login.html");
    exit();
}

$uid = $_SESSION['userid'];

$q = mysqli_query($conn,"
SELECT * FROM certificate WHERE userid='$uid'
");

$data = mysqli_fetch_assoc($q);

if(!$data){
    echo "Certificate Not Generated";
    exit();
}
?>

<html>
<head>
<title>Certificate</title>
<style>
body{font-family:Georgia;text-align:center;margin-top:100px;}
.certificate{
border:5px solid black;
padding:50px;
width:70%;
margin:auto;
}
button{margin-top:20px;padding:8px 15px;}
</style>
</head>

<body>

<div class="certificate">

<h1>Course Completion Certificate</h1>

<p>This is to certify that</p>

<h2><?php echo $_SESSION['userid']; ?></h2>

<p>has successfully completed the course.</p>

<p>Issue Date: <?php echo $data['issue_date']; ?></p>

<br>

<img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http://localhost/student/verify.php?id=<?php echo $data['id']; ?>">

<a href="certificate_pdf.php?id=<?php echo $data['id']; ?>">Download PDF</a>


<button onclick="window.print()">Print Certificate</button>

</div>

</body>
</html>
