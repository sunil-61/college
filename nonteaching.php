<?php
$conn = mysqli_connect("localhost","root","","student");

$query = "SELECT * FROM staff WHERE type='Non Teaching'";
$result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Non Teaching Staff</title>

    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            background-color:#f2f2f2;
            margin:0;
            padding:0;
        }

        .title{
            text-align:center;
            font-size:28px;
            font-weight:bold;
            padding:20px;
            background:#333;
            color:white;
        }

        .staff-box{
            width:85%;
            margin:25px auto;
            background:white;
            padding:20px;
            box-shadow:0 0 10px rgba(0,0,0,0.2);
            border-radius:8px;
            display:flex;
        }

        .staff-box img{
            width:160px;
            height:190px;
            object-fit:cover;
            border-radius:8px;
            margin-right:25px;
            border:2px solid #ddd;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        td{
            padding:6px;
            border-bottom:1px solid #eee;
        }

        td:first-child{
            font-weight:bold;
            width:180px;
            color:#333;
        }

        .no-data{
            text-align:center;
            font-size:20px;
            margin-top:50px;
            color:red;
        }
    </style>

</head>
<body>

<div class="title">NON TEACHING STAFF</div>

<?php
if(mysqli_num_rows($result) > 0){

    while($row = mysqli_fetch_assoc($result)){
?>

<div class="staff-box">

    <img src="staff_images/<?php echo $row['photo']; ?>" alt="Staff Photo">

    <table>
        <tr>
            <td>Name</td>
            <td><?php echo $row['name']; ?></td>
        </tr>

        <tr>
            <td>Type</td>
            <td><?php echo $row['type']; ?></td>
        </tr>

        <tr>
            <td>DOB</td>
            <td><?php echo date("d-m-Y", strtotime($row['dob'])); ?></td>
        </tr>

        <tr>
            <td>Father Name</td>
            <td><?php echo $row['father_name']; ?></td>
        </tr>

        <tr>
            <td>Mother Name</td>
            <td><?php echo $row['mother_name']; ?></td>
        </tr>

        <tr>
            <td>Designation</td>
            <td><?php echo $row['designation']; ?></td>
        </tr>

        <tr>
            <td>Qualification</td>
            <td><?php echo $row['qualification']; ?></td>
        </tr>

        <tr>
            <td>Contact No.</td>
            <td><?php echo $row['contact']; ?></td>
        </tr>

        <tr>
            <td>Email Id</td>
            <td><?php echo $row['email']; ?></td>
        </tr>

        <tr>
            <td>PAN No.</td>
            <td><?php echo $row['pan']; ?></td>
        </tr>

        <tr>
            <td>Joining Date</td>
            <td><?php echo date("d-m-Y", strtotime($row['joining_date'])); ?></td>
        </tr>

    </table>

</div>

<?php
    }

}else{
    echo "<div class='no-data'>No Non Teaching Staff Found</div>";
}
?>

</body>
</html>
