<!DOCTYPE html>
<html lang="en">
<?php
require('dbconnect.php');
$order = 1;
$actN = 1;
$sql = "SELECT * FROM project_create";
$sql2 = " SELECT project_create.project_name,task.task_name,task.task_id,task.status
FROM task
RIGHT JOIN  project_create ON project_create.project_id = task.project_id 
WHERE task.task_id IS null OR task.status NOT IN(0)
ORDER BY project_create.project_id DESC";
$emp_sql = "SELECT * FROM employees";
$a = ""; //ตัวแปรที่เอาไว้เก็บค่าProject_Name
$task_query = mysqli_query($con, $sql2);
$result = mysqli_query($con, $sql);
$emp_query = mysqli_query($con, $emp_sql);
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task</title>
    <link rel="stylesheet" href=/bootstrap-5.2.3/dist/css/bootstrap.min.css">
    <script src="bootstrap-5.2.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="icons-1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css"> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script> -->

    <!-- datatable -->
    <link rel="stylesheet" href="datatable/boostrap.min.css">
    <link rel="stylesheet" href="datatable/dataTables.bootstrap5.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css"> -->

    <script src="jquery/jquery-3.5.1.min.js"></script>
    <script src="datatable/jquery.dataTables.min.js"></script>
    <script src="datatable/dataTables.bootstrap5.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script> -->

    <!-- End datatable -->

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" /> -->

    <!-- select 2 -->
    <link rel="stylesheet" href="select2-develop/dist/css/select2.min.css">
    <script src="select2-develop/dist/js/select2.min.js"></script>
    <script src="select2-develop/dist/js/boostrap.bundle.min.js"></script>
    <link rel="stylesheet" href="select2-develop/dist/css/select2-bootstrap-5-theme.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" /> -->
    <!-- Or for RTL support -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" /> -->

    <!-- End select 2  -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script> -->

    <link rel="stylesheet" href="datatable/responsive.dataTables.min.css">
    <script src="datatable/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.3.0/js/dataTables.rowGroup.min.js"></script>

    <script>
        $(document).ready(function() {


            // modal หน้าactivityNew
            $(".open_activity").click(function() {

                var idx = $(this).attr('idx');

                $.post("activityNew.php", {
                        id: idx
                    },
                    function(result) {
                        $("#modal_act").html(result);
                    }
                );
                // modal หน้าactivityNew end

            });

            $('#taskTable').DataTable({
                
                "ordering": false,
                // ที่ต้องใส่ordering เพราะถ้าให้เรียงแบบขึ้นแถวใหม่เป็นเลเวลต้องยกเลิกการเรียงลำดับ

            });


            $('.taskselect').select2({
                theme: 'bootstrap-5',
                placeholder: "เลือกโปรเจคที่ต้องการ"

            });
            $('.task_emp').select2({
                theme: 'bootstrap-5',
                placeholder: "เลือกผู้รับผิดชอบ"

            });

        });
    </script>
</head>

