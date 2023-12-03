<?php
require('dbconnect.php');


$sql = "SELECT * FROM create_project";
$result = mysqli_query($con,$sql);

$row = mysqli_fetch_assoc($result);
print_r($row);
echo $row['project_name'];
?>