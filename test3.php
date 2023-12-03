<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
      <!-- bootstrap -->
      <link rel="stylesheet" href="bootstrap-5.2.3/dist/css/bootstrap.min.css">
    <script src="bootstrap-5.2.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="icons-1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
 <!-- End bootstrap -->

</head>
<body>
<?php
$page = 'home';
include('nav.php');
?>

<nav>
  <ul>
    <li class="<?php if ($page == 'home') { echo 'active'; } ?>"><a href="#">Home</a></li>
    <li class="<?php if ($page == 'about') { echo 'active'; } ?>"><a href="#">About</a></li>
    <li class="<?php if ($page == 'contact') { echo 'active'; } ?>"><a href="#">Contact</a></li>
  </ul>
</nav>
<div class="accordion accordion-flush" id="accordionFlushExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
        Accordion Item #1
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">
      <div class=" mt-3 col-md-6">
                    <h2 class="text-center">รายละเอียดงาน</h2>
                    <div>
                        <table class=" table table-light table-striped mt-2 display responsive nowrap" id="progress">
                            <thead class="table-dark">
                                <tr>
                                    <th>ลำดับที่</th>
                                    <th>ชื่องาน</th>
                                    <th>กิจกรรมย่อย</th>
                                    <th>ความคืบหน้ากิจกรรมย่อย</th>
                                    <th>ความคืบหน้าทั้งหมด</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($task = mysqli_fetch_assoc($result_task)) { ?>
                                    <tr>
                                        <td class="text-end"><?php echo $order++ ?></td>
                                        <?php
                                        // เงื่อนไขคือ เก็บproject_nameไว้ในตัวแปร a ลูปแรกที่เจอ project_name
                                        // เมื่อเข้าลูปที่ 2 ถ้าเจอproject_name ชื่อเดิมจะมีค่าเป็นจะให้เป็นค่าว่าง
                                        if ($taskName == $task['task_name']) {
                                            $tasknew = "";
                                        } else {
                                            $tasknew = $task['task_name'];
                                        }
                                        ?>
                                        <td class="table-light">
                                            <h5><?php echo $tasknew ?></h5>
                                        </td>

                                        <td>

                                            <?php echo $task['activity_name']; ?> <a href="#" class=" btn text-info open_update " data-bs-toggle="modal" idx="<?php echo $task['activity_id'] ?>" data-bs-target="#add_update"> <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                                                    <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0z" />
                                                </svg>
                                            </a>

                                            <a href="#" class="btn text-warning open_Edact" data-bs-target="#edit_activity" data-bs-toggle="modal" idx="<?php echo $task['activity_id']; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                </svg></a>

                                        </td>
                                        <td><?php echo $task['activity_progress'] ?></td>

                                        <!-- Query คำนวณ ProgressBar -->
                                        <?php $cout = "SELECT  COUNT(activity_progress),activity_progress,SUM(activity_progress)
                                           FROM activity 
                                       WHERE  task_id = " . $task['task_id'];
                                        $respon = mysqli_query($con, $cout);
                                        while ($data = mysqli_fetch_assoc($respon)) { ?>
                                            <?php
                                            if ($data['activity_progress'] == " ") { ?>
                                                <td>0</td>
                                            <?php } else { ?>
                                                <?php
                                                $sum = intval(($data['SUM(activity_progress)'] * 100) / ($data['COUNT(activity_progress)'] * 100));

                                                if ($total_progress == $sum) {
                                                    $b = " 0";
                                                } else {
                                                    $b = $sum;
                                                } ?>

                                                <td><?php echo $b; ?></td>
                                        <?php
                                            }
                                            $total_progress = intval(($data['SUM(activity_progress)'] * 100) / ($data['COUNT(activity_progress)'] * 100));
                                        }

                                        ?>



                                    </tr>

                                    <?php
                                    //   ความคืบหน้าโปรเจคทั้งหมด
                                    $task_total = "SELECT  activity_progress,task_id,COUNT(activity_progress),SUM(activity_progress)
                                        FROM activity 
                                          WHERE  activity_id = " . $task['activity_id'];
                                    $task_pro = mysqli_query($con, $task_total);
                                    foreach ($task_pro as $sumt) {
                                        $num = $sumt['activity_progress']; //เก็บค่าActtivityทั้งหมด
                                        $numrow = $sumt['COUNT(activity_progress)']; //นับจำนวนแถวทั้งหมด
                                        //  echo$IdTask;
                                        $numTask += $numrow; //นับจำนวนแถวทั้งหมด
                                        $total += $num; //เก็บค่าActtivityทั้งหมดมารวมกัน
                                    } ?>
                                <?php
                                    $taskName = $task['task_name'];
                                } ?>

                                <?php
                                //ตัวแปรที่เก็บค่าสูตรคำนวณโดยวิธีคิด จำนวนActtivityทั้งหมด*100/จำนวนแถวทั้งหมด
                                if ($numTask == 0) { ?>

                                    <div id="detailProgress">
                                        <h3 class="text-decoration-underline badge bg-secondary text-wrap">ความคืบหน้าของโปรเจคโดยรวม</h3>
                                        <div class="progress mb-3" role="progressbar" aria-label="Info example " aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="height: 1.5rem;">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated " style="width:0%">0
                                            </div>
                                        </div>
                                    </div>
                                <?php  } else {
                                    $result_progessBar =  round(($total * 100) / ($numTask * 100), 2);
                                    //  คำสั่งQueryคำนวณ
                                ?>
                                    <div id="detailProgress">
                                        <input type="hidden" name="result_progessBar" value="<?php echo $result_progessBar ?>">
                                        <h3 class="text-decoration-underline badge bg-secondary text-wrap">ความคืบหน้าของโปรเจคโดยรวม</h3>
                                        <div class="progress mb-3" role="progressbar" aria-label="Info example " aria-valuenow="<?php echo  $result_progessBar ?>" aria-valuemin="0" aria-valuemax="100" style="height: 1.5rem;">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated " style="width:<?= $result_progessBar ?>%"><?php echo  $result_progessBar . '%'; ?>
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

      </div>
    </div>
  </div>
  </div>

  
</body>
</html>