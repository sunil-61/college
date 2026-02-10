<?php
session_start();
$conn = mysqli_connect("localhost","root","","student");

if(!isset($_SESSION['userid'])){
    header("Location: login.html");
    exit();
}

$uid = $_SESSION['userid'];

$check = mysqli_query($conn,"SELECT * FROM book_bank WHERE userid='$uid'");
$data = mysqli_fetch_assoc($check);

/* First Time Deposit */
if(isset($_POST['join'])){
    mysqli_query($conn,"
        INSERT INTO book_bank (userid,deposit,year_count)
        VALUES ('$uid',2000,1)
    ");
    echo "<script>alert('Book Bank Joined');
    window.location.href='book_bank.php';</script>";
}

/* Renewal */
if(isset($_POST['renew'])){
    $years = $data['year_count'] + 1;

    mysqli_query($conn,"
        UPDATE book_bank SET year_count='$years'
        WHERE userid='$uid'
    ");

    echo "<script>alert('Book Bank Renewed');
    window.location.href='book_bank.php';</script>";
}
?>

<html>
<head>
<title>Book Bank</title>
<style>
body{font-family:Arial;background:#f4f6f9;}
.box{
width:400px;margin:60px auto;background:white;padding:30px;
border-radius:10px;box-shadow:0 0 10px gray;
}
button{padding:8px;background:#2c3e50;color:white;border:none;}
table{margin-top:20px;width:100%;}
td{padding:6px;border:1px solid gray;}
</style>
</head>

<body>
<div class="box">
<h2>Book Bank System</h2>

<?php if(!$data){ ?>

<p>Deposit ₹2000 to join Book Bank</p>
<form method="post">
<button name="join">Join Book Bank</button>
</form>

<?php } else { ?>

<?php
$refund = 1500;
$years = $data['year_count'];
$balance = 2000 - ($years-1)*500;
?>

<table>
<tr><td>Deposit</td><td>₹ 2000</td></tr>
<tr><td>Years Completed</td><td><?php echo $years; ?></td></tr>
<tr><td>Current Balance</td><td>₹ <?php echo $balance; ?></td></tr>
<tr><td>Refund After 3 Years</td><td>₹ <?php echo $refund; ?></td></tr>
</table>

<?php if($years < 3){ ?>
<form method="post">
<br>
<button name="renew">Renew (₹500)</button>
</form>
<?php } else { ?>
<p style="color:green;">Eligible for ₹1500 Refund</p>
<?php } ?>

<?php } ?>

<br>
<a href="user.php">Back</a>

</div>
</body>
</html>