<body>
    <?php
    include 'nav.php';

    ?>
    <div class="container-fluid">

        <div class="container  shadow p-3 mb-5 mt-5 bg-body-tertiary rounded">
            <div class="  mt-3">
                <!-- <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                    </svg> เลือกผู้รับผิดชอบกับวันที่ยังใช้ไม่ได้
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div> -->
                <section>
                    <h2 class="text-center">สร้างงาน</h2>
                    <form action="taskquery.php" method="post">
                        <div class="input-group mt-3 ">
                            <label class="input-group-text">ชื่อโปรเจค</label>
                            <select name="taskID" class="form-control taskselect " required>
                                <option value="">-เลือกหัวข้อโปรเจค-</option>
                                <?php foreach ($result as $results) { ?>
                                    <option value="<?php echo $results["project_id"]; ?>">
                                        <?php echo $results["project_name"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="input-group mt-3 mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    Task
                                </span>
                            </div>
                            <input type="text" name="addTask" class="form-control" placeholder="ป้อนชื่องาน" autocomplete="off">
                            <select name="task_emp" class=" task_emp " required>
                                <option value="">-เลือกผู้รับผิดชอบ</option>
                                <?php foreach ($emp_query as $results) { ?>
                                    <option value="<?php echo $results["emp_id"]; ?>">
                                        <?php echo $results['emp_id'] . $results["emp_fname"] . $results["emp_lname"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <input type="date" name="datetask" id="" class="form-control" min="<?php echo date('Y-m-d'); ?>">
                        <div class="m-3 d-flex justify-content-end">
                            <button class="btn btn-success btn-lg">เพิ่มงาน</button>
                        </div>
                </section>

                <table class="table table-striped mt-3 " id="taskTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>ลำดับที่</th>
                            <th>ชื่อโปรเจค</th>
                            <th>ชื่องาน</th>
                            <th>กิจกรรมย่อย</th>
                            <th>ลบงาน</th>

                        </tr>

                    </thead>
                    <tbody>
                        <?php while ($task = mysqli_fetch_assoc($task_query)) {


                            // เงื่อนไขคือ เก็บproject_nameไว้ในตัวแปร a ลูปแรกที่เจอ project_name
                            // เมื่อเข้าลูปที่ 2 ถ้าเจอproject_name ชื่อเดิมจะมีค่าเป็นจะให้เป็นค่าว่าง
                            // if ($a == $task['project_name']) {
                            //     $b = "";
                            //     echo "<tr>";
                            //     echo "<td></td>";
                            //     echo "<td>$b</td>";
                            //     echo "<td></td>";

                            //     echo "<td>".$task['task_name']."</td>";
                            //     echo "<td>";

                            //     if ($task['task_name'] == '') { 
                            //       echo  "<a href='' class='btn btn-info open_activity' disabled>
                            //             <i class='bi bi-plus-circle-fill'></i>
                            //             เพิ่มกิจกรรมย่อย
                            //         </a>";
                            //       } else { 

                            //        echo "<a href='' class='btn btn-info open_activity 'data-bs-target='#add_act' data-bs-toggle='modal' idx=' ".$task['task_id']." .'>
                            //             <i class='bi bi-plus-circle-fill'></i>
                            //             เพิ่มกิจกรรมย่อย
                            //         </a>";
                            //        } 
                            //   echo"</td>";
                            //   echo "<td>";
                            //   if ($task['task_id'] == '') { 
                            //  echo   "<a href='deletetask.php?idtask=".$task['task_id']."'  class='btn btn-danger disabled' onclick=' return confirm(\'ต้องการลบข้อมูลหรือไม่??\')'><i class='bi bi-trash'></i>ลบงาน</a>";
                            //   } else { 

                            //  echo  " <a href='deletetask.php?idtask= ".$task['task_id']."' class='btn btn-danger' onclick=' return confirm(\'ต้องการลบข้อมูลหรือไม่??\')'><i class='bi bi-trash'></i>ลบงาน</a>";
                            //   }
                            //  echo" </td>";
                            //     echo "</tr>";
                            // } else {
                            //     $b = $task['project_name'];
                            //     echo "<tr>";
                            //      echo "<td>$order++</td>";
                            //      echo "<td>".$b."</td>";
                            //      echo "<td></td>";
                            //      echo "<td></td>";
                            //      echo "<td></td>";
                            //     echo "</tr>";

                            // }
                            /* Checking if the project name is the same as the previous project name. */
                            if ($a != $task['project_name']) {
                            
                                echo "<tr>";
                                $TaskNumber =1;
                                $order++;
                                echo "<td>".$TaskNumber++."</td>";
                                echo "<td>" . $task['project_name'] . "</td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "</tr>";
                            }
                            echo "<tr>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td>" . $task['task_name'] . "</td>";
                            echo "<td><a href='' class='btn btn-info open_activity 'data-bs-target='#add_act' data-bs-toggle='modal' idx=' ".$task['task_id']."'>
                                <i class='bi bi-plus-circle-fill'></i>
                                    เพิ่มกิจกรรมย่อย
                                    </a></td>";
                            echo "<td><a href='deletetask.php?idtask=".$task['task_id']."'  class='btn btn-danger ' onclick=' return confirm(\'ต้องการลบข้อมูลหรือไม่??\')'><i class='bi bi-trash'></i>ลบงาน</a></td>";
                            echo "</tr>";
                            // START ถ้ายังไม่เพิ่มTaskปุ่มเพิ่มActivity จะไม่สามารถเพิ่มข้อมูลได้ 





                            $a = $task['project_name'];
                        } ?>
                    </tbody>
                </table>
                </form>
            </div>
        </div>


        <!-- modal activity -->
        <div class="modal fade modal-xl" id="add_act">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">เพิ่มกิจกรรมย่อยใน </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="modal_act"></div>
                    </div>
                </div>

            </div>
        </div>

    </div>


</body>

</html>