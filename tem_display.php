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
      <!-- bootstrap -->
      <link rel="stylesheet" href="/bootstrap-5.2.3/dist/css/bootstrap.min.css">
    <script src="bootstrap-5.2.3/dist/js/bootstrap.min.js"></script>
    <!-- <link rel="stylesheet" href="icons-1.10.3/font/bootstrap-icons.css"> -->
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
	</head>

	<body>
		<?php
    //     $message = "Confirm";
    // echo $text =strtolower($message);
		// menu bar -------------------------------------------------------
		include "nav.php";
		//-----------------------------------------------------------------	
			// ADD -------------------- Admin
			if($_ARRAUTH["ADD"]==1){
              echo '<div class="container-fulid"> 
                <div class="container-fluid mt-3 p-4  ">
        
                    <div class="dropdown d-flex justify-content-end mb-2 ">
                        <button class="btn btn-primary " dropdown-toggle type="button" data-bs-toggle="dropdown" aria-expanded="false">
                           Fillter Project
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="tem_display.php">Default</a></li>
                            <li><a class="dropdown-item" href="tem_display.php?status=1">Complete</a></li>
                            <li><a class="dropdown-item" href="tem_display.php?status=2">InComplete</a></li>
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
                        <tbody class="text-break">';
                           
                            //แสดงผลข้อมูลในฐานข้อมูล
                            while ($task = mysqli_fetch_assoc($result_task)) {
                                $id = $task['project_id']; 
                                $progess_bar = Total_progress($id);
                               
                                 if (!isset($_GET['status'])) {
                                        echo ' <tr>
                                        <td class="text-end"> '.$order++.' </td>
                                        <td class=""> '.$task["project_name"].' </td>
                                        <td class="text-center"> <a href="tem_mainpage.php?idp='.$task["project_id"].' " class="btn btn-info"><span class="lnr lnr-question-circle"></span> ดูรายละเอียด</a>
            
                                        </td>
                                        <td> '.$task["emp_fname"].'  '.$task["emp_lname"].' </td>
                                        <td> '.$task["detail"].' </td>
                                        <td class="text-success fw-bold">'.date("d/m/Y", strtotime($task["create_time"])).'</td>
                                        <td class="text-danger fw-bold">'.date("d/m/Y", strtotime($task["dead_line"])).'</td>

                                        <td> '.intval($progess_bar).' </td>
        
                                        </tr>';
                                         
                                }
                                
                                
                                if (isset($_GET['status']) && $_GET['status'] == '1') {
                                    
                                    $check =  fillter($id);
                                    $progess_bar = Total_progress($id);
                                    if ($check == 100) {
                                        echo ' <tr>
                                        <td class="text-end"> '.$order++.' </td>
                                        <td class=""> '.$task["project_name"].' </td>
                                        <td class="text-center"> <a href="tem_mainpage.php?idp='.$task["project_id"].' " class="btn btn-info"><span class="lnr lnr-question-circle"></span> ดูรายละเอียด</a>
            
                                        </td>
                                        <td> '.$task["emp_fname"].'  '.$task["emp_lname"].' </td>
                                        <td> '.$task["detail"].' </td>
                                        <td class="text-success fw-bold">'.date("d/m/Y", strtotime($task["create_time"])).'</td>
                                        <td class="text-danger fw-bold">'.date("d/m/Y", strtotime($task["dead_line"])).'</td>
            
                                        <td> '.intval($progess_bar).' </td>
                                        </tr>';
                                        $check;    
                                }
                                
                                }
                             
                            if (isset($_GET['status']) && $_GET['status'] == '2') {
                                   
                                $incomplete =  fillterInComplete($id);
                                $progess_bar = Total_progress($id);
                                if ($incomplete) {
                                    echo ' <tr>
                                    <td class="text-end"> '.$order++.' </td>
                                    <td class=""> '.$task["project_name"].' </td>
                                    <td class="text-center"> <a href="tem_mainpage.php?idp='.$task["project_id"].' " class="btn btn-info"><span class="lnr lnr-question-circle"></span> ดูรายละเอียด</a>
        
                                    </td>
                                    <td> '.$task["emp_fname"].'  '.$task["emp_lname"].' </td>
                                    <td> '.$task["detail"].' </td>
                                    <td class="text-success fw-bold">'.date("d/m/Y", strtotime($task["create_time"])).'</td>
                                    <td class="text-danger fw-bold">'.date("d/m/Y", strtotime($task["dead_line"])).'</td>

                                    <td> '.intval($progess_bar).' </td>

                                    </tr>';
                                       
                            }
                            
                            }
                        
                         } //ปีกกา While 
                                
                     echo '</tbody>
                    </table>';
                    
                    // 
                    $IdProject = projectId();
                    //  echo $IdProject;
        
                    
              echo  '</div>
            </div>';
         
			}
        

			// EDIT ------------------- User
			if($_ARRAUTH["EDIT"]==1){
                echo '<div class="container-fulid"> 
                <div class="container-fluid mt-3 p-4  ">
        
                    <div class="dropdown d-flex justify-content-end mb-2 ">
                        <button class="btn btn-primary " dropdown-toggle type="button" data-bs-toggle="dropdown" aria-expanded="false">
                           Fillter Project
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="tem_display.php">Default</a></li>
                            <li><a class="dropdown-item" href="tem_display.php?status=1">Complete</a></li>
                            <li><a class="dropdown-item" href="tem_display.php?status=2">InComplete</a></li>
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
                        <tbody class="text-break">';
                           
                            //แสดงผลข้อมูลในฐานข้อมูล
                            while ($task = mysqli_fetch_assoc($result_task)) {
                                $id = $task['project_id']; 
                                $progess_bar = Total_progress($id);
                               
                                 if (!isset($_GET['status'])) {
                                        echo ' <tr>
                                        <td class="text-end"> '.$order++.' </td>
                                        <td class=""> '.$task["project_name"].' </td>
                                        <td class="text-center"> <a href="tem_mainpage.php?idp='.$task["project_id"].' " class="btn btn-info"><span class="lnr lnr-question-circle"></span> ดูรายละเอียด</a>
            
                                        </td>
                                        <td> '.$task["emp_fname"].'  '.$task["emp_lname"].' </td>
                                        <td> '.$task["detail"].' </td>
                                        <td class="text-success fw-bold">'.date("d/m/Y", strtotime($task["create_time"])).'</td>
                                        <td class="text-danger fw-bold">'.date("d/m/Y", strtotime($task["dead_line"])).'</td>

                                        <td> '.intval($progess_bar).' </td>
        
                                        </tr>';
                                         
                                }
                                
                                
                                if (isset($_GET['status']) && $_GET['status'] == '1') {
                                    
                                    $check =  fillter($id);
                                    $progess_bar = Total_progress($id);
                                    if ($check == 100) {
                                        echo ' <tr>
                                        <td class="text-end"> '.$order++.' </td>
                                        <td class=""> '.$task["project_name"].' </td>
                                        <td class="text-center"> <a href="tem_mainpage.php?idp='.$task["project_id"].' " class="btn btn-info"><span class="lnr lnr-question-circle"></span> ดูรายละเอียด</a>
            
                                        </td>
                                        <td> '.$task["emp_fname"].'  '.$task["emp_lname"].' </td>
                                        <td> '.$task["detail"].' </td>
                                        <td class="text-success fw-bold">'.date("d/m/Y", strtotime($task["create_time"])).'</td>
                                        <td class="text-danger fw-bold">'.date("d/m/Y", strtotime($task["dead_line"])).'</td>
            
            
                                     
                                    
            
                                        <td> '.intval($progess_bar).' </td>
            
            
            
                                        </tr>';
                                        $check;    
                                }
                                
                                }
                             
                            if (isset($_GET['status']) && $_GET['status'] == '2') {
                                    
                                $incomplete =  fillterInComplete($id);
                                $progess_bar = Total_progress($id);
                                if ($incomplete) {
                                    echo ' <tr>
                                    <td class="text-end"> '.$order++.' </td>
                                    <td class=""> '.$task["project_name"].' </td>
                                    <td class="text-center"> <a href="tem_mainpage.php?idp='.$task["project_id"].' " class="btn btn-info"><span class="lnr lnr-question-circle"></span> ดูรายละเอียด</a>
        
                                    </td>
                                    <td> '.$task["emp_fname"].'  '.$task["emp_lname"].' </td>
                                    <td> '.$task["detail"].' </td>
                                    <td class="text-success fw-bold">'.date("d/m/Y", strtotime($task["create_time"])).'</td>
                                    <td class="text-danger fw-bold">'.date("d/m/Y", strtotime($task["dead_line"])).'</td>

                                    <td> '.intval($progess_bar).' </td>
        
        
        
                                    </tr>';
                                       
                            }
                            
                            }
                        
                         } //ปีกกา While 
                                
                     echo '</tbody>
                    </table>';
                    
                    // 
                    $IdProject = projectId();
                    //  echo $IdProject;
        
                    
              echo  '</div>
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