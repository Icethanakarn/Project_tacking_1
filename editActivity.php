<?php
require ('dbconnect.php');
$task_id =$_POST['task_id'];
$act_id = $_POST['act_id'];
$eAct_id =$_POST['edit_act'];
$proj_id =$_POST['pro_id'];
$edit_by =$_POST['edit_by'];
$sql = "UPDATE activity 
SET activity_name = '$eAct_id'
WHERE activity_id =$act_id and task_id = $task_id";
// print_r($_POST);
// exit;
$result =mysqli_query($con,$sql);


if($result){
  $history_edit ="INSERT INTO history_edit_activity(edit_by,activity_id,activity_name) 
  VALUE('$edit_by','$act_id','$eAct_id')";
$history_query = mysqli_query($con,$history_edit);
// print_r($_POST);
// exit;

if($history_query){
    header("location:tem_mainpage.php?idp=".$proj_id);
}
 }else{
     mysqli_error($con);
 }





?>