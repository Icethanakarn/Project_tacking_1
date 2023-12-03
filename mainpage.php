<?php
error_reporting(0);
require('dbconnect.php');
require('func.php');
$id = $_GET['idp'];
$total = 0;
$numTask = 0;
$total_progress = 0;

$order = 1;

$sql2 = "SELECT DISTINCT project_create.project_name, task.task_name, task.task_id, activity.activity_name, activity.activity_progress, project_create.detail, activity.activity_id,project_create.project_id, task.dead_line
FROM task
RIGHT JOIN project_create ON project_create.project_id = task.project_id
RIGHT JOIN activity ON task.task_id = activity.task_id 
WHERE project_create.project_id = $id
ORDER BY task.task_id";

$result_task = mysqli_query($con, $sql2);
// $task_query = mysqli_fetch_assoc($result_task);

$IdTask;
$taskName = "";

// ตารางพนักงาน
$emp = "SELECT t.team_member,t.project_id,emp.emp_fname,emp.emp_lname,task.task_id,task.task_name
FROM team AS t
LEFT JOIN employees AS emp ON emp.emp_id = t.team_member
LEFT JOIN task on task.task_id = t.task_id
WHERE t.project_id=$id
ORDER BY t.team_member ASC";
// SELECT team_member 
// FROM team
// LEFT JOIN employees as emp on emp_code = team_member
$result_emp = mysqli_query($con, $emp);
// echo $emp;
$a = "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project_Page</title>


    <!-- bootstrap -->
    <link rel="stylesheet" href=/bootstrap-5.2.3/dist/css/bootstrap.min.css">
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

    <!-- icon -->
    <link rel="stylesheet" href="Linearicons-Free-v1.0.0/Web Font/style.css">
    <!--End icon -->

</head>

