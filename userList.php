<?php

session_start();
require "conn.php";
if (!isset($_SESSION['admin'])) {
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
        <title>Users list</title>
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
            /*for button*/
        .btn{
            transition-duration: 0.22s;
            padding: 0.24rem 0.75rem !important;
        }
        .btn:hover{
            background-color: #f8f9fa;
            color: grey;
        }
        .btn:focus {
            outline: 0;
            box-shadow: 0 0 0 0rem rgba(0, 123, 255, 0.25) !important;
        }
        </style>

    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="createUser.php">Admin</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse mr-auto" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link text-nowrap" href="createUser.php">Create User</a>
                    <a class="nav-link text-nowrap active" href="userList.php">Users List</a>
                    <a class="nav-link text-nowrap" href="userFeedbacks.php">User Feedbacks</a>
                </div>
                <div class="navbar-nav ml-auto">
                    <a class="nav-link text-nowrap" href="logout.php">Logout</a>
                </div>
            </div>
        </nav>
        <?php
        if (isset($_SESSION["errorKey"])) {
            //checking passed errors from performUpdateCheck.php page
            if ($_SESSION["errorKey"] == 1) {
                $_SESSION["errorKey"] = 0; ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Problem while updating user information</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php
            }
        }
        if (isset($_SESSION["successKey"])) {
            //checking passed success from performUpdateCheck.php page //success if user is created successfully
            if ($_SESSION["successKey"] == 2) {
                $_SESSION["successKey"] = 0; ?>
                    <div class="alert animate-hide alert-success alert-dismissible fade show" role="alert">
                        <strong>Congratulations </strong> User Account Updated Successfully..
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php
            }
            if ($_SESSION["successKey"] == 4) {
                $_SESSION["successKey"] = 0; ?>
                    <div class="alert animate-hide alert-success alert-dismissible fade show" role="alert">
                        <strong>Deletion Successfull </strong> User Account Deleted Successfully..
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php
            }
        }
        ?>
        <br>
        <div class="container">
        <table class="table bg-white rounded table-hover" style="margin-bottom:90vh; back">
            <thead>
                <tr>
                    <th scope="col" class="text-nowrap">Sr.No</th>
                    <th scope="col" class="text-nowrap">User ID</th>
                    <th scope="col" class="text-nowrap">Name</th>
                    <th scope="col" class="text-nowrap">User Name</th>
                    <th scope="col" class="text-nowrap">Shop Name</th>
                    <th scope="col" class="text-nowrap">GSTIN Number</th>
                    <th scope="col" class="text-nowrap" class="text-center">Edit</th>
                    <th scope="col" class="text-nowrap">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $selectUsersquery = "SELECT user_table.* , shop_table.*, login_table.* 
                    FROM user_table 
                    JOIN shop_table ON user_table.user_id = shop_table.shop_id
                    JOIN login_table ON user_table.user_id = login_table.login_id
                    ";
                $result_selectUsersquery = mysqli_query($conn, $selectUsersquery);
                $srno = 1;
                while($data = mysqli_fetch_array($result_selectUsersquery)) {
                    $userID = $data['user_id'];
                    $name = $data['fname'] . " " . $data['lname'];
                    $userName = $data['username'];
                    $shopName = $data['shop_name'];
                    $GSTINnumber = $data['shop_gst_no'];
                    echo "<tr>
                        <th scope='row'>$srno</th>
                        <td id='giveunameid$srno'>$userID</td>
                        <td>$name</td>
                        <td id='giveuname$srno'>$userName</td>
                        <td>$shopName</td>
                        <td>$GSTINnumber</td>
                        
                        <td><button data-toggle='modal' data-target='#staticBackdrop' style='border: 0px solid transparent; background-color: transparent;' onclick='writeee($srno);'><i class='fa fa-edit text-success'>Edit</i></button></td>
                        <td><button data-toggle='modal' data-target='#staticBackdrop2' style='border: 0px solid transparent; background-color: transparent;' onclick='deleteee($srno);'><i class='fa fa-trash text-danger'>Delete</i></button></td>
                        
                    </tr>";
                    $srno += 1;
                
                }
                ?>
            </tbody>
        </table>
        </div>

                  <!-- Modal 2 for delete-->
<div class="modal fade" id="staticBackdrop2" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content animate">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel"> Confirm !!</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline:none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="userEdit.php">
                <div class="modal-body">
                    Do you Really Want to delete <u><b id = "writeunamedel"> </b></u> Details??
                    <div style="display: none;">  
                        <input id="unameidsenddel" name="userID"></input>
                        <input id="unamesend" name="username"></input>
                    </div>                  
                    <script>
                        function deleteee(num){
                            var uname = document.getElementById("giveuname"+num).innerHTML;
                            document.getElementById("writeunamedel").innerHTML = uname;
                            document.getElementById("unamesend").value = uname;
                            var unameid = document.getElementById("giveunameid"+num).innerHTML;
                            document.getElementById("unameidsenddel").value = unameid;
                        }
                    </script>
                </div>
                <div class="modal-footer">
                            
                    <button type="button" class="btn btn-dark" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary" name="delsuree">Sure</button>
                        
                </div>
            </form>            
        </div>
    </div>
</div> 
                  <!-- Modal 1 for edit -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content animate">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel"> Confirm !!</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline:none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="userEdit.php">
                <div class="modal-body">
                    Do you Really Want to edit <u><b id = "writeuname"> </b></u> Details??
                    <div style="visibility: hidden;">
                        <input id="unameidsend" name="userID"></input>
                    </div>                   
                    <script>
                        function writeee(num){
                            var uname = document.getElementById("giveuname"+num).innerHTML;
                            document.getElementById("writeuname").innerHTML = uname;
                            var unameid = document.getElementById("giveunameid"+num).innerHTML;
                            document.getElementById("unameidsend").value = unameid;
                        }
                    </script>
                </div>
                <div class="modal-footer">
                            
                    <button type="button" class="btn btn-dark" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary" name="editsuree">Sure</button>
                        
                </div>
            </form>            
        </div>
    </div>
</div> 
    </body>
     
    </html>
<?php
}
?>