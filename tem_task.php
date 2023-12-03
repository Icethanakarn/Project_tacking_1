<?php
session_start();
ob_start();
date_default_timezone_set("Asia/Bangkok");
error_reporting(0);
require('dbconnect.php');
// include_once "../class/utilityclass.php";
// $drop=new UtilityModule;

// $mysqli=new mysqli($ServerName,$User,$Password,$DatabaseName,$port);

// Check connection
// if($mysqli->connect_errno) {
// 	echo "Failed to connect to MySQL: ".$mysqli->connect_error;
// 	exit();
// }
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


//---------------------------------------------------------------------
// config application
//---------------------------------------------------------------------
$_APPLICATION_NAME="PROJECT_TRACKING"; // DO NOT EDIT
$_APPLICATION_IDENTITY="MTY3ODI0NjU3MS42Mjg4"; // DO NOT EDIT
$_APPLICATION_VERSION="1.0.0.0";
//---------------------------------------------------------------------
// Log Update Application Version
//	o Version 1.0.0.0 (28/2/2023)
//		o description xxxxx x x xxxxx xx
//	o Version 2.0.0.0 (20/3/2023)
//		1 description xxxxx x x xxxxx xx
//		2 description xxxxx x x xxxxx xx


//---------------------------------------------------------------------
$EMP_CODE=$_SESSION["user"];//"4501177";
// $getmogile=trim(file_get_contents("http://webkm/restful/RestProvides.php?id=".$EMP_CODE), "\xEF\xBB\xBF");
// $converjson=json_decode($getmogile, TRUE);


// $getauth=$drop->getProgramAuthen($converjson,$_APPLICATION_IDENTITY);
// $_ARRAUTH=$getauth[$_APPLICATION_IDENTITY];
//---------------------------------------------------------------------
// fix for test
//---------------------------------------------------------------------
// $_ARRAUTH["VIEW"]=1;
$_ARRAUTH["ADD"]=1;
// $_ARRAUTH["EDIT"]=1;
//---------------------------------------------------------------------

