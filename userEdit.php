<?php
session_start();
require "conn.php";
if(!isset($_POST['editsuree'])){
    header("location: index.php");
}
if (!isset($_SESSION['admin'])) {
    session_unset();
    session_destroy();
    header("location:admin.php");
}
else {
?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Edit User</title>
    <?php require 'links.php'; ?>
    <style>
        fieldset{
            width: auto;
        }
        
    </style>
</head>

<body>

    <center class='form-div m-0 p-0' id='passDiv' style='display:none'>
        <fieldset class='m-0 p-2 mt-3' style='width:95%'>
            <ul style='width: fit-content; margin:0 auto;'>

                <li>
                    <div style='text-align: left;' id='passNumber'>Password should contain at-least 1 number</div>
                </li>
                <li>
                    <div style='text-align: left;' id='passLetter'>Password should contain at-least one uppercase letter
                    </div>
                </li>
                <li>
                    <div style='text-align: left;' id='passSpecial'>Password should contain at-least 1 special character
                    </div>
                </li>
                <li>
                    <div style='text-align: left;' id='passLength'>Length of password should be minimum 8 characters
                    </div>
                </li>

            </ul>
        </fieldset>
    </center>
    <div class='form-div centered' id='goUP'>
    <?php
    
        $user_id = $_POST['userID']; 
        $old_userName = $_POST['userID'];
        $selectUserQuery = "SELECT user_table.* , shop_table.* , login_table.* 
            FROM user_table 
            JOIN shop_table ON user_table.user_id = shop_table.shop_id 
            JOIN login_table ON login_table.login_id = user_table.user_id
            WHERE user_table.user_id = $user_id
        ";
        $result_selectUserQuery = mysqli_query($conn, $selectUserQuery);
        $data = mysqli_fetch_array($result_selectUserQuery);
        echo "<fieldset style='margin-top: 0;'>
            <legend>Edit User</legend>
            <form onsubmit='return signup();' action='performUpdateCheck.php?userID=$user_id&oldUsername=$old_userName' method='POST'>
                <div class='border-top'></div>
                <p class='title'>User Details</p>
                <input required autocomplete='off' type='text' value='".$data['fname']."' name='fname' id='fName' placeholder='First Name'>
                <input required autocomplete='off' type='text' value='".$data['lname']."' name='lname' id='lName' placeholder='Last Name'>
                <div class='left'>
                    <input required autocomplete='off' type='text' value='".$data['username']."' name='username' id='username' placeholder='Username'>
                </div>
                <input required autocomplete='off' type='password' name='password' id='password' placeholder='Password'
                    onkeyup='validatePassword();'>
                <input required autocomplete='off' type='password' name='cpassword' id='cpassword'
                placeholder='Confirm Password' onkeyup='confirmPass(); '><br>
                <small id='cpassError' style='color: red;visibility: hidden;'></small>
                <div class='border-top'></div>
                
                <p class='title'>Shop Details</p>
                <input required autocomplete='off' type='text' value='".$data['shop_name']."' name='shopname' id='shopname' placeholder='Shop Name'>
                <input required autocomplete='off' type='search' value='".$data['shop_gst_no']."' name='gstNumber' id='gstNumber'
                    placeholder='GST Number' onkeyup='confirmGst(); uppercase();'>
                <br>
                <small id='gstError' style='color: red;visibility: hidden;'></small>
                <textarea name='address' id='address' rows='2' placeholder='Shop Address'></textarea>
                <script>document.getElementById('address').value = '".$data['shop_address']."' </script>
                <br>
                <label id='l1' style='color:red; visibility: hidden;'>Invalid</label><br>
                <input required autocomplete='off' type='text' value='".$data['mobile1']."' name='mobile1' id='mobile' placeholder='mobile number 1'>
                <input autocomplete='off' type='text' value='".$data['mobile2']."' name='mobile2' id='mobile2' placeholder='mobile number 2'>
                <br>
                <small id='numberError' style='color: red;visibility: hidden;'></small>
                <small id='numberError2' style='color: red;visibility: hidden;'></small>
                <br>
                <button>Update Account</button>
            </form>
        </fieldset>";
  
        ?>
    </div>

</body>

</html>
<?php  
}

?>