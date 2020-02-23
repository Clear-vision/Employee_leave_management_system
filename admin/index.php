<?php
session_start();
include('includes/config.php');

if(isset($_POST['signin'])) {

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT UserName,Password FROM admin WHERE UserName=:username";
$query = $dbh->prepare($sql);
$query-> bindParam(':username', $username, PDO::PARAM_STR);
$query->execute();
$row = $query->fetch(PDO::FETCH_ASSOC);
if(password_verify($password,$row["Password"])) {

$_SESSION['alogin'] = $_POST['username'];

echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";

} else{
  
  echo "<script>alert('Invalid Details');</script>";

}

}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        
        <!-- Title -->
        <title>Employee leave management system |  Admin</title>

        <?php  include('../includes/metatag.php');?>
        
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css"/>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">        
        <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/custom.css" rel="stylesheet" type="text/css"/>
    </head>
    <body class="signin-page">

        <div class="mn-content valign-wrapper">

            <main class="mn-inner container">
  <h4 align="center"><a href="../index.php">Employee Leave Management System | Admin Login</a></h4>
                <div class="valign">
                      <div class="row">

                          <div class="col s12 m6 l4 offset-l4 offset-m3">
                              <div class="card white darken-1">
                                  <div class="card-content ">
                                      <span class="card-title">Sign In</span>
                                       <div class="row">
                                           <form class="col s12" name="signin" method="post">
                                               <div class="input-field col s12">
                                                   <input id="username" type="text" name="username" class="validate" autocomplete="off" required >
                                                   <label for="email">Username</label>
                                               </div>
                                               <div class="input-field col s12">
                                                   <input id="password" type="password" class="validate" name="password" autocomplete="off" required>
                                                   <label for="password">Password</label>
                                               </div>


                                               <div class="input-field col s12">
                                                   <button type="submit" name="signin" class="waves-effect waves-light btn m-b-xs">Sign In</button>

                                               </div>

                                           </form>
                                      </div>
                                  </div>
                              </div>
                          </div>
                    </div>
                </div>
            </main>
        </div>
        
        <!-- Javascripts -->
        <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="../assets/js/alpha.min.js"></script>
        
    </body>
</html>