<?php
//Modalสำหรับเพิ่มActivity

require('dbconnect.php');
$act = "SELECT task.task_id,activity.activity_id,activity.activity_name
FROM task
left JOIN activity ON task.task_id = activity.task_id
WHERE  activity.status <> 0 AND task.task_id = ".$_POST['id'];
$act_query = mysqli_query($con,$act);
$actN =1;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container shadow p-3 mb-5 mt-5 bg-body-tertiary rounded">
          <form action="addActivity.php" method="post">
              <h1>รายละเอียดกิจกรรมย่อย</h1>
              <div class="input-group">
                  <div class="input-group-prepend">
                      <span class="input-group-text">ชื่อกิจกรรมย่อย</span>
                    </div>
                    <input type="text" name="act_name" class="form-control" placeholder="ป้อนชื่อกิจกรรมย่อย" >
                </div>
                
                
                
                <table class="table table-striped mt-2 ">
                    <thead class="thead-dark">
                        <th>ลำดับที่</th>
                        <th>ชื่อกิจกรรมย่อย</th>
                        <th>ลบงาน</th>
                    </thead>
                    <tbody >
                        <?php while($lact=mysqli_fetch_assoc($act_query)){ ?>
                            <input type="hidden" name="task_act" value="<?php echo $lact['task_id']?>">
                            <?php if(isset($lact['activity_id'])) { ?>
                            <tr> 
                        <td><?php echo $actN++ ?></td>
                        <td><?php echo $lact['activity_name']?></td>
                       
                        <td><a href="deleteActivity.php?idact=<?php echo $lact['activity_id']?>" class="btn btn-danger" onclick=" return confirm('ต้องการลบข้อมูลหรือไม่??')">
                    <i class="bi bi-trash"></i>ลบงาน</a></td>
                    </tr> 
                      <?php  } ?>
                        

<?php } ?>

      </div>
      </div>
      <div class="modal-footer">
        <button type="summit" class="btn btn-success">บันทึกข้อมูล</button>
      </div>
      </form>
    </div> 
</body>
</html>