<?php
require('dbconnect.php');
$sql2 = "SELECT task.task_id,activity.activity_id,activity.activity_name,activity.activity_progress
FROM task
left JOIN activity ON task.task_id = activity.task_id
WHERE  activity.activity_id= " . $_POST['id'];
// echo $sql2;
$act_query = mysqli_query($con, $sql2);
$actN = 1;

$empsql ="SELECT * FROM employees";
$emp_query = mysqli_query($con,$empsql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>update</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

</head>

<body>
<script>
    $('#update_by').select2({
                theme: 'bootstrap-5',
                placeholder: "เลือกโปรเจคที่ต้องการ",
                dropdownParent: $('#add_update')
            });
</script>
  <div class="container shadow p-3 mb-5 mt-5 bg-body-tertiary rounded">
    <form action="upProgess.php" method="post">
      <h1>อัพเดตกิจกรรมย่อย</h1>
      <input type="hidden" name="idp" value="<?php echo $_POST['idp']; ?>"> 
      <!-- เป็นค่าที่รับมาจากหน้าdisplay และส่งออกไปที่ไฟล์upprogrees  -->
      <table class="table table-striped mt-2 ">
        <thead class="thead-dark">
          <th>ลำดับที่</th>
          <th>ชื่อกิจกรรมย่อย</th>
          <th>อัพเดทความคืบหน้า</th>
        </thead>
        <tbody>
          <?php while ($lact = mysqli_fetch_assoc($act_query)) { ?>
            <input type="hidden" name="act_id" value="<?php echo $lact['activity_id'] ?>">
            <input type="hidden" name="act_name" value="<?php echo $lact['activity_name'] ?>">
            <input type="hidden" name="prev_value" value="<?php echo $lact['activity_progress'] ?>">
            
           
            <tr>
              <td><?php echo $actN++ ?></td>
              <td><?php echo $lact['activity_name'] ?></td>
              
              <td> <input type="number" id="myInput" name="act_update" class="form-control" placeholder="ป้อนตัวเลข ค่าปัจจุบันคือ <?php echo $lact['activity_progress'] ?>" min="<?php echo $lact['activity_progress'] ?>" max="100"></td>
            </tr>
            
  </div>
  </table>
  <div class="input-group mt-3">
    <label class="input-group-text" for="update_by">ระบุคนที่แก้ไข</label>
    <select id="update_by" class="update_by form-select" name="update_by" required>
  <option value="">เลือกรายชื่อ</option>
      <?php foreach ($emp_query as $id) { ?>

        <option value="<?php echo $id['emp_id'] ?>">
          <?php echo $id['emp_id'] . " " . $id['emp_fname'] . " " . $id['emp_lname'] ?></option>

      <?php   } ?>
    </select>
  </div>
  <div class="modal-footer">
               <button type="summit" class="btn btn-success" >บันทึกข้อมูล</button>

  </div>
</form>
<?php } ?>

</div>
</body>

</html>