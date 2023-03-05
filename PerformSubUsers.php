<?php
session_start();
include 'conn.php';
$owneruname = $_SESSION['username'];
$subusertable = $_SESSION['username']."_subusers";
if(isset($_POST['crtacc'])){
    $fname = $_POST['fname'];
    $uname = $_POST['username'];
    $pass = $_POST['password'];
    $mobile = $_POST['mobile'];


    if($owneruname == $uname){
        die("You cannot enter user name same as your user name");
        header("location: subUsersCreate.php");
    }
    
    $checkUnamew = "SELECT * FROM $subusertable WHERE username = '$uname';";
    $chkResul = $conn->query($checkUnamew);
    if($chkResul->num_rows > 0){ 
        $_SESSION["uniqUserNm"] = 1;
        header("location: subUsersCreate.php");
    }else{
        $insertSubUsers = "INSERT INTO $subusertable (fname,username,spassword,mobile,status)
        VALUES( '$fname', '$uname', '$pass', '$mobile', 'working');";
        $conn->query($insertSubUsers);
        $_SESSION['subusrcrt'] = 1;
        
        header("location: subUsersCreate.php");
        if($conn->error){
        echo "error ".$conn->error;
        }
    }
}

?>
<?php
if(isset($_POST['updateacc'])){
    $fname = $_POST['fname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $uname = $_POST['uname'];
    $mobile = $_POST['mobile'];
    $upd = "UPDATE $subusertable set fname = '$fname', username = '$username', spassword = '$password', mobile = '$mobile' WHERE username = '$uname';";
    $updresult = $conn->query($upd);
   
    header("location: subUsersEdit.php");
}

?>

<?php
if(isset($_POST['delsure'])){
    $delname = $_POST['delUname'];
    
    $upd = "UPDATE $subusertable set status = 'leaved' WHERE username = '$delname';";
    $updresult = $conn->query($upd);
    header("location: subUsersEdit.php");
     
}

?>