<?php
session_start();
error_reporting(0);
include('admin/includes/config.php');
if(strlen($_SESSION['emplogin'])==0)
    {   
header('location:index.php');
}
else{

    // code for update the read notification status
    if (isset($_GET["leaveid"])) {
        $emp_read_status = 'seen';
        $lid = intval($_GET['leaveid']);
        $emp_read_date = date('Y-m-d h:i:s', strtotime("now"));

        $sql = "UPDATE tblleaves SET emp_read_status = :emp_read_status,
               emp_read_date = :emp_read_date WHERE id=:lid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':emp_read_status', $emp_read_status, PDO::PARAM_STR);
        $query->bindParam(':emp_read_date', $emp_read_date, PDO::PARAM_STR);
        $query->bindParam(':lid', $lid, PDO::PARAM_STR);
        $query->execute();
    }
 ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        
        <!-- Title -->
        <title>Employee | Leave History</title>

        <?php  include('includes/metatag.php');?>
        
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="assets/plugins/materialize/css/materialize.min.css"/>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">
        <link href="assets/plugins/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

            
        <!-- Theme Styles -->
        <link href="assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css"/>
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
                        <div class="page-title">Leave History</div>
                    </div>

                    <div class="col s12 m12 l12">
                        <div class="card">
                            <div class="card-content">

                                <?php if($msg){?><div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                                <table id="example" class="display responsive-table">
                                    <thead>
                                        <tr>
                                            <th width="50">S/N</th>
                                            <th width="120">Leave Type</th>
                                            <th>From</th>
                                            <th>To</th>
                                             <th>Description</th>
                                             <th width="120">Posting Date</th>
                                            <th width="200">Admin Remak</th>
                                            <th>Status</th>
                                            <th>Print</th>
                                        </tr>
                                    </thead>
                                 
                                    <tbody>
                <?php
                $eid =  $_SESSION['eid'];
                $sql = "SELECT id,LeaveType,ToDate,FromDate,Description,
                       PostingDate,AdminRemarkDate,AdminRemark,Status 
                       FROM tblleaves WHERE empid=:eid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':eid',$eid,PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $cnt=1;
                if($query->rowCount() > 0)
                {
                foreach($results as $result)
                {               ?>
                                        <tr>
                                            <td> <?php echo htmlentities($cnt);?></td>
                                            <td><?php echo htmlentities($result->LeaveType);?></td>
                                            <td><?php echo htmlentities(date('F d, Y',strtotime($result->FromDate)));?></td>
                                            <td><?php echo htmlentities(date('F d, Y',strtotime($result->ToDate)));?></td>
                                           <td><?php echo htmlentities($result->Description);?></td>
                                            <td><?php echo htmlentities(date('F d, Y - h:i:s A',strtotime($result->PostingDate)));?></td>
                                            <td><?php if($result->AdminRemark=="")
                                            {
echo htmlentities('waiting for approval');
                                            } else
{

 echo htmlentities(($result->AdminRemark)." "."at"." ".date('F d, Y - h:i:s A',strtotime($result->AdminRemarkDate)));
}

                                            ?></td>
                                                                                 <td><?php $stats=$result->Status;
if($stats == 1){
                                             ?>
                                                 <span style="color: green">Approved</span>
                                                 <?php } if($stats==2)  { ?>
                                                <span style="color: red">Not Approved</span>
                                                 <?php } if($stats==0)  { ?>
 <span style="color: blue">waiting for approval</span>
 <?php } ?>

                                             </td>
                                            <td><?php if($stats == 1){?><a class="modal-trigger waves-effect waves-light btn" href="admin/print_leave_letter.php?generate_letter=<?php echo htmlentities($result->id);?>" target="_blank">Print</a><?php }?> </td>
                                        </td>
          
                                        </tr>
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
        <script src="assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
        <script src="assets/js/alpha.min.js"></script>
        <script src="assets/js/pages/table-data.js"></script>
        
    </body>
</html>
<?php } ?>