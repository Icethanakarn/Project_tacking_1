<?php
// เพิ่มActivity
require('dbconnect.php');
$idact = $_POST['act_name']; //รับข้อมูลจากหน้าTaskเพื่อเป็นModalเพิ่มActivity
$task_id = $_POST['task_act'];
// print_r($_POST);
// exit;
$sql = "INSERT INTO activity (activity_name,task_id) VALUES ('$idact','$task_id')";
$result = mysqli_query($con,$sql);

if($result){
    header("location:task.php");

}
else{
    echo "เกิดข้อผิดพลาด";
}
?>