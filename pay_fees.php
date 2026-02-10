<?php
session_start();
$conn = mysqli_connect("localhost","root","","student");

if(!isset($_SESSION['userid'])){
    header("Location: login.html");
    exit();
}




$uid = $_SESSION['userid'];

/* Get Course Fees Info */
$academic = mysqli_query($conn,"
SELECT student_academic.*, course.fees_per_unit,
course.total_units, course.duration_type
FROM student_academic
JOIN course ON student_academic.course_id = course.id
WHERE student_academic.userid='$uid'
");

$acad = mysqli_fetch_assoc($academic);

if(!$acad){
    echo "<h3>Please Setup Academic Info First</h3>";
    exit();
}

/* Pay Fees */
if(isset($_POST['pay'])){

    $unit = $_POST['unit'];
    $amount = $acad['fees_per_unit'];
    $dueDate = "2025-01-10";
    $today = date("Y-m-d");

    if($today > $dueDate){
        $fine = 500;
    }else{
        $fine = 0;
    }


    date_default_timezone_set("Asia/Kolkata");
    $date = date("Y-m-d H:i:s");

    mysqli_query($conn,"
    INSERT INTO student_fees
    (userid,unit_number,amount,payment_date)
    VALUES
    ('$uid','$unit','$amount','$date')
    ");

    echo "<script>alert('Fees Paid Successfully');
    window.location.href='pay_fees.php';</script>";
}
?>

<html>
<head>
<title>Pay Fees</title>
<style>
body{font-family:Arial;background:#f4f6f9;}
.box{
width:500px;margin:60px auto;background:white;padding:30px;
border-radius:10px;box-shadow:0 0 10px gray;
}
select,button{padding:8px;margin:8px 0;width:100%;}
table{width:100%;border-collapse:collapse;margin-top:20px;}
td,th{border:1px solid gray;padding:8px;text-align:center;}
th{background:#2c3e50;color:white;}
</style>
</head>

<body>
<div class="box">

<h2>Fees Payment</h2>

<p>
Fees Per <?php echo $acad['duration_type']; ?> :
₹ <?php echo $acad['fees_per_unit']; ?>
</p>

<form method="post">
<select name="unit" required>
<option value="">Select <?php echo $acad['duration_type']; ?></option>

<?php
for($i=1;$i<=$acad['total_units'];$i++){
echo "<option value='$i'>$i</option>";
}
?>
</select>

<button name="pay">Pay Fees</button>
</form>

<hr>

<h3>Payment History</h3>

<table>
<tr>
<th><?php echo $acad['duration_type']; ?></th>
<th>Amount</th>
<th>Date</th>
<th>Receipt</th>
</tr>

<?php
$totalPaid = 0;

$res = mysqli_query($conn,"
SELECT * FROM student_fees
WHERE userid='$uid'
ORDER BY unit_number ASC
");

while($row = mysqli_fetch_assoc($res)){
$totalPaid += $row['amount'];
?>
<tr>
<td><?php echo $row['unit_number']; ?></td>
<td>₹ <?php echo $row['amount']; ?></td>
<td><?php echo $row['payment_date']; ?></td>
<td>
<a href="receipt.php?id=<?php echo $row['id']; ?>" target="_blank">
Download
</a>
</td>
</tr>
<?php } ?>
</table>


<br>

<?php
$totalCourse = $acad['fees_per_unit'] * $acad['total_units'];
$remaining = $totalCourse - $totalPaid;
?>

<p>Total Paid: ₹ <?php echo $totalPaid; ?></p>
<p>Remaining Fees: ₹ <?php echo $remaining; ?></p>

<br>
<a href="user.php">Back</a>

</div>
</body>
</html>
