<?php
require('dbconnect.php');
$pro =$_POST['idp'];
$i = $_POST['act_id'];
$act_name = $_POST['act_name'];
$idupdate = $_POST['act_update'];
$update_by = $_POST['update_by'];
$result_progessBar = $_POST['result_progessBar'];
$prev_value = $_POST['prev_value'];

// print_r($_POST);
// exit;
if($prev_value == $idupdate){
    echo '<script>
      alert("ไม่สามารถกรอกค่าเดิมได้");
      history.back()
    </script>';
    // header("location:mainpage.php?idp=".$_POST['idp']);
}else{
    $sql= "UPDATE activity SET activity_progress ='$idupdate'
    WHERE activity_id = '$i'";
    // echo $sql;
    $result = mysqli_query($con,$sql);
    if($result){
        // รับค่าที่ส่งจากหน้าupprogress
       
       $history ="INSERT INTO history_acitivity (update_by,activity_id,activity_name,act_value) 
        VALUES('$update_by','$i','$act_name','$idupdate')";
        $hisQuery = mysqli_query($con,$history);

        if($hisQuery){
 header("location:tem_mainpage.php?idp=".$_POST['idp']);

        }
    }else{
        mysqli_error($con);
    }
}

   
