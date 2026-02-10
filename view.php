<?php
session_start();
$conn = mysqli_connect("localhost","root","","student");

if(!isset($_SESSION['userid']) || $_SESSION['userid'] != "admin"){
    header("Location: login.html");
    exit();
}

$qry = "SELECT * FROM user";
$res = mysqli_query($conn, $qry);
?>

<!DOCTYPE html>
<html>
<head>
<title>All Users</title>

<style>
body{
    margin:0;
    font-family: Arial;
    background:#f4f6f9;
}

.container{
    width:90%;
    margin:40px auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 0 15px rgba(0,0,0,0.1);
}

h2{
    text-align:center;
}

.top-bar{
    display:flex;
    justify-content:space-between;
    margin-bottom:20px;
}

input[type="text"]{
    padding:8px;
    width:250px;
}

button{
    padding:8px 15px;
    border:none;
    border-radius:5px;
    cursor:pointer;
    background:#2c3e50;
    color:white;
}

button:hover{
    background:#34495e;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:10px;
    border:1px solid #ccc;
    text-align:center;
}

th{
    background:#2c3e50;
    color:white;
}

tr:hover{
    background:#f1f1f1;
}

img{
    border-radius:50%;
    object-fit:cover;
}

.action a{
    text-decoration:none;
    padding:5px 8px;
    border-radius:4px;
    color:white;
}

.update{
    background:green;
}

.delete{
    background:red;
}

.profile-link{
    text-decoration:none;
    color:#2c3e50;
    font-weight:bold;
}
</style>

<script>
function searchUser(){
    let input = document.getElementById("search").value.toLowerCase();
    let rows = document.getElementsByTagName("tr");

    for(let i=1;i<rows.length;i++){
        let text = rows[i].innerText.toLowerCase();
        rows[i].style.display = text.includes(input) ? "" : "none";
    }
}
</script>

</head>

<body>

<div class="container">

<h2>All Registered Users</h2>

<div class="top-bar">
    <input type="text" id="search" placeholder="Search user..." onkeyup="searchUser()">
    <div>
        <button onclick="window.location.href='admin.html'">Back to Admin</button>
        <button onclick="window.location.reload()">Refresh</button>
    </div>
</div>

<table>
<tr>
    <th>#</th>
    <th>User ID</th>
    <th>Name</th>
    <th>Password</th>
    <th>Mobile</th>
    <th>Email</th>
    <th>Photo</th>
    <th>Action</th>
</tr>

<?php
$sr = 1;
while($data = mysqli_fetch_assoc($res)){

    if(strtolower($data['userid']) == "admin"){
        continue;
    }
?>
<tr>
    <td><?php echo $sr++; ?></td>

    <td>
        <a class="profile-link"
           href="admin_view_user.php?userid=<?php echo $data['userid']; ?>">
           <?php echo $data['userid']; ?>
        </a>
    </td>

    <td><?php echo $data['uname']; ?></td>

    <td>********</td>

    <td><?php echo $data['mobile']; ?></td>

    <td><?php echo $data['email']; ?></td>

    <td>
        <img height="60" width="60"
             src="profile_photo/<?php echo !empty($data['photo']) ? $data['photo'] : 'default.png'; ?>">
    </td>

    <td class="action">
        <a class="update"
           href="update.php?userid=<?php echo $data['userid']; ?>">Update</a>
        |
        <a class="delete"
           href="delete.php?userid=<?php echo $data['userid']; ?>"
           onclick="return confirm('Are you sure?')">Delete</a>
    </td>
</tr>
<?php } ?>

</table>

</div>

</body>
</html>
