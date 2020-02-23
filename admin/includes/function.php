<?php
/**
 * Created by PhpStorm.
 * User: 05
 * Date: 2/16/2020
 * Time: 1:34 PM
 */
if(strlen($_SESSION['alogin'])==0){

    header('location:index.php');

}else{

    function upload()
    {

            $extension = explode(".", $_FILES['emp_image']['name']);
            $emp_image = rand() . "." . $extension[1];
            $destination = '../assets/profile_photo/' . $emp_image;
            move_uploaded_file($_FILES['emp_image']['tmp_name'], $destination);


        return $emp_image;
    }

}
