<?php
$conn = mysqli_connect("localhost","root","","student");

if(!$conn){
    die("Database Not Connected");
}


/* ================= ISSUE BOOK ================= */
/* ================= ISSUE BOOK ================= */
if(isset($_POST['issue'])){
    $userid = $_POST['userid'];
    $book = $_POST['book'];

    // Check User Exists
    $checkUser = mysqli_query($conn,"SELECT * FROM user WHERE userid='$userid'");
    
    if(mysqli_num_rows($checkUser) > 0){

        // Count Active Books (Not Returned)
        $countQuery = mysqli_query($conn,
            "SELECT COUNT(*) as total 
             FROM library 
             WHERE userid='$userid' 
             AND return_date IS NULL");

        $countData = mysqli_fetch_assoc($countQuery);
        $activeBooks = $countData['total'];

        if($activeBooks >= 2){
            echo "<script>alert('Maximum 2 Books Already Issued!');</script>";
        } else {

            $today = date("Y-m-d");

            mysqli_query($conn,
                "INSERT INTO library(userid,book_name,issue_date) 
                 VALUES('$userid','$book','$today')");

            echo "<script>alert('Book Issued Successfully');</script>";
        }

    } else {
        echo "<script>alert('User Not Found');</script>";
    }
}


/* ================= RETURN BOOK ================= */
if(isset($_POST['return'])){
    $libid = $_POST['libid'];
    $returnDate = date("Y-m-d");

    $result = mysqli_query($conn,"SELECT * FROM library WHERE id='$libid'");
    $row = mysqli_fetch_assoc($result);

    if($row){
        $issueDate = $row['issue_date'];
        $days = (strtotime($returnDate) - strtotime($issueDate)) / (60*60*24);

        $fine = 0;
        if($days > 15){
            $extraDays = $days - 15;
            $fine = $extraDays * 2;
        }

        mysqli_query($conn,"UPDATE library 
                            SET return_date='$returnDate', fine='$fine' 
                            WHERE id='$libid'");

        echo "<script>alert('Book Returned. Fine: ₹$fine');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Library Management</title>
<style>
body{font-family: Arial;background:#f4f4f4;}
.container{width:90%;margin:auto;}
h2{background:#333;color:white;padding:10px;}
form{background:white;padding:15px;margin-bottom:20px;box-shadow:0 0 5px gray;}
input,button{padding:8px;margin:5px;}
button{background:#333;color:white;border:none;cursor:pointer;}
button:hover{background:#555;}
table{width:100%;background:white;border-collapse: collapse;}
th,td{padding:10px;border:1px solid #ccc;text-align:center;}
th{background:#333;color:white;}
</style>
</head>
<body>

<div class="container">

<h2>Issue Book</h2>
<form method="POST">
    User ID: <input type="text" name="userid" required>
    Book Name: <input type="text" name="book" required>
    <button type="submit" name="issue">Issue Book</button>
</form>

<h2>Issued Books</h2>

<table>
<tr>
<th>ID</th>
<th>User ID</th>
<th>User Name</th>
<th>Status</th>
<th>Role</th>
<th>Book</th>
<th>Issue Date</th>
<th>Return Date</th>
<th>Fine</th>
<th>Action</th>
</tr>

<?php
$query = mysqli_query($conn,"SELECT library.*, user.uname, user.status, user.role 
                             FROM library 
                             INNER JOIN user 
                             ON library.userid = user.userid");

if(!$query){
    die("Query Failed: " . mysqli_error($conn));
}

while($row = mysqli_fetch_assoc($query)){
?>
<tr>
<td><?php echo $row['id']; ?></td>



<td><a href="admin_view_user.php?userid=<?php echo $row['userid']; ?>"><?php echo $row['userid'];?></a></td>
<td><?php echo $row['uname']; ?></td>
<td><?php echo $row['status']; ?></td>
<td><?php echo $row['role']; ?></td>
<td><?php echo $row['book_name']; ?></td>
<td><?php echo $row['issue_date']; ?></td>
<td><?php echo $row['return_date']; ?></td>
<td>₹<?php echo $row['fine']; ?></td>
<td>
<?php if(empty($row['return_date'])){ ?>
<form method="POST" style="display:inline;">
<input type="hidden" name="libid" value="<?php echo $row['id']; ?>">
<button type="submit" name="return">Return</button>
</form>
<?php } else { echo "Returned"; } ?>
</td>
</tr>
<?php } ?>

</table>

</div>
<div style="text-align:right; margin-bottom:10px;">
    <a href="library.html">
        <button style="background:red;">Logout</button>
    </a>
</div>

</body>
</html>
