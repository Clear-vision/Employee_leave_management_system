<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0) {
header('location:index.php');
}
else{

// code for update the read notification status
$isread = 1;
$lid = intval($_GET['leaveid']);
$admremarkdate = date('Y-m-d h:i:s ', strtotime("now"));

$sql = "UPDATE tblleaves SET IsRead=:isread WHERE id=:lid";
$query = $dbh->prepare($sql);
$query->bindParam(':isread',$isread,PDO::PARAM_STR);
$query->bindParam(':lid',$lid,PDO::PARAM_STR);
$query->execute();

// code for action taken on leave
if(isset($_POST['update'])) {

$lid = intval($_GET['leaveid']);
$description = $_POST['description'];
$status = $_POST['status'];
date_default_timezone_set('UTC');
$admremarkdate = date('Y-m-d h:i:s ', strtotime("now"));

$sql = "UPDATE tblleaves SET AdminRemark=:description,
     Status=:status,AdminRemarkDate=:admremarkdate WHERE id=:did";
$query = $dbh->prepare($sql);
$query->bindParam(':description',$description,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':admremarkdate',$admremarkdate,PDO::PARAM_STR);
$query->bindParam(':did',$lid,PDO::PARAM_STR);

if($query->execute()) {

    $msg = "Leave updated Successfully";
}
}



 ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        
        <!-- Title -->
        <title>Admin | Leave Details </title>

        <?php  include('../includes/metatag.php');?>
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css"/>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">
        <link href="../assets/plugins/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

                <link href="../assets/plugins/google-code-prettify/prettify.css" rel="stylesheet" type="text/css"/>  
        <!-- Theme Styles -->
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
                        <div class="page-title" style="font-size:24px;">Leave Details</div>
                    </div>
                   
                    <div class="col s12 m12 l12">
                        <div class="card">
                            <div class="card-content">

                                <?php if($msg){?><div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                                <table id="example" class="display responsive-table ">
                               
                                 
                                    <tbody>
                                    <?php
                                    $lid = intval($_GET['leaveid']);
                                    $sql = "SELECT tblleaves.id AS lid,tblemployees.FirstName,
                                           tblemployees.LastName,tblemployees.emp_image,tblemployees.EmpId,tblemployees.id,
                                           tblemployees.Gender,tblemployees.Phonenumber,tblemployees.EmailId,
                                           tblleaves.LeaveType,tblleaves.ToDate,tblleaves.FromDate,
                                           tblleaves.Description,tblleaves.PostingDate,tblleaves.Status,
                                           tblleaves.AdminRemark,tblleaves.AdminRemarkDate FROM tblleaves 
                                           JOIN tblemployees ON tblleaves.empid=tblemployees.id WHERE tblleaves.id=:lid";
                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':lid',$lid,PDO::PARAM_STR);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;
                                    if($query->rowCount() > 0)
                                    {
                                    foreach($results as $result)
                                    {
                                          ?>

                                        <tr>
                                            <td><?php if ($result->emp_image != ""){ ?><img src="../assets/profile_photo/<?php echo htmlentities($result->emp_image);?>" class="circle" alt="" style="width:100px;height:100px;"><?php }?></td>
                                            <td style="font-size:16px;"> <b>Employee's Name :</b></td>
                                              <td><a href="editemployee.php?empid=<?php echo htmlentities($result->id);?>" target="_blank">
                                                <?php echo htmlentities($result->FirstName." ".$result->LastName);?></a></td>
                                              <td style="font-size:16px;"><b>Employee's Id :</b></td>
                                              <td><?php echo htmlentities($result->EmpId);?></td>
                                              <td style="font-size:16px;"><b>Gender :</b></td>
                                              <td><?php echo htmlentities($result->Gender);?></td>
                                          </tr>

                                          <tr>
                                             <td style="font-size:16px;"><b>Employee's Email id:</b></td>
                                            <td><?php echo htmlentities($result->EmailId);?> </td>
                                             <td style="font-size:16px;"> <b>Employee's Contact Number:</b> </td>
                                            <td> <?php echo htmlentities($result->Phonenumber);?></td>
                                            <td>&nbsp;</td>
                                             <td>&nbsp;</td>
                                        </tr>

  <tr>
                                             <td style="font-size:16px;"><b>Leave Type:</b></td>
                                            <td><?php echo htmlentities($result->LeaveType);?></td>
                                             <td style="font-size:16px;"><b>Leave Date:</b></td>
                                            <td>From <?php echo htmlentities(date('F d, Y',strtotime($result->FromDate)));?> To <?php echo htmlentities(date('F d, Y',strtotime($result->ToDate)));?></td>
                                            <td style="font-size:16px;"><b>Posting Date</b></td>
                                           <td><?php echo htmlentities(date('F d, Y h:i:s A',strtotime($result->PostingDate)));?></td>
                                        </tr>

<tr>
                                             <td style="font-size:16px;"><b>Employee's Leave Description: </b></td>
                                            <td colspan="5"><?php echo htmlentities($result->Description);?></td>
                                          
                                        </tr>

<tr>
<td style="font-size:16px;"><b>leave Status :</b></td>
<td colspan="5"><?php $stats=$result->Status;
if($stats==1){
?>
<span style="color: green">Approved</span>
 <?php } if($stats==2)  { ?>
<span style="color: red">Not Approved</span>
<?php } if($stats==0)  { ?>
 <span style="color: blue">waiting for approval</span>
 <?php } ?>
</td>
</tr>

<tr>
<td style="font-size:16px;"><b>Admin's Remark: </b></td>
<td colspan="5"><?php
if($result->AdminRemark==""){
  echo "waiting for Approval";  
}
else{
echo htmlentities($result->AdminRemark);
}
?></td>
 </tr>

 <tr>
<td style="font-size:16px;"><b>Admin Action taken date: </b></td>
<td colspan="5"><?php
if($result->AdminRemarkDate==""){
  echo "NA";  
}
else{
echo htmlentities(date('F d, Y h:i:s A',strtotime($result->AdminRemarkDate)));
}
?>|<?php if($stats == 1){?> <a class="modal-trigger waves-effect waves-light btn" href="print_leave_letter.php?generate_letter=<?php echo htmlentities($result->lid);?>" target="_blank">Print</a><?php } ?> </td>
 </tr>

<?php 
if($stats == 0)
{

?>
<tr>
 <td colspan="5">
  <a class="modal-trigger waves-effect waves-light btn" href="#modal1">Take&nbsp;Action</a>
<form name="adminaction" method="post">
<div id="modal1" class="modal modal-fixed-footer" style="height: 60%">
    <div class="modal-content" style="width:90%">
        <h4>Leave take action</h4>
          <select class="browser-default" name="status" required="">
                                            <option value="">Choose your option</option>
                                            <option value="1">Approved</option>
                                            <option value="2">Not Approved</option>
                                        </select></p>
                                        <p><textarea id="textarea1" name="description" class="materialize-textarea" name="description" placeholder="Description" length="500" maxlength="500" required></textarea></p>
    </div>
    <div class="modal-footer" style="width:90%">
       <input type="submit" class="waves-effect waves-light btn  m-b-xs" name="update" value="Submit">
    </div>

</div>   

 </td>
</tr>
<?php } ?>
   </form>                                     </tr>
                                         <?php $cnt++;} }?>
                                    </tbody>
                                </table>
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
        <script src="../assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../assets/js/alpha.min.js"></script>
        <script src="../assets/js/pages/table-data.js"></script>
         <script src="assets/js/pages/ui-modals.js"></script>
        <script src="assets/plugins/google-code-prettify/prettify.js"></script>
        
    </body>
</html>
<?php } ?>