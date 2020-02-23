<?php
session_start();
error_reporting(0);
include('includes/config.php');
include('includes/function.php');
if(strlen($_SESSION['alogin'])==0){

header('location:index.php');

}else{



if(isset($_POST['update'])) {
    $eid = intval($_GET['empid']);
    $emp_image = '';
    if ($_FILES['emp_image']['name']){

        $image_type = $_FILES['emp_image']['type'];

    if ($image_type == 'image/png' || $image_type == 'image/jpeg' || $image_type == 'image/jpg') {

        $sql = "SELECT emp_image FROM  tblemployees WHERE id=:eid";
        $query = $dbh->prepare($sql);
        $query ->bindParam(':eid',$eid, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        if($query->rowCount() > 0)
        {
            foreach($results as $result)
            {
                $dir = '../assets/profile_photo/'. $result->emp_image;
                unlink($dir);
            }}

        $emp_image = upload();

    }else {

        $error = " Only JPEG, PNG or JPG Format Allowed";

        $emp_image = $_POST['emp_photo'];
    }

    }else{

        $emp_image = $_POST['emp_photo'];
    }


    $first_name = $_POST['firstName'];
    $last_name = $_POST['lastName'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $department = $_POST['department'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $mobileno = $_POST['mobileno'];


    $sql = "UPDATE  tblemployees SET FirstName=:fname,LastName=:lname,
        Gender=:gender,Dob=:dob,Department=:department,
        Address=:address,City=:city,Country=:country,Phonenumber=:mobileno,emp_image=:emp_image
         WHERE id=:eid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':fname', $first_name, PDO::PARAM_STR);
    $query->bindParam(':lname', $last_name, PDO::PARAM_STR);
    $query->bindParam(':gender', $gender, PDO::PARAM_STR);
    $query->bindParam(':dob', $dob, PDO::PARAM_STR);
    $query->bindParam(':department', $department, PDO::PARAM_STR);
    $query->bindParam(':address', $address, PDO::PARAM_STR);
    $query->bindParam(':city', $city, PDO::PARAM_STR);
    $query->bindParam(':country', $country, PDO::PARAM_STR);
    $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
    $query->bindParam(':emp_image', $emp_image, PDO::PARAM_STR);
    $query->bindParam(':eid', $eid, PDO::PARAM_STR);

    if ($query->execute()) {

        $msg = " Employee record updated Successfully";
    }



}

    ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        
        <!-- Title -->
        <title>Admin | Update Employee</title>

        <?php  include('../includes/metatag.php');?>
        
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css"/>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet"> 
        <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/custom.css" rel="stylesheet" type="text/css"/>
  <style>
        .errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
        </style>



    </head>
    <body>
  <?php include('includes/header.php');?>
            
       <?php include('includes/sidebar.php');?>
   <main class="mn-inner">
                <div class="row">
                    <div class="col s12">
                        <div class="page-title">Update employee</div>
                    </div>
                    <div class="col s12 m12 l12">
                        <div class="card">
                            <div class="card-content">
                                <form id="example-form" method="post" name="updatemp" enctype="multipart/form-data">
                                    <div>

                                           <?php if(isset($error)){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php }
                else if($msg){?><div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                                        <section>
                                            <div class="wizard-content">
                                                <div class="row">
                                                    <div class="col m6">
                                                        <div class="row">
                            <?php
                            $eid = intval($_GET['empid']);
                            $sql = "SELECT * FROM  tblemployees WHERE id=:eid";
                            $query = $dbh->prepare($sql);
                            $query ->bindParam(':eid',$eid, PDO::PARAM_STR);
                            $query->execute();
                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                            $cnt=1;
                            if($query->rowCount() > 0)
                            {
                            foreach($results as $result)
                            {


                                ?>

 <div class="input-field col  s12">
<label for="empcode">Employee Code</label>
<input  name="empcode" id="empcode" value="<?php echo htmlentities($result->EmpId);?>" type="text" autocomplete="off" readonly required>
<span id="empid-availability" style="font-size:12px;"></span> 
</div>


<div class="input-field col m6 s12">
<label for="firstName">First name</label>
<input id="firstName" name="firstName" value="<?php echo htmlentities($result->FirstName);?>"  type="text" required>
</div>

<div class="input-field col m6 s12">
<label for="lastName">Last name </label>
<input id="lastName" name="lastName" value="<?php echo htmlentities($result->LastName);?>" type="text" autocomplete="off" required>
</div>

<div class="input-field col s12">
<label for="email">Email</label>
<input  name="email" type="email" id="email" value="<?php echo htmlentities($result->EmailId);?>" readonly autocomplete="off" required>
<span id="emailid-availability" style="font-size:12px;"></span> 
</div>

<div class="input-field col s12">
<label for="phone">Mobile number</label>
<input id="phone" name="mobileno" type="tel" value="<?php echo htmlentities($result->Phonenumber);?>" maxlength="10" autocomplete="off" required>
 </div>

                                                            <div class="input-field col s12">

                                                                <label for="phone">Profile Picture</label>
                                                                <br />
                                                                <br />
                                                                <?php
                                                                if ($result->emp_image == NULL){

                                                                    echo  '<img src="../assets/images/noimage.png" class="circle" alt="" style="width:100px;height:100px;">';

                                                                }else{

                                                                    echo  '<img src="../assets/profile_photo/'.$result->emp_image.'" class="circle" alt="" style="width:100px;height:100px;">';
                                                                }?>
                                                                <br />
                                                                <input id="emp_image" name="emp_image" type="file" accept=".png,.jpeg,.jpg">

                                                                <input type="hidden" name="emp_photo" value="<?php echo htmlentities($result->emp_image);?>">


                                                            </div>


                                                        </div>
</div>



<div class="col m6">
<div class="row">
<div class="input-field col m6 s12">
    <label for="sex">Sex</label>
    <br />
<select  name="gender" autocomplete="off">
<option value="<?php echo htmlentities($result->Gender);?>"><?php echo htmlentities($result->Gender);?></option>                                          
<option value="Male">Male</option>
<option value="Female">Female</option>
<option value="Other">Other</option>
</select>
</div>

<div class="input-field col m6 s12">
<label for="birthdate">Date of Birth</label>

    <input id="birthdate" type="date" class="datepicker" name="dob" value="<?php echo htmlentities($result->Dob);?>">
</div>

                                                    

<div class="input-field col m6 s12">
    <label for="department">Department</label>
    <br />
<select  name="department" autocomplete="off">

<option value="<?php echo htmlentities($result->Department);?>"><?php echo htmlentities($result->Department);?></option>

    <?php

    $sql = "SELECT DepartmentName FROM tbldepartments";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $cnt = 1;
    if($query->rowCount() > 0)
    {
    foreach($results as $resultt)
    {   ?>
<option value="<?php echo htmlentities($resultt->DepartmentName);?>"><?php echo htmlentities($resultt->DepartmentName);?></option>
<?php }} ?>
</select>
</div>

<div class="input-field col m6 s12">
<label for="address">Address</label>
<input id="address" name="address" type="text"  value="<?php echo htmlentities($result->Address);?>" autocomplete="off" required>
</div>

<div class="input-field col m6 s12">
<label for="city">City/Town</label>
<input id="city" name="city" type="text"  value="<?php echo htmlentities($result->City);?>" autocomplete="off" required>
 </div>
   
<div class="input-field col m6 s12">
<label for="country">Country</label>
<input id="country" name="country" type="text"  value="<?php echo htmlentities($result->Country);?>" autocomplete="off" required>
</div>

                                                            
<?php

}}?>
                                                        
<div class="input-field col s12">
<button type="submit" name="update"  id="update" class="waves-effect waves-light btn  m-b-xs">UPDATE</button>

</div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                     
                                    
                                        </section>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div class="left-sidebar-hover"></div>
        
        <!-- Javascripts -->
        <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="../assets/js/alpha.min.js"></script>
        <script src="../assets/js/pages/form_elements.js"></script>
        
    </body>
</html>
<?php } ?> 