<?php
$conn = mysqli_connect("localhost","root","","student");
$data = null;
$gid = null;

echo "<center><h2>Search User Account</h2>
    <form method='POST'>
    <input type='text' name='userid' placeholder='Enter userid to search' required>
    <input type='submit' name='search' value='Search'>
</form></center>";

if(isset($_POST['search'])){
    $gid = $_POST['userid'];

    if($gid != "admin") {
        $sel = "SELECT * FROM user WHERE userid='$gid'";
        $run = mysqli_query($conn, $sel);
        $data = mysqli_fetch_array($run);
        if($data) {
        echo "<center><form method='POST'>
                <table border='1' style='margin-top:50px;'>
                    <tr>
                        <td>".$data['userid']."</td>
                        <td>".$data['uname']."</td>
                        <td>".$data['pass']."</td>
                        <td>".$data['mobile']."</td>
                        <td>".$data['email']."</td>
                    </tr>
                    <tr>
                        <td colspan='5'>
                            <input type='submit' name='reset' value='Reset'>
                        </td>
                    </tr>
                </table>
              </form></center>";
        }
        else{
        echo "<center><h3>No record found!</h3></center>";
        }
    }
    else{
        echo "<center><h3>No record found!</h3></center>";
    }
}

if(isset($_POST['reset'])){
    $data = null;
}
echo "<script>
function gotoview(){
window.location.href='view.php';
}
</script>
<center><button type='button' onclick='gotoview()'>View Page</button></center>";
?>