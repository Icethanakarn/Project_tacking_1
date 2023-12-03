<?php
// ลบActivity
require("dbconnect.php");
$pro =$_GET['idp'];
$task = $_GET["idact"]; ///เอามาจากปุ่มลบในModalActivity
$actModal = $_GET["idact"]; ///เอามาจากปุ่มลบในModalMainPage

if(isset($task)){
    $sql = "UPDATE activity SET status =0
WHERE activity_id =$task ";
$result = mysqli_query($con,$sql);

if($result){
    header("location:tem_task.php");
 
}
else{
    echo "เกิดข้อผิดพลาด";
}
}

if(isset($actModal)){
    $sql = "UPDATE activity SET status =0
WHERE activity_id =$actModal";
$result = mysqli_query($con,$sql);
// echo $actModal;
if($result){
    header("location:tem_mainpage.php?idp=".$pro);
 
}
else{
    echo "เกิดข้อผิดพลาด";
}
}

?>