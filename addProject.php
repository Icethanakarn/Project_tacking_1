<?php
require('dbconnect.php');
// เพิ่มโปรเจค
$pname = $_POST['project_Name']; //ชื่อโปรเจค
// $fname =$_POST['project_Owner_fname']; //ชื่อเจ้าของโปรเจค
// $lname= $_POST['project_Owner_lname']; //นามสกุลเจ้าของโปรเจค

$ownerId = $_POST['idemp']; //ชื่อเจ้าของโปรเจค
$detail= $_POST['detail']; //รายละเอียดงาน
$date = $_POST['dead_line']; //กำหนดเวลาของโปรเจค
$createby = $_POST['createBy']; //สร้างโดย
$team = $_POST['team']; //สมาชิกทีม

//เลือกลูกทีม
// print_r($_POST);
// exit;

$sql = " INSERT INTO project_create (project_name,owner,detail,dead_line,create_by) VALUE ('$pname','$ownerId','$detail','$date','$createby')";

$result = mysqli_query($con,$sql);



if($result){
// เอาค่าโปรเจคIDล่าสุด
   $que = "SELECT MAX(project_id)
   FROM project_create";
   $result2=mysqli_query($con,$que);
   $t=mysqli_fetch_assoc($result2);
   $maxID=$t['MAX(project_id)']; 


   if($result2){
    //เอาโปรเจคIDล่าสุดและลูปเพื่อสมาชิกภายในทีมออกมา
    foreach($team as $teamNew){
        // echo $teamNew;
        $sql2 = "INSERT INTO team (team_member,project_id )
        VALUES ('$teamNew','$maxID')"; 
        // echo $sql2;
        $result3=mysqli_query($con,$sql2);
    }
   }
header('location:tem_task.php');
}else{
    mysqli_error($con);
}

?>