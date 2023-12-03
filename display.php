<?php
require('dbconnect.php');
require('func.php');
// error_reporting(0);
// Queryแสดงผลตาราง
$sql2 = " SELECT project_create.project_name,task.task_name,task.task_id,project_create.create_time,project_create.dead_line,project_create.detail,employees.emp_fname,employees.emp_lname,project_create.create_by,project_create.project_id,project_create.owner
FROM task
right JOIN  project_create ON project_create.project_id = task.project_id
right JOIN  employees ON project_create.owner = employees.emp_id 
WHERE project_create.detail IS null OR project_create.status NOT IN(0)
GROUP BY project_create.project_id";
$result_task = mysqli_query($con, $sql2);
$order = 1;




// $total_bar = "SELECT p.project_name,t.project_id,t.task_id,a.activity_id
// FROM project_create AS p
// LEFT JOIN task as t on t.project_id = p.project_id
// LEFT JOIN activity AS a on a.task_id = t.task_id";




$color = 'btn-success';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display</title>

    <!-- bootstrap -->
    <link rel="stylesheet" href="/bootstrap-5.2.3/dist/css/bootstrap.min.css">
    <script src="bootstrap-5.2.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="icons-1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <!-- End bootstrap -->

    <!-- datatable -->
    <link rel="stylesheet" href="datatable/boostrap.min.css">
    <link rel="stylesheet" href="datatable/dataTables.bootstrap5.min.css">
    <script src="jquery/jquery-3.5.1.min.js"></script>
    <script src="datatable/jquery.dataTables.min.js"></script>
    <script src="datatable/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="datatable/responsive.dataTables.min.css">
    <script src="datatable/dataTables.responsive.min.js"></script>
    <!-- End datatable -->


    <!-- select 2 -->
    <link rel="stylesheet" href="select2-develop/dist/css/select2.min.css">
    <script src="select2-develop/dist/js/select2.min.js"></script>
    <script src="select2-develop/dist/js/boostrap.bundle.min.js"></script>
    <link rel="stylesheet" href="select2-develop/dist/css/select2-bootstrap-5-theme.min.css">
    <!-- End select 2 -->


</head>

