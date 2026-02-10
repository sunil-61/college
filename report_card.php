<?php
session_start();
$conn = mysqli_connect("localhost","root","","student");

$uid = $_SESSION['userid'];

$res = mysqli_query($conn,"
SELECT SUM(marks) as total 
FROM marks 
WHERE userid='$uid'
");

$row = mysqli_fetch_assoc($res);
$total = $row['total'];

$total_max_marks = 500;  // Example: 5 subjects × 100

$percentage = 0;
$division = "";

if($total_max_marks > 0){
    $percentage = ($total / $total_max_marks) * 100;

    if($percentage >= 60){
        $division = "First Division";
    }
    elseif($percentage >= 50){
        $division = "Second Division";
    }
    else{
        $division = "Third Division";
    }
}
?>

<html>
<body>
<h2>Report Card Summary</h2>

<p>Total Marks: <?php echo $total; ?></p>
<p>Percentage: <?php echo round($percentage,2); ?>%</p>
<p>Division: <?php echo $division; ?></p>

<a href="user.php">Back</a>
</body>
</html>
