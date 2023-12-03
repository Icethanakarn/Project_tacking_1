<?php
require('dbconnect.php');

$sql = "SELECT p.project_id,p.project_name,p.create_time,p.dead_line,p.update_time,p.create_by,p.update_by,p.detail,p.team_member,emp.emp_id,emp.emp_fname,emp.emp_lname
FROM project_create AS p 
right join employees AS emp on emp.emp_id = p.create_by";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

$sqlemp = "SELECT * FROM employees";
$emp_result = mysqli_query($con, $sqlemp);

$sql2 = "SELECT DISTINCT project_create.project_name,task.task_name,task.task_id,activity.activity_name,activity.activity_progress,project_create.detail,activity.activity_id,task.project_id,project_create.project_id
FROM task
RIGHT JOIN  project_create ON project_create.project_id = task.project_id
RIGHT JOIN  activity ON task.task_id = activity.task_id
WHERE project_create.project_id =".$_POST['id'];
// echo $sql2;
$order =1;
$result_task = mysqli_query($con, $sql2);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <!-- Selecet2 -->
    <!-- Styles -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Or for RTL support -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

    <!-- Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Selecet2 -->
  
</head>

<body>
<script>
        $(document).ready(function() {

            $('.owner').select2({
                theme: 'bootstrap-5',
                placeholder: "เลือกโปรเจคที่ต้องการ"

            });

        });
        </script>
    <div class="container shadow p-3 mb-5 mt-5 bg-body-tertiary rounded">
        <form action="updateProject.php" method="post">
            <input type="hidden" name="idedit" value="<?php echo $row['project_id']; ?>">
            <h1 class="text-center">รายละเอียดโปรเจค <?php echo $row['project_name'] ?></h1>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">ชื่อโปรเจค</span>
                </div>
                <input type="text" name="project_Name" class="form-control" placeholder="ป้อนชื่อโปรเจค" value="<?php echo $row['project_name'] ?>">
            </div>
            
            


            <div class="input-group mt-3 row-12">
                <div class="input-group-prepend ">
                    <span class="input-group-text ">วันที่โปรเจคต้องเสร็จ</span>
                </div>
                <input type="date" name="dead_line" id="" class="form-control col-lg-4" value="<?php echo $row['dead_line'] ?>" min="<?php echo date('Y-m-d'); ?>">
                
            </div>
                <div class="input-group-prepend">
                    <span class="input-group-text ">วันที่สร้างโปรเจค</span>
                </div>
                <input type="timestam" name="c-time" id="" class="form-control col-lg-4" readonly value="<?php echo date("d-m-Y ", strtotime($row['create_time'])) ?>">
                <div class="input-group-prepend">
                    <span class="input-group-text ">วันที่อัพเดทโปรเจค</span>
                </div>
                <input type="date" name="update_time" id="" class="form-control col-lg-4" value="<?php echo $row['update_time'] ?>" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">

            <div class="form-floating mt-3">
                <textarea class="form-control" placeholder="รายละเอียดงานโปรเจค" id="floatingTextarea" name="detail"><?php echo $row['detail'] ?></textarea>
                <label for="floatingTextarea">รายละเอียดงานโปรเจค</label>
            </div>
            <div class="mt-3">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>รหัสพนักงาน</th>
                            <th>ชื่อสมาชิก</th>
                            <th>งานที่รับผิดชอบ</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>

                            <?php if ($row['team_member'] == "") { ?>
                                <td colspan="3">
                                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-octagon" viewBox="0 0 16 16">
                                            <path d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z" />
                                            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z" />
                                        </svg>
                                        <use xlink:href="#exclamation-triangle-fill" />
                                        </svg>
                                        <div>
                                            ยังไม่มีการเพิ่มสมาชิก
                                            
                                        </div>
                                    </div>
                                </td>

                            <?php } else { ?>
                                <td><?= $row['emp_id'] ?></td>
                                <td><?= $row['team_member'] ?></td>
                                <td rowspan="3">
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-headingOne">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                    งานที่ได้รับมอบหมาย
                                                </button>
                                            </h2>
                                            <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    <ul>
                                                        <li><?= $row['project_name'] ?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                        </tr>
                    <?php } ?>

                    </tbody>


                </table>
            </div>
            </div>

            
         


            <div class="modal-footer">
                
                <button class="btn btn-success">บันทึกข้อมูล</button>
            </div>
        </form>


    </div>
    <div class="modal fade" id="open_actName">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">อัพเดทความคืบหน้าของกิจกรรมย่อย</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="edit_actName"></div>
                </div>

            </div>
        </div>
    </div>

</body>


</html>