<body>
    <script>
        $(document).ready(function() {
            // modal หน้าแก้ไขรายละเอียดทั้งหมด
            $("#open_edit").click(function() {

                let idx = $(this).attr('idx');

                $.post("modaledit.php", {
                        id: idx
                    },
                    function(result) {
                        $("#modal_edit").html(result);
                    }
                );


            });
            // modal หน้าแก้ไขActivity
            $(".open_Edact").click(function() {

                let idx = $(this).attr('idx');

                $.post("modalEditActivity.php", {
                        id: idx
                    },
                    function(result) {
                        $("#modal_edit_activity").html(result);
                    }
                );


            });
            // modal update
            $(".open_update").click(function() {

                let idx = $(this).attr('idx');
                let idp = "<?php echo $_GET['idp'] ?>"; //รับค่าจากurl (ที่เป็นตัวอักษรมาเก็บในตัวแปร)
                $.post("modalupdate.php", {
                        id: idx,
                        idp: idp //กำหนดArttr เพื่อส่งค่าไปหน้าอื่น
                    },
                    function(result) {
                        $("#modal_update").html(result);
                    }
                );


            });
            $(".open_memberTask").click(function() {

                let idx = $(this).attr('idx');
                let idp = "<?php echo $_GET['idp'] ?>"; //รับค่าจากurl (ที่เป็นตัวอักษรมาเก็บในตัวแปร)
                $.post("modalmember.php", {
                        id: idx,
                        idp: idp //กำหนดArttr เพื่อส่งค่าไปหน้าอื่น
                    },
                    function(result) {
                        $("#modal_add_memberTask").html(result);
                    }
                );


            });
            // var groupColumn = 2;
            // สร้างProgress_Bar
            var table = $('#progress').DataTable({

                responsive: true,
                "ordering": false,
                // ที่ต้องใส่ordering เพราะถ้าให้เรียงแบบขึ้นแถวใหม่เป็นเลเวลต้องยกเลิกการเรียงลำดับ

                "processing": true,
                "autoWidth": true,
                "columnDefs": [{
                        "targets": 4,
                },
                    {
                        responsivePriority: 1,
                        targets: 2
                    },
                    {
                        responsivePriority: 2,
                        targets: -1
                    },



                ],

            });

            var teammem = $('#teammem').DataTable({
                scrollY: '40vh',
                scrollCollapse: true,
                paging: false,
                "ordering": false
            });
        });
    </script>

    <?php
    include 'nav.php';
    $detail = detail($id);
    $create_by = create_by($id);
    $update_by = update_by($id);
    $taskDeadLine = taskDeadLine($id);
    

    ?>
    <div class="container-fluid">

        <div class="container-fluid ">
            <section class="row">
                <!-- < ?php  $row = mysqli_fetch_assoc($result)  ?> -->
                <div class="col-md-6 border">
                    <h1 class="text-center">รายละเอียดโปรเจค <?php echo $detail['project_name'] ?></h1>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">ชื่อโปรเจค</span>
                        </div>
                        <input type="text" name="project_Name" class="form-control" placeholder="ป้อนชื่อโปรเจค" readonly value="<?php echo $detail['project_name'] ?>">
                    </div>

                    <div class="input-group mt-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">ชื่อเจ้าของโปรเจค</span>
                        </div>
                        <input type="text" name="project_Owner_fname" class="form-control" placeholder="ป้อนชื่อ" readonly value="<?php echo $detail['owner'] . " " . $detail['emp_fname'] . " " . $detail['emp_lname'] ?>">
                    </div>

                    <div class="input-group mt-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">คนที่สร้างโปรเจค</span>
                        </div>

                        <input type="text" name="project_Owner_fname" class="form-control" placeholder="ป้อนชื่อ" readonly value="<?php echo $create_by['create_by'] . " " . $create_by['emp_fname'] . " " . $create_by['emp_lname'] ?>">

                    </div>

                    <section class="row">
                        <div class="col-md-6 ">
                            <div class="input-group mt-3  ">
                                <div class="input-group-prepend col-12  col-md-4">
                                    <span class="input-group-text ">วันที่โปรเจคต้องเสร็จ</span>
                                </div>
                                <div class="col-12 col-md-8">
                                    <input type="date" name="dead_line" id="" class="form-control " readonly value="<?php echo $detail['dead_line'] ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mt-3 ">
                                <div class="input-group-prepend col-12 col-md-4">
                                    <span class="input-group-text ">วันที่สร้างโปรเจค</span>
                                </div>
                                <div class="col-12 col-md-8">
                                    <input type="timestam" name="c-time" id="" class="form-control " readonly value="<?php echo date("d/m/Y ", strtotime($create_by['create_time'])) ?>">

                                </div>
                            </div>
                        </div>

                    </section>



                    <div class="row">
                        <div class="col-md-6">

                            <div class="input-group mt-3 ">
                                <div class="input-group-prepend col-12 col-md-4 ">
                                    <span class="input-group-text ">วันที่อัพเดทโปรเจค</span>
                                </div>
                                <div class="col-12 col-md-8">
                                    <input type="date" name="u_time" id="" class="form-control" readonly value="<?php echo $update_by['update_time'] ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mt-3">
                                <div class="input-group-prepend col-12 col-md-4">
                                    <span class="input-group-text ">คนที่อัพเดทโปรเจค</span>
                                </div>
                                <div class="col-12 col-md-8">
                                    <input type="text" name="update_by" id="" class="form-control" readonly value="<?php echo $update_by['update_by'] . " " . $update_by['emp_fname'] . " " . $update_by['emp_lname'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mt-3">
                        <textarea class="form-control" placeholder="รายละเอียดงานโปรเจค" id="floatingTextarea" name="detail" readonly><?php echo $detail['detail'] ?></textarea>
                        <label for="floatingTextarea">รายละเอียดงานโปรเจค</label>
                    </div>

                    

                    <div class="d-flex justify-content-end mb-3 ">
                        <a href="#" id="open_edit" class="btn btn-warning mt-3 " data-bs-target="#edit_page" data-bs-toggle="modal" idx="<?php echo $id ?>">แก้ไขรายละเอียด <span class="lnr lnr-pencil fw-bold"></span></a>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="deleteProject.php?iddel=<?php echo $id ?>" class="btn btn-danger" onclick="return confirm('ต้องการลบโปรเจคนี้จริงหรือไม่')">ลบโปรเจค<span class="lnr lnr-trash  "></span>
                            </svg></a>
                    </div>
                    <div class="mt-3">
                        <table class="table table-bordered table-striped " id="teammem">
                            <thead>
                                <tr>
                                    <th>รหัสพนักงาน</th>
                                    <th>ชื่อสมาชิก</th>
                                    <th>งานที่รับผิดชอบ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                foreach ($result_emp as $tem) { ?>
                                    <?php
                                    // ซ่อนชื่อซ้ำ
                                    if ($a == $tem['emp_fname'] . "" . $tem['emp_lname']) {
                                        $b = "";
                                    } else {
                                        $b = '';
                                        $b = $tem['emp_fname'] . "" . $tem['emp_lname'];
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $b ?></td>
                                        <td><?php echo $b; ?></td>
                                        <td>
                                            <ul>
                                                <li><?php echo $tem['task_name'] ?></li>
                                            </ul>
                                        </td>
                                    </tr>

                                <?php $a = $tem['emp_fname'] . "" . $tem['emp_lname'];
                                } ?>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Start ส่วนของการแสดงรายละเอียดงานและอัพความคืบหน้า -->
                <div class=" mt-3 col-md-6">
                    <h2 class="text-center">รายละเอียดงาน</h2>
                    <div>
                        <table class=" table table-light  mt-2 display responsive nowrap" id="progress">
                            <thead class="table-dark">
                                <tr>
                                    <th>ลำดับที่</th>
                                    <th>ชื่องาน</th>
                                    <th>กิจกรรมย่อย</th>
                                    <th>Action</th>
                                    <th>ความคืบหน้ากิจกรรมย่อย</th>
                                    <th>ความคืบหน้าทั้งหมด</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($task = mysqli_fetch_assoc($result_task)) { ?>


                                    <?php
                                    if ($taskName != $task['task_name']) {
                                        echo '<tr class="table-secondary">';
                                        echo '<td class="text-end">' . $order++ . '</td>';
                                        echo '<td><h5>' . $task["task_name"] . '</h5></td>';
                                        echo '<td></td>
                                            <td></td>
                                            <td></td>';

                                        $progress = progress_Bar($task['task_id']);
                                        if ($prev == $progress) {
                                            echo '<td></td>';
                                        } else {
                                            echo '<td> ' . $display =perProgess($progress,$dateNow,$deadLine) . '</td>';
                                        }
                                        $prev = $progress;
                                        echo '</tr>';
                                    } ?>

                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td><?= $task["activity_name"]; ?></td>
                                        <?php if ($task['activity_progress'] == 100) {
                                            $dateNow = strtotime('now');
                                            $deadLine = strtotime($taskDeadLine['dead_line']);
                                             $st2 = date('d/m/Y', $deadLine);
                                            if($dateNow<=$deadLine){
                                                echo '<td class="text-success">
                                                <p class="fw-bolder text-uppercase">Complete</p>';
                                           echo '</td>';
                                            }else{
                                                echo '<td class="text-danger">
                                                <p class="fw-bolder text-uppercase">Overtime</p>';
                                           echo '</td>';
                                            }
                                          
                                        } else {
                                            echo '<td> <a href="#" class=" btn btn-success open_update " data-bs-toggle="modal" idx="' . $task["activity_id"] . '" data-bs-target="#add_update"><span class="lnr lnr-sync fw-bold"></span>
                                                </a>';

                                            echo ' <a href="#" class="btn bg-warning open_Edact" data-bs-target="#edit_activity" data-bs-toggle="modal" idx=" ' . $task["activity_id"] . ' "><span class="lnr lnr-pencil fw-bold"></span></a></td>';
                                        }


                                        ?>
                                        <td><?php echo $display =perProgess($task['activity_progress'],$dateNow,$deadLine);  ?></td>
                                        <td></td>
                                    </tr>
                                <?php
                                    //   ความคืบหน้าโปรเจคทั้งหมด
                                    //    echo $task['activity_id'];
                                    $taskName = $task['task_name'];

                                    $progress_proj = Total_progress($id);
                                }
                                ?>

                                <?php
                                //ตัวแปรที่เก็บค่าสูตรคำนวณโดยวิธีคิด จำนวนActtivityทั้งหมด*100/จำนวนแถวทั้งหมด
                                if ($progress_proj == 0) { ?>

                                    <div id="detailProgress">
                                        <h3 class="text-decoration-underline badge bg-secondary text-wrap">ความคืบหน้าของโปรเจคโดยรวม</h3>
                                        <div class="progress mb-3" role="progressbar" aria-label="Info example " aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="height: 1.5rem;">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated " style="width:0%">0
                                            </div>
                                        </div>
                                    </div>
                                <?php  } else {

                                    //  คำสั่งQueryคำนวณ
                                ?>
                                    <div id="detailProgress">
                                        <input type="hidden" name="result_progessBar" value="<?php echo $progress_proj ?>">
                                        <h3 class="text-decoration-underline badge bg-secondary text-wrap">ความคืบหน้าของโปรเจคโดยรวม</h3>
                                        <div class="progress mb-3" role="progressbar" aria-label="Info example " aria-valuenow="<?php echo  $progress_proj ?>" aria-valuemin="0" aria-valuemax="100" style="height: 1.5rem;">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated " style="width:<?= $progress_proj ?>%"><?php echo  $progress_proj . '%'; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php  } ?>

                            </tbody>
                        </table>
                    </div>
                </div>

            </section>

            <!-- End ส่วนของการแสดงรายละเอียดงานและอัพความคืบหน้า -->




            <!-- modal -->
            <!-- แก้ไขข้อมูลในหน้าแสดงผลด้วย Modal -->
            <div class="modal fade modal-xl" id="edit_page">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title ">แก้ไขรายละเอียดทั้งหมด</h1>
                            <!-- ปุ่มปิดกากบาท -->
                            <button class="btn btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div id="modal_edit"></div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- modal update -->
            <div class="modal fade modal-lg modal-sm" id="add_update">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title">อัพเดทความคืบหน้าของกิจกรรมย่อย</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div id="modal_update"></div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- modal edit activity -->
            <div class="modal fade modal-lg modal-sm" id="edit_activity">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">อัพเดทความคืบหน้าของกิจกรรมย่อย</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="modal_edit_activity"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- modal ระบุว่าใครเป็นรับผิดชอบงานไหน -->
            <div class="modal fade modal-lg" id="add_memberTask">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">เลือกงานที่รับผิดชอบ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="modal_add_memberTask"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</body>

</html>