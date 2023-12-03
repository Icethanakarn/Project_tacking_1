<?php
require('dbconnect.php');
$team_member = $_POST['emp_id'];
$task_id = $_POST['task_id'];
$project_id = $_POST['idedit'];
$sql = "INSERT INTO team_task (team_member,project_id,task_id) VALUES('$team_member','$project_id','$task_id')";
$result =mysqli_query($con,$sql);
// print_r($_POST);
// exit;


if($result){
    header('location:tem_mainpage.php?idp='.$_POST['idedit']); 

}
else{
    mysqli_error($con);
}

?>
