<?php
session_start();
ob_start();
date_default_timezone_set("Asia/Bangkok");
error_reporting(0);
require('dbconnect.php');
require('func.php');
// include_once "../class/utilityclass.php";
// $drop=new UtilityModule;

// $mysqli=new mysqli($ServerName,$User,$Password,$DatabaseName,$port);

// Check connection
// if($mysqli->connect_errno) {
// 	echo "Failed to connect to MySQL: ".$mysqli->connect_error;
// 	exit();
// }


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
// $_ARRAUTH["ADD"]=1;
$_ARRAUTH["EDIT"]=1;
//---------------------------------------------------------------------

#==========================================================================
?>
<html>
	<head>
		<title><?php echo $_APPLICATION_NAME;?></title>
        <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="bootstrap-5.2.3/dist/css/bootstrap.min.css">
    <script src="bootstrap-5.2.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="icons-1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script> -->
    <!-- bootstrap end -->
    <script src="chart.js/Chart.js-4.2.1/"></script>
    <script src="chart.js/chart.umd.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script> -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->

   
	</head>

	<body>
		<?php
		// menu bar -------------------------------------------------------
		include "nav.php";
		//-----------------------------------------------------------------	
        $sql = "SELECT project_id FROM project_create";
                $result = mysqli_query($con, $sql);
                while ($task = mysqli_fetch_assoc($result)) {
                    $id = $task['project_id'];
                    $query = barChart($id);
                    $inbar = inBar($id);
            
                    foreach ($inbar as $val) {
                        $labels[] = $val['project_name'];
                        $num = intval($val['total']);
                        $datas[] = $num;
                        // print_r(intval($val['total']).'<br>');
                    }
                    foreach ($query as $value) {
                        $label[] = $value['project_name'];
                        $data[] = $value['total'];
                    }
                }
                
                $owner = countOwner();
                foreach ($owner as $owner_list) {
                    $ownername[] = $owner_list['FullName'];
                    $ownerData[] = $owner_list['project_count'];
                }
                $top = topFiveMonthUpdate();
                foreach ($top as $topf) {
                    $toplabels[] = $topf['project_name'];
                   $topname[] = $topf['project_count'];
                }
            
			// ADD -------------------- Admin
			if($_ARRAUTH["ADD"]==1){
                
                echo' 
                <div class="container">
                    <div class="card mt-3">
                        <h5 class="card-header ">
                            <div class="text-center">
                                <p>ภาพรวมโปรเจค</p>
                                <button id="bar" class="btn btn-primary">คนที่เป็นเจ้าของโปรเจมากที่สุด</button>
                                <button id="pie" class="btn ">โปรเจคที่ยังไม่เสร็จเสร็จแล้ว</button>
                                <button id="top_month" class="btn ">โปรเจคที่คืบหน้ามากที่สุดในเดือนนี้</button>
                                
                            </div>
                        </h5>
                        <div class="card-body">
                            <div>
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            ';
                                    }     
			// EDIT ------------------- User
			if($_ARRAUTH["EDIT"]==1){
                echo' 
                <div class="container">
                    <div class="card mt-3">
                        <h5 class="card-header ">
                            <div class="text-center">
                                <p>ภาพรวมโปรเจค</p>
                                <button id="bar" class="btn btn-primary">คนที่เป็นเจ้าของโปรเจมากที่สุด</button>
                                <button id="pie" class="btn ">โปรเจคที่ยังไม่เสร็จเสร็จแล้ว</button>
                                <button id="top_month" class="btn ">โปรเจคที่คืบหน้ามากที่สุดในเดือนนี้</button>
                                
                            </div>
                        </h5>
                        <div class="card-body">
                            <div>
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            ';
			}

			// VIEW ------------------ เข้าดูเฉยแต่ไม่ใช้ User
			if($_ARRAUTH["VIEW"]==1){
				// display
                echo' 
                <div class="container">
                    <div class="card mt-3">
                        <h5 class="card-header ">
                            <div class="text-center">
                                <p>ภาพรวมโปรเจค</p>
                                <button id="bar" class="btn btn-primary">คนที่เป็นเจ้าของโปรเจมากที่สุด</button>
                                <button id="pie" class="btn ">โปรเจคที่ยังไม่เสร็จเสร็จแล้ว</button>
                                <button id="top_month" class="btn ">โปรเจคที่คืบหน้ามากที่สุดในเดือนนี้</button>
                                
                            </div>
                        </h5>
                        <div class="card-body">
                            <div>
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            ';
			}
		?>
         <script>
        //setup ข้อมูลกราฟ
        const data = {
            labels: <?php echo json_encode($ownername) ?>,
            datasets: [{
                label: 'จำนวนโปรเจค',
                data: <?php echo json_encode($ownerData) ?>,
                borderWidth: 2,
                borderColor: null,
                backgroundColor: [
                    'rgba(255, 99, 132)', //สีแดงโทนอ่อน
                    'rgba(255, 159, 64)', //สีส้มโทนอ่อน
                    'rgba(255, 205, 86)', //สีเหลืองโทนอ่อน
                    'rgba(75, 192, 192)', //สีเขียวเข้มโทนอ่อน
                    'rgba(54, 162, 235)', //สีฟ้าโทนอ่อน
                    'rgba(153, 102, 255)', //สีม่วงโทนอ่อน
                    'rgba(201, 203, 207)' //สีเทาโทนอ่อน
                ],
                hoverOffset: 4,
                hoverBorderColor: "black",
                pointRadius: 8,
                fill: true,
            }]
        };

        //config รูปแบบกราฟ
        const config = {
            type: 'bar',
            data,
            options: {
                plugins: {
                    colors: {
                        // enabled: true,
                        // forceOverride: true,
                    },
                    subtitle: {
                        display: false,
                        text: 'Custom Chart Subtitle'
                    }
                },
                aspectRatio: 2,
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
            }
        };
        window.addEventListener('load', () => {
            // const ctx = document.getElementById('myChart').getContext('2d');

            const bar = document.getElementById('bar');
            const pie = document.getElementById('pie');
            const top = document.getElementById('top_month');

            bar.addEventListener('click', changeBar);
            pie.addEventListener('click', changePie);
            top.addEventListener('click',topmonth);
            
            let mychart = new Chart(
                document.getElementById('myChart'),
                config
            );

            function changeBar() {
                console.log(mychart.config.type);
                let updateChart = "bar";
                mychart.config.type = updateChart;
                mychart.data.labels = <?php echo json_encode($ownername) ?>;
                mychart.data.datasets[0].label = 'จำนวนโปรเจค'
                mychart.data.datasets[0].data = <?php echo json_encode($ownerData) ?>;
                bar.classList.add('btn-primary')
                pie.classList.remove('btn-primary')
                top.classList.remove('btn-primary');
                mychart.update()
                // < ?php inBar(55) ?>
                // data.datasets.label('test')

            }

            function changePie() {
                let updateChart = "bar";
                mychart.config.type = updateChart;
                mychart.data.labels = <?php echo json_encode($labels) ?>;
                mychart.data.datasets[0].label = 'ความคืบหน้า'
                mychart.data.datasets[0].data = <?php echo json_encode($datas); ?>;
                pie.classList.add('btn-primary')
                bar.classList.remove('btn-primary')
                top.classList.remove('btn-primary');
                mychart.update();
            }
            function topmonth() {
                let updateChart = "line";
                mychart.config.type = updateChart;
                console.log(mychart.config.type);
                mychart.data.labels = <?php echo json_encode($toplabels); ?>;
                mychart.data.datasets[0].label = 'จำนวนที่อัพเดท'
                // mychart.data.datasets[0].borderColor= "rgb(75, 192, 192)"
                mychart.data.datasets[0].data = <?php echo json_encode($topname); ?>;
                pie.classList.remove('btn-primary')
                bar.classList.remove('btn-primary')
                top.classList.add('btn-primary');
                mychart.update();
            }
        })
       
    </script>
	</body>

</html>