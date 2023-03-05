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
        .activee{
            background: #343a40 !important;
        }       
    
        </style>

    </head>

    <body>
    <?php require "navbar.php"; ?>
<script>
    //for changing the class name (# replacement for active class)
    document.getElementById("subUsers").classList.add("active");
    document.getElementById("subUsers").classList.remove("text-light");
    document.getElementById("subUsers").classList.add("text-white");
   
    document.getElementById("editsubUsers").classList.add("activee");
</script>
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
        <div class="mt-3 mb-2 container" style="text-align: center;">
            <span class="h4" style="color: #333;">
                SUB-USERS DETAILS
            </span>
        </div> <br>

        
        <?php 
        $selectUsersquery = "SELECT * from $subUserTable WHERE status = 'working';";
        $result_selectUsersquery = mysqli_query($conn, $selectUsersquery);
        $srno = 1;
        if($result_selectUsersquery->num_rows > 0){?>
            <div class="container-lg table-responsive"  style="text-align: center;">
            <table class="table bg-white table-hover rounded " style="margin-bottom:90vh;">
            <thead>
                <tr>
                    <th scope="col" class="text-nowrap">Sr.No</th>
                    <th scope="col" class="text-nowrap">Name</th>
                    <th scope="col" class="text-nowrap">User Name</th>
                    <th scope="col" class="text-nowrap">Password</th>
                    <th scope="col" class="text-nowrap">Mobile Number</th>
                    <th scope="col" class="text-nowrap" class="text-center">Edit</th>
                    <th scope="col" class="text-nowrap" class="text-center">Delete</th>
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
                        <td><button  data-toggle='modal' data-target='#modalPush' style='border: 0px solid transparent; background-color: transparent;' onclick='writeee($srno);'><i class='fa fa-edit text-success'>Edit</i></button></td>
                        <td><button  data-toggle='modal' data-target='#modalPush2' style='border: 0px solid transparent; background-color: transparent;' onclick='deletee($srno);'><i class='fa fa-trash text-danger'>Delete</i></button></td>
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
                <div class="mt-3 container" style="text-align: center; color: #444;  margin-bottom:75vh">
                    <span class="h5">
                        NO SUB-USER CREATED YET
                    </span>
                </div>
            ';
        }
        ?>
            
          <!-- Modal 2 -->
<div class="modal fade" id="modalPush2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info" role="document">
    <div class="modal-content animate text-center">
      <div class="modal-header d-flex justify-content-center bg-danger">
        <p class="heading">Warning!!</p>
      </div>
            <form method="post" action="PerformSubUsers.php">
                <div class="modal-body">
                    Do you Really Want to delete <u><b id = "delid"> </b></u> Details??
                    <div style="visibility: hidden;">
                        <input id="delidd" name="delUname"></input>
                    </div>
                    <script>
                    function deletee(num){
                        var uname = document.getElementById("edit"+num).innerHTML;
                        document.getElementById("delid").innerHTML = uname;
                        document.getElementById("delidd").value = uname;
                    }
                    </script>
                </div>
                <div class="modal-footer">
                        
                            
                    <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger" name="delsure">Sure</button>
                        
                </div>
            </form>
    </div>
  </div>
</div>
 
          <!-- Modal 1 -->
<div class="modal fade" id="modalPush" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info" role="document">
    <div class="modal-content animate text-center">
        <div class="modal-header d-flex justify-content-center bg-primary">
            <p class="heading">Confirm</p>
        </div>  
            <form method="post" action="subUsersUpdate.php">
                <div class="modal-body">
                    <p class="text-dark">Do you Really Want to edit <u><b id = "editid"> </b></u> Details??</p>
                    <div style="visibility: hidden;">
                        <input id="editidd" name="editUname"></input>
                    </div>
                    <script>
                        function writeee(num){
                            var uname = document.getElementById("edit"+num).innerHTML;
                            document.getElementById("editid").innerHTML = uname;
                            document.getElementById("editidd").value = uname;
                        }
                    </script>
                </div>
                <div class="modal-footer">
                            
                    <button type="button" class="btn btn-dark" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary" name="editsure">Sure</button>
                        
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