<body>
    <script>
        // สร้างDataTable
        $(document).ready(function() {
            var table = $('#myTable').DataTable({
                responsive: true,

                "columnDefs": [{
                        // progress_Bar
                        "targets": 7,
                        "render": function(data, type, row, meta) {
                            return '<div class="progress mt-3">' +
                                '<div class="progress-bar bg-success" role="progressbar" style="width: ' + data + '%;" aria-valuenow="' + data + '" aria-valuemin="0" aria-valuemax="100">' + data + '%' +
                                '</div>' +
                                '</div>';
                        }
                    },
                    {
                        // ช่องคำอธิบายมีตัวอักษรไม่เกิน 20 ตัว
                        "targets": 4,
                        "data": "description",

                        "render":

                            function(data, type, row, meta) {
                                return type === 'display' && data.length > 20 ?
                                    '<span title="' + data + '">' + data.substr(0, 20) + '...</span>' :
                                    data;
                            }

                    }
                ],


            });

        });
    </script>
    <?php
    include 'nav.php';

    ?>
    <div class="container-fulid">

        <!-- //สร้างการ์ด -->
        <div class="container-fluid mt-3 p-4  ">

            <div class="dropdown d-flex justify-content-end mb-2 ">
                <button class="btn btn-primary " dropdown-toggle type="button" data-bs-toggle="dropdown" aria-expanded="false">
                   Fillter Project
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="display.php">Default</a></li>
                    <li><a class="dropdown-item" href="display.php?status=1">Complete</a></li>
                    <li><a class="dropdown-item" href="display.php?status=2">InComplete</a></li>
                </ul>
            </div>

            <table id="myTable" class="table table-striped table-bordered display responsive nowrap  ">
                <thead class="table-dark text-center">
                    <tr class="text-center">
                        <th class="text-center">ลำดับที่</th>
                        <th class="text-center">ชื่อโปรเจค</th>
                        <th class="text-center">ดูรายละเอียดโปรเจค</th>
                        <th class="text-center">เจ้าของโปรเจค</th>
                        <th class="text-center text-break">คำอธิบายโปรเจค</th>
                        <th class="text-center">วันที่เริ่มโปรเจค</th>
                        <th class="text-center">วันที่สิ้นสุดโปรเจค</th>
                        <th class="text-center">ความคืบหน้าโดยรวม</th>


                    </tr>

                </thead>
                <tbody class="text-break">
                    <?php
                    //แสดงผลข้อมูลในฐานข้อมูล
                    while ($task = mysqli_fetch_assoc($result_task)) {
                        $id = $task['project_id']; ?>

                        <!-- <tr>

                            <td class="text-end">< ?php echo $order++ ?></td>
                            <td class=""><?php echo $task['project_name'] ?></td>
                            <td class="text-center"> <a href="mainpage.php?idp=<?php echo $task['project_id'] ?>" class="btn btn-info"><i class="bi bi-info-circle-fill"></i> ดูรายละเอียด</a>

                            </td>
                            <td><?php echo $task['emp_fname'] . " " . $task['emp_lname'] ?></td>
                            <td><?php echo $task['detail'] ?></td>
                            <td class="text-success fw-bold"><?php echo date("d/m/Y ", strtotime($task['create_time'])) ?></td>
                            <td class="text-danger fw-bold"><?php echo date("d/m/Y ", strtotime($task['dead_line'])) ?></td>


                            <?php
                            //    ส่วนของการคำนวณProgress_bar
                            $progess_bar = Total_progress($id);
                            ?>

                            <td><?= intval($progess_bar) ?></td>



                            </tr> -->
                        <?php 
                         if (!isset($_GET['status'])) {

                                echo ' <tr>
                                <td class="text-end"> '.$order++.' </td>
                                <td class=""> '.$task["project_name"].' </td>
                                <td class="text-center"> <a href="mainpage.php?idp='.$task["project_id"].' " class="btn btn-info"><i class="bi bi-info-circle-fill"></i> ดูรายละเอียด</a>
    
                                </td>
                                <td> '.$task["emp_fname"].'  '.$task["emp_lname"].' </td>
                                <td> '.$task["detail"].' </td>
                                <td class="text-success fw-bold">'.date("d/m/Y", strtotime($task["create_time"])).'</td>
                                <td class="text-danger fw-bold">'.date("d/m/Y", strtotime($task["dead_line"])).'</td>
    
    
                                <?php
                                //    ส่วนของการคำนวณProgress_bar
                               ' .$progess_bar = Total_progress($id).'
                                ?>
    
                                <td> '.intval($progess_bar).' </td>

                                </tr>';
                                 
                        }
                        
                        
                        if (isset($_GET['status']) && $_GET['status'] == '1') {
                            
                            $check =  fillter($id);
                            
                            if ($check == 100) {
                                echo ' <tr>
                                <td class="text-end"> '.$order++.' </td>
                                <td class=""> '.$task["project_name"].' </td>
                                <td class="text-center"> <a href="mainpage.php?idp='.$task["project_id"].' " class="btn btn-info"><i class="bi bi-info-circle-fill"></i> ดูรายละเอียด</a>
    
                                </td>
                                <td> '.$task["emp_fname"].'  '.$task["emp_lname"].' </td>
                                <td> '.$task["detail"].' </td>
                                <td class="text-success fw-bold">'.date("d/m/Y", strtotime($task["create_time"])).'</td>
                                <td class="text-danger fw-bold">'.date("d/m/Y", strtotime($task["dead_line"])).'</td>
    
    
                                <?php
                                //    ส่วนของการคำนวณProgress_bar
                               ' .$progess_bar = Total_progress($id).'
                                ?>
    
                                <td> '.intval($progess_bar).' </td>
    
    
    
                                </tr>';
                                echo $check;    
                        }
                        
                        }
                     
                    if (isset($_GET['status']) && $_GET['status'] == '2') {
                            
                        $incomplete =  fillterInComplete($id);
                        
                        if ($incomplete) {
                            echo ' <tr>
                            <td class="text-end"> '.$order++.' </td>
                            <td class=""> '.$task["project_name"].' </td>
                            <td class="text-center"> <a href="mainpage.php?idp='.$task["project_id"].' " class="btn btn-info"><i class="bi bi-info-circle-fill"></i> ดูรายละเอียด</a>

                            </td>
                            <td> '.$task["emp_fname"].'  '.$task["emp_lname"].' </td>
                            <td> '.$task["detail"].' </td>
                            <td class="text-success fw-bold">'.date("d/m/Y", strtotime($task["create_time"])).'</td>
                            <td class="text-danger fw-bold">'.date("d/m/Y", strtotime($task["dead_line"])).'</td>


                            <?php
                            //    ส่วนของการคำนวณProgress_bar
                           ' .$progess_bar = Total_progress($id).'
                            ?>

                            <td> '.intval($progess_bar).' </td>



                            </tr>';
                               
                    }
                    
                    }
                
                 } ?><!--ปีกกา While -->
                        
                </tbody>
            </table>
            <?php
            // 
            $IdProject = projectId();
            //  echo $IdProject;

            ?>
        </div>
    </div>
</body>
</html>