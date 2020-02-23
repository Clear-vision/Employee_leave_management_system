<?php
/**
 * Created by PhpStorm.
 * User: 05
 * Date: 2/15/2020
 * Time: 12:49 PM
 */
include('includes/config.php');

if (isset($_GET["generate_letter"])) {


    require_once '../assets/mpdf/vendor/autoload.php';

    $mpdf = new \Mpdf\Mpdf();

                          $lid = intval($_GET['generate_letter']);
                          $sql = "SELECT tblleaves.id AS lid,tblemployees.FirstName,
                          tblemployees.LastName,tblemployees.EmpId,tblemployees.id,
                          tblemployees.Gender,tblemployees.Phonenumber,tblemployees.EmailId,
                          tblleaves.LeaveType,tblleaves.ToDate,tblleaves.FromDate,
                          tblleaves.Description,tblleaves.PostingDate,tblleaves.Status,
                          tblleaves.AdminRemark,tblleaves.AdminRemarkDate FROM tblleaves 
                          JOIN tblemployees ON tblleaves.empid=tblemployees.id WHERE tblleaves.id=:lid";
$query = $dbh->prepare($sql);
$query->bindParam(':lid',$lid,PDO::PARAM_STR);
$query->execute();
$rows = $query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0) {

foreach ($rows as $row) {
    $content = '
    
      <h4>REF No.' . $row->lid . ',</h4>
      <h4>' . $row->FirstName . ' ' . $row->LastName . ',</h4>
      <h4>' . $row->EmpId .',</h4>
      <h4>' . $row->EmailId . ',</h4>
      <H4>' . date('F d, Y',strtotime($row->PostingDate)) . '</H4>
      
     <br />
      <h4>CLEARVISION COMPANY,</h4>
      <h4>P.O.BOX 3345,</h4>
      <h4>SHABAAN ROBERT STREET,</h4>
      <H4>DAR ES SALAAM</H4>
      
      <p>Dear Sir/Madam.</p> 
         
          <h3 align="center">REF: <u> <span style="text-transform: uppercase">' . $row->LeaveType . '</span>  APPLICATION.</u></h3>
          
          <p>The heading above is highly concerned, I would like to apply for ' . $row->LeaveType . ', From 
          ' . $row->FromDate . ' To ' . $row->ToDate . '.</p>
          <p>' . $row->Description . '.</p>
          <p>I hope my application will be considered in time.</p>
          <p>Yours faithfully at work,</p>
          <p>' . $row->FirstName . ' ' . $row->LastName . '</p>
                <h4 align="center" color="red">GRANTED</h4>
          

   ';
}
 }

    $mpdf->AddPage();
    $mpdf->SetTitle("EMPLOYEE'S LEAVE LETTER");
    $mpdf->WriteHTML($content);
    ob_end_clean();
    $mpdf->Output("EMPLOYEE'S LEAVE LETTER.pdf", "I");


}

