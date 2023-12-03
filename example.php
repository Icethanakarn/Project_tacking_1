<?php
require('dbconnect.php');
$sql = "SELECT * FROM team";
$result = mysqli_query($con, $sql);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Example modal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <table class="table">
        <thead>
            <tr>
                <th>team_member</th>
                <th>Project_id</th>
                <th>Task_id</th>
                <th>action</th>
            </tr>
        </thead>

        <tbody>
            
            <tr>
<td>1</td>
<td>2</td>
<td>3</td>
<td><button class="btn btn-primary">view</button></td>
            </tr>

        </tbody>
    </table>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>