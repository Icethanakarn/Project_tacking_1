<?php
header('Content-Type:application/json');
require 'dbconnect.php';

// $sql = "SELECT activity_name,activity_progress 
// FROM activity 
// WHERE activity_progress NOT IN(0)
// ORDER BY activity_id";
$sql = "SELECT activity_progress,task_id,activity_name
FROM activity 
WHERE activity_progress  and  task_id = 55" ;
$result = mysqli_query($con, $sql);

$data = array();

foreach ($result as $row) {
    $data[] = $row;
}
mysqli_close($con);

echo json_encode($data);
