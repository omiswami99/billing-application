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
        <title>Users Feedback</title>
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
                <a class="nav-link text-nowrap" href="userList.php">Users List</a>
                <a class="nav-link text-nowrap active" href="userFeedbacks.php">User Feedbacks</a>
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
        <table class="table bg-white rounded table-hover" style="margin-bottom:90vh;">
                <?php 
                $selectUsersquery = "SELECT user_table.* , login_table.* , customer_feedback.* 
                    FROM user_table 
                    JOIN login_table ON user_table.user_id = login_table.login_id
                    JOIN customer_feedback ON user_table.user_id = customer_feedback.user_id
                    ORDER BY customer_feedback.sr_no desc
                ";
                $result_selectUsersquery = mysqli_query($conn, $selectUsersquery);
                $srno = 1;
                if($result_selectUsersquery)
                {
                    echo "<thead>
                    <tr>
                        <th scope='col' class='text-nowrap'>Sr.No</th>
                        <th scope='col' class='text-nowrap'>User ID</th>
                        <th scope='col' class='text-nowrap'>Name</th>
                        <th scope='col' class='text-nowrap'>User Name</th>
                        <th scope='col' class='text-nowrap'>Subuser Name</th>
                        <th scope='col' class='text-nowrap'>Email-ID</th>
                        <th scope='col' class='text-nowrap'>Feedback</th>
                        <!-- <th scope='col' class='text-center'>Contact User</th> -->
                    </tr>
                    </thead>
                    <tbody>";
                    while($data     = mysqli_fetch_array($result_selectUsersquery)) {
                        $userID     = $data['user_id'];
                        $name       = $data['fname'] . " " . $data['lname'];
                        $userName   = $data['username'];
                        $subUserName   = $data['subUser_uName'];
                        $emailID    = $data['email_id'];
                        $feedback   = $data['feedback'];
                        echo "<tr>
                            <th scope='row'>$srno</th>
                            <td>$userID</td>
                            <td>$name</td>
                            <td>$userName</td>
                            <td>$subUserName</td>
                            <td>$emailID</td>
                            <td>$feedback</td>
                        </tr>";
                        //<td class='text-center'><a href='userEdit.php?userID=$userID&oldUsername=$userName'><i class='fa fa-edit text-success'></i></a></td>
                        $srno += 1;
                    }
                }
                else
                {
                    echo "<h5 class='h5 text-center'>Not Any Feedback Yet!</h5>";
                }
                ?>
            </tbody>
        </table>
        </div>
    </body>

    </html>
<?php
}
?>