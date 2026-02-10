<?php
session_start();
$conn = mysqli_connect("localhost","root","","student");

if(!isset($_SESSION['userid']) || $_SESSION['userid'] != "admin"){
    header("Location: login.html");
    exit();
}

/* Total Students */
$students = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) as total FROM user WHERE userid!='admin'")
);

/* Total Fees Collected */
$fees = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT SUM(amount) as total FROM student_fees")
);

/* Total Book Bank */
$book = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) as total FROM book_bank")
);

/* Total Bus Users */
$bus = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) as total FROM student_bus")
);

/* Total Complaints */
$complaint = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) as total FROM complaint")
);

/* Total Feedback */
$feedback = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) as total FROM feedback")
);
?>

<html>
<head>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<title>Admin Analytics Dashboard</title>
<style>
body{
font-family:Arial;
background:#f4f6f9;
margin:0;
}
.container{
width:90%;
margin:40px auto;
}
h2{text-align:center;}
.grid{
display:grid;
grid-template-columns:repeat(3,1fr);
gap:20px;
}
.card{
background:white;
padding:30px;
border-radius:10px;
box-shadow:0 0 10px gray;
text-align:center;
}
.card h3{
margin:0;
font-size:20px;
}
.card p{
font-size:28px;
font-weight:bold;
color:#2c3e50;
}
button{
padding:8px 15px;
background:#2c3e50;
color:white;
border:none;
border-radius:5px;
cursor:pointer;
}
</style>
</head>

<body>

<div class="container">

<h2>Admin Analytics Dashboard</h2>

<div class="grid">

<div class="card">
<h3>Total Students</h3>
<p><?php echo $students['total']; ?></p>
</div>

<div class="card">
<h3>Total Fees Collected</h3>
<p>₹ <?php echo $fees['total'] ? $fees['total'] : 0; ?></p>
</div>

<div class="card">
<h3>Book Bank Students</h3>
<p><?php echo $book['total']; ?></p>
</div>

<div class="card">
<h3>Bus Users</h3>
<p><?php echo $bus['total']; ?></p>
</div>

<div class="card">
<h3>Total Complaints</h3>
<p><?php echo $complaint['total']; ?></p>
</div>

<div class="card">
<h3>Total Feedback</h3>
<p><?php echo $feedback['total']; ?></p>
</div>

</div>

<br><br>

<center>
<button onclick="window.location.href='admin.html'">
Back to Admin Panel
</button>
</center>

</div>
<canvas id="feeChart"></canvas>

</body>
</html>
<?php
$fees = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT SUM(amount) as total FROM student_fees")
);
$totalFees = $fees['total'] ? $fees['total'] : 0;
?>

<script>
const ctx = document.getElementById('feeChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Total Fees Collected'],
        datasets: [{
            label: 'Amount',
            data: [<?php echo $totalFees; ?>],
            backgroundColor: ['blue']
        }]
    },
});
</script>