#==========================================================================
?>
<html>
	<head>
		<title><?php echo $_APPLICATION_NAME;?></title>
        <link rel="stylesheet" href=/bootstrap-5.2.3/dist/css/bootstrap.min.css">
    <script src="bootstrap-5.2.3/dist/js/bootstrap.min.js"></script>
    <!-- <link rel="stylesheet" href="icons-1.10.3/font/bootstrap-icons.css"> -->
    <link rel="stylesheet" href="style.css">


    <!-- datatable -->
    <link rel="stylesheet" href="datatable/boostrap.min.css">
    <link rel="stylesheet" href="datatable/dataTables.bootstrap5.min.css">
   

    <script src="jquery/jquery-3.5.1.min.js"></script>
    <script src="datatable/jquery.dataTables.min.js"></script>
    <script src="datatable/dataTables.bootstrap5.min.js"></script>
 
    <!-- End datatable -->


    <!-- select 2 -->
    <link rel="stylesheet" href="select2-develop/dist/css/select2.min.css">
    <script src="select2-develop/dist/js/select2.min.js"></script>
    <script src="select2-develop/dist/js/boostrap.bundle.min.js"></script>
    <link rel="stylesheet" href="select2-develop/dist/css/select2-bootstrap-5-theme.min.css">

    <link rel="stylesheet" href="datatable/responsive.dataTables.min.css">
    <script src="datatable/dataTables.responsive.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/rowgroup/1.3.0/js/dataTables.rowGroup.min.js"></script> -->
       <!-- icon -->
       <link rel="stylesheet" href="Linearicons-Free-v1.0.0/Web Font/style.css">
    <!--End icon -->

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
		// menu bar -------------------------------------------------------
		include "nav.php";
		//-----------------------------------------------------------------	
			// ADD -------------------- Admin
			if($_ARRAUTH["ADD"]==1){
			
   

    
                echo' <div class="container-fluid">
             
                     <div class="container  shadow p-3 mb-5 mt-5 bg-body-tertiary rounded">
                         <div class="  mt-3">
                             <section>
                                 <h2 class="text-center">สร้างงาน</h2>
                                 <form action="taskquery.php" method="post">
                                     <div class="input-group mt-3 ">
                                         <label class="input-group-text">ชื่อโปรเจค</label>
                                         <select name="project_id" class="form-control taskselect " required>
                                             <option value="">-เลือกหัวข้อโปรเจค-</option>';
                                              foreach ($result as $results) { 
                                                echo' <option value=" '.$results["project_id"].'">
                                                      '.$results["project_name"].'
                                                 </option>';
                                              } 
                                        echo' </select>
                                     </div>
                                     <div class="input-group mt-3 mb-2">
                                         <div class="input-group-prepend">
                                             <span class="input-group-text">
                                                 งาน
                                             </span>
                                         </div>
                                         <input type="text" name="addTask" class="form-control" placeholder="ป้อนชื่องาน" autocomplete="off">
                                         <select name="task_emp[]" class=" task_emp " multiple="multiple"  required>
                                             <option value="">-เลือกผู้รับผิดชอบ</option>';
                                              foreach ($emp_query as $results) { 
                                                echo'<option value=" '.$results["emp_id"]. '">
                                                    ' .$results["emp_id"].'  '.$results["emp_fname"].'  '.$results["emp_lname"].' 
                                                 </option>';
                                              } 
                                         echo '</select>
                                     </div>
                                     <input type="date" name="datetask" id="" class="form-control" min="'.date('Y-m-d').'">
                                     <div class="m-3 d-flex justify-content-end">
                                         <button class="btn btn-success btn-lg">เพิ่มงาน</button>
                                     </div>
                             </section>
             
                             <table class="table border mt-3 " id="taskTable">
                                 <thead class="thead-dark">
                                     <tr>
                                         <th>ลำดับที่</th>
                                         <th>ชื่อโปรเจค</th>
                                         <th>ชื่องาน</th>
                                         <th>กิจกรรมย่อย</th>
                                         <th>ลบงาน</th>
             
                                     </tr>
             
                                 </thead>
                                 <tbody>';
                                     while ($task = mysqli_fetch_assoc($task_query)) {
             
             
                                         if ($a != $task['project_name']) {
                                             // echo $a ."<br>";
                                             echo "<tr class='table-secondary'>";
                                             echo "<td>" . $order++ . "</td>";
                                             echo "<td >" . $task['project_name'] . "</td>";
                                             echo "<td></td>";
                                             echo "<td></td>";
                                             echo "<td></td>";
                                             echo "</tr>";
                                         }
             
             
                                         echo "<tr>";
                                         echo "<td></td>";
                                         echo "<td></td>";
                                         echo "<td>" . $task['task_name'] . "</td>";
                                         if (isset($task['task_id'])) {
             
                                             echo "<td><a href='' class='btn btn-info open_activity 'data-bs-target='#add_act' data-bs-toggle='modal' idx=' " . $task['task_id'] . "'>
                                             <span class='lnr lnr-plus-circle'></span>
                                                     เพิ่มกิจกรรมย่อย
                                                     </a></td>";
                                             echo "<td><a href='deletetask.php?idtask=" . $task['task_id'] . "'  class='btn btn-danger ' onclick='return confirm(\"ต้องการลบข้อมูลหรือไม่??\")'><span class='lnr lnr-trash'></span></i>ลบงาน</a></td>";
                                             echo "</tr>";
                                         } else {
                                             echo '<td></td>';
                                             echo '<td></td>';
                                         }
             
             
                                         $a = $task['project_name'];
                                     } 
                                echo' </tbody>
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
             
                 </div>';
                                    }     
			// EDIT ------------------- User
			if($_ARRAUTH["EDIT"]==1){


    
                echo' <div class="container-fluid">
             
                     <div class="container  shadow p-3 mb-5 mt-5 bg-body-tertiary rounded">
                         <div class="  mt-3">
                             <section>
                                 <h2 class="text-center">สร้างงาน</h2>
                                 <form action="taskquery.php" method="post">
                                     <div class="input-group mt-3 ">
                                         <label class="input-group-text">ชื่อโปรเจค</label>
                                         <select name="project_id" class="form-control taskselect " required>
                                             <option value="">-เลือกหัวข้อโปรเจค-</option>';
                                              foreach ($result as $results) { 
                                                echo' <option value=" '.$results["project_id"].'">
                                                      '.$results["project_name"].'
                                                 </option>';
                                              } 
                                        echo' </select>
                                     </div>
                                     <div class="input-group mt-3 mb-2">
                                         <div class="input-group-prepend">
                                             <span class="input-group-text">
                                                 Task
                                             </span>
                                         </div>
                                         <input type="text" name="addTask" class="form-control" placeholder="ป้อนชื่องาน" autocomplete="off">
                                         <select name="task_emp[]" class=" task_emp " multiple="multiple"  required>
                                             <option value="">-เลือกผู้รับผิดชอบ</option>';
                                              foreach ($emp_query as $results) { 
                                                echo'<option value=" '.$results["emp_id"]. '">
                                                    ' .$results["emp_id"].'  '.$results["emp_fname"].'  '.$results["emp_lname"].' 
                                                 </option>';
                                              } 
                                         echo '</select>
                                     </div>
                                     <input type="date" name="datetask" id="" class="form-control" min="<?php echo date("Y-m-d"); ">
                                     <div class="m-3 d-flex justify-content-end">
                                         <button class="btn btn-success btn-lg">เพิ่มงาน</button>
                                     </div>
                             </section>
             
                             <table class="table border mt-3 " id="taskTable">
                                 <thead class="thead-dark">
                                     <tr>
                                         <th>ลำดับที่</th>
                                         <th>ชื่อโปรเจค</th>
                                         <th>ชื่องาน</th>
                                         <th>กิจกรรมย่อย</th>
                                         <th>ลบงาน</th>
             
                                     </tr>
             
                                 </thead>
                                 <tbody>';
                                     while ($task = mysqli_fetch_assoc($task_query)) {
             
             
                                         if ($a != $task['project_name']) {
                                             // echo $a ."<br>";
                                             echo "<tr class='table-secondary'>";
                                             echo "<td>" . $order++ . "</td>";
                                             echo "<td >" . $task['project_name'] . "</td>";
                                             echo "<td></td>";
                                             echo "<td></td>";
                                             echo "<td></td>";
                                             echo "</tr>";
                                         }
             
             
                                         echo "<tr>";
                                         echo "<td></td>";
                                         echo "<td></td>";
                                         echo "<td>" . $task['task_name'] . "</td>";
                                         if (isset($task['task_id'])) {
             
                                             echo "<td><a href='' class='btn btn-info open_activity 'data-bs-target='#add_act' data-bs-toggle='modal' idx=' " . $task['task_id'] . "'>
                                             <span class='lnr lnr-plus-circle'></span>
                                                     เพิ่มกิจกรรมย่อย
                                                     </a></td>";
                                             echo "<td><a href='deletetask.php?idtask=" . $task['task_id'] . "'  class='btn btn-danger ' onclick='return confirm(\"ต้องการลบข้อมูลหรือไม่??\")'><span class='lnr lnr-trash'></span></i>ลบงาน</a></td>";
                                             echo "</tr>";
                                         } else {
                                             echo '<td></td>';
                                             echo '<td></td>';
                                         }
             
             
                                         $a = $task['project_name'];
                                     } 
                                echo' </tbody>
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
             
                 </div>';
			}

			// VIEW ------------------ เข้าดูเฉยแต่ไม่ใช้ User
			if($_ARRAUTH["VIEW"]==1){
				// display
				echo "";
			}
		?>
	</body>
</html>