<?php
header('Content-Type:application/json');
require 'dbconnect.php';

// $total_bar = "SELECT p.project_name,t.project_id,t.task_id,a.activity_id,a.activity_progress
// FROM project_create AS p
// LEFT JOIN task as t on t.project_id = p.project_id
// LEFT JOIN activity AS a on a.task_id = t.task_id";

// $id_sql = "SELECT project_id
// FROM project_create";
// $que = mysqli_query($con,$id_sql);
// while ($task = mysqli_fetch_assoc($que)) {  
//      $id =$task['project_id'];
//     }

    $sql = "SELECT p.project_name,t.project_id,t.task_id,a.activity_id,a.activity_progress
FROM project_create AS p
LEFT JOIN task as t on t.project_id = p.project_id
LEFT JOIN activity AS a on a.task_id = t.task_id
order by t.project_id";

$result=mysqli_query($con,$sql);
$data = array();

foreach ($result as $row) {
    $data[] = $row;
}
mysqli_close($con);


echo json_encode($data);



?>