
<?php
// ลบTask
require("dbconnect.php");
$task = $_GET["idtask"]; ///เอามาจากปุ่มลบในหน้าTask
// print_r($_GET);
// exit;

$sql = "UPDATE task SET status =0
WHERE task_id =$task ";
$result = mysqli_query($con,$sql);

if($result){
    header("location:task.php");
 
}
else{
    echo "เกิดข้อผิดพลาด";
}

?>