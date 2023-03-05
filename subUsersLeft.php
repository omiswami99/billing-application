<?php

session_start();
$subUserTable = $_SESSION['username']."_subusers";
$security = $_SESSION['user'];
require "conn.php";
if (!isset($_SESSION['username'])) {
    session_unset();
    session_destroy();
    header("location:admin.php");
}
else {
    ?>
    <!DOCTYPE html>
    
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Left Subusers</title>
        <!-- fontawesome link -->
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <?php
        require("links.php");
        ?>
        <style>
            fieldset{
                width:auto;
            }
            body {
                height:auto;
            }
             
            .activee{
                background: #343a40 !important;
            }   


        </style>

    </head>

    <body  style="margin-bottom:90vh;">
    <?php require "navbar.php"; ?>
<script>
    //for changing the class name (# replacement for active class)
    document.getElementById("subUsers").classList.add("active");
    document.getElementById("subUsers").classList.remove("text-light");
    document.getElementById("subUsers").classList.add("text-white");
   
    document.getElementById("leftsubUsers").classList.add("activee");
</script>
        
        <br>
        <div class="mt-3 mb-2 container" style="text-align: center; color: black;">
		<span class="h4">
			SUB-USERS DETAILS
		</span>
	    </div> <br>

        <?php 
         $selectUsersquery = "SELECT * from $subUserTable WHERE status != 'working';";
        $result_selectUsersquery = mysqli_query($conn, $selectUsersquery);
        $srno = 1;
        if($result_selectUsersquery->num_rows > 0){?>
            <div class="container"  style="text-align: center;">
            <table class="table bg-white rounded table-hover"  style="margin-bottom:90vh;">
            <thead>
                <tr>
                    <th scope="col" class="text-nowrap">Sr.No</th>
                    
                    <th scope="col" class="text-nowrap">Name</th>
                    <th scope="col" class="text-nowrap">User Name</th>
                    <th scope="col" class="text-nowrap">Password</th>
                    <th scope="col" class="text-nowrap">Mobile Number</th>
                     
                </tr>
            </thead>
            <tbody>

                <?php
                while($data = mysqli_fetch_array($result_selectUsersquery)) {
                    $name = $data['fname'];
                    $userName = $data['username'];
                    $password = $data['spassword'];
                    $mobile = $data['mobile'];
                    echo "<tr>
                            <th scope='row'>$srno</th>   
                            <td>$name</td>
                            <td id='edit$srno'>$userName</td>
                            <td>$password</td>
                            <td>$mobile</td>
                        </tr>";
                    $srno += 1;
                }
                ?>

            </tbody>
            </table>
            </div>

        <?php
        }else{
            echo '
                <div class="mt-3 mb-2 container" style="text-align: center; color: black; margin-bottom:90vh;">
                    <span class="h5">
                        NO SUB-USER LEFT YET
                    </span>
                </div>
            ';
        }
        ?>
     
    </body>
     
    </html>
<?php
}
?>