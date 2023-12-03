<?php
require('dbconnect.php');
$id = $_POST['idedit']; //โปรเจคId
$pname = $_POST['project_Name']; //ชื่อโปรเจค
$owner =$_POST['owner']; //ชื่อเจ้าของโปรเจค
$date = $_POST['dead_line']; //กำหนดเวลาของโปรเจค
$updateTime = $_POST['update_time']; //กำหนดเวลาของโปรเจค
$update_By = $_POST['update_by'];//ชื่อคนที่อัปเดต
$datail =$_POST['detail'];
// print_r($_POST);
// exit;
$sql = "UPDATE project_create
SET project_name='$pname',owner='$owner',dead_line='$date',update_time='$updateTime',update_by='$update_By',detail='$datail'
WHERE project_id = $id ";


$result = mysqli_query($con,$sql);
if($result){
    header('location:tem_mainpage.php?idp='.$_POST['idedit']);
   

}else{
    mysqli_error($con);
}

?>