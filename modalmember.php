<?php
require('dbconnect.php');
$sql="SELECT p.project_id,p.project_name,t.task_id,t.task_name,t.status
FROM project_create AS p
LEFT JOIN task AS t on t.project_id = p .project_id
WHERE t.status  NOT IN (0) AND p.project_id =".$_POST['id'] ;
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($result);
// echo $_POST['id'];

$sql2="SELECT t.team_member,t.project_id,emp.emp_fname,emp.emp_lname
FROM team AS t
LEFT JOIN employees AS emp ON emp.emp_id = t.team_member
WHERE project_id =".$_POST['id']  ;
$result2 = mysqli_query($con,$sql2);


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
    <script>
          $('#taskmember').select2({
                theme: 'bootstrap-5',
                placeholder: "เลือกโปรเจคที่ต้องการ",
                dropdownParent: $('#modal_add_memberTask')
            });
          $('#emp_id').select2({
                theme: 'bootstrap-5',
                placeholder: "เลือกโปรเจคที่ต้องการ",
                dropdownParent: $('#modal_add_memberTask')
            });
    </script>
<div class="container shadow p-3 mb-5 mt-5 bg-body-tertiary rounded">
    <form action="memberquery.php" method="post" id="memberquery">
              <input type="hidden" name="idedit" value="<?php echo $row ['project_id']; ?>">
             <?php while($row2 = mysqli_fetch_assoc($result2)) {?>

                <input type="hidden" name="team_mem_id" value="<?php echo $row2 ['team_member']; ?>">
          <?php   } ?>

              <h1>เลือกงานที่รับผิดชอบ</h1>
              <div class="input-group mt-3 ">
                    <label for="employeesid" class="input-group-text">เลือกงาน</label>
                    <select class="form-select " name="task_id" id="taskmember" required>
                        <option value="" selected>>----เลือกงานที่ต้องรับผิดชอบ----<< /option>
                                <?php foreach ($result as $id) { ?>

                        <option value="<?php echo $id['task_id'] ?>">
                            <?php echo $id['task_name'] ?>
                        </option>

                    <?php } ?>
                    </select>
                </div>
      
              <div class="input-group mt-3 ">
                    <label for="employeesid" class="input-group-text">เลือกสมาชิก</label>
                    <select class="form-select " name="emp_id" id="emp_id">
                        <option value="" selected>>----เลือกงานที่ต้องรับผิดชอบ----<< /option>
                                <?php foreach ($result2 as $emp) { ?>

                        <option value="<?php echo $emp['team_member'] ?>">
                            <?php echo $emp['team_member']."".$emp['emp_fname']."".$emp['emp_lname'] ?>
                        </option>

                    <?php } ?>
                    </select>
                </div>
      
      <div class="modal-footer">
        <button type="summit" class="btn btn-success">บันทึกข้อมูล</button>
      </div>
      </form>
     
    </div> 
</body>
</html>