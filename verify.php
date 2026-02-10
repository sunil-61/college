<?php
$conn = mysqli_connect("localhost","root","","student");

$id = $_GET['id'];

$q = mysqli_query($conn,"
SELECT * FROM certificate WHERE id='$id'
");

if(mysqli_num_rows($q) > 0){
    echo "<h2>Certificate Verified</h2>";
}else{
    echo "<h2>Invalid Certificate</h2>";
}
?>
