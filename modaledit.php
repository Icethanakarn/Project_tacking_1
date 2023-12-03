<?php
require('dbconnect.php');

$sql = "SELECT p.project_id,p.project_name,p.create_time,p.dead_line,p.update_time,p.create_by,p.update_by,p.detail,p.owner,emp.emp_id,emp.emp_fname,emp.emp_lname
FROM project_create AS p 
left join employees AS emp on emp.emp_id = p.create_by
WHERE p.project_id = ".$_POST['id'];

// echo $sql;
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

$sqlemp = "SELECT * FROM employees";
$emp_result = mysqli_query($con, $sqlemp);


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
        $(document).ready(function() {

            $('.owner').select2({
                theme: 'bootstrap-5',
                placeholder: "เลือกชื่อเจ้าของโปรเจค",
                dropdownParent: $('#edit_page')

            });
            $('.update_emp').select2({
                theme: 'bootstrap-5',
                placeholder: "เลือกรายชื่อ",
                dropdownParent: $('#edit_page') ///ทำให้searchในmodalได้ โดยid คือ parentIDของmodal 
            });
            
       
  
        });
        </script>
    <div class="container shadow p-3 mb-5 mt-5 bg-body-tertiary rounded">
        <form action="updateProject.php" method="post">
            <input type="hidden" name="idedit" value="<?php echo $row['project_id']; ?>">
            <h1 class="text-center">รายละเอียดโปรเจค <?php echo $row['project_name'] ?></h1>
           <div>

               <div class="input-group">
                   <div class="input-group-prepend">
                       <span class="input-group-text">ชื่อโปรเจค</span>
                   </div>
                   <input type="text" name="project_Name" class="form-control" placeholder="ป้อนชื่อโปรเจค" value="<?php echo $row['project_name'] ?>">
               </div>
               <div class="input-group mt-3">
                   <div class="input-group-prepend">
                       <span class="input-group-text">ชื่อเจ้าของโปรเจค</span>
                   </div>
                   <select class="owner" name="owner" required>
                        <option value="" selected>< /option>
                                <?php foreach ($emp_result as $id) { ?>

                        <option value="<?php echo $id['emp_id'] ?>">
                            <?php echo $id['emp_id'] . " " . $id['emp_fname'] . " " . $id['emp_lname'] ?>
                        </option>

                    <?php } ?>
                    </select>
               </div>
           </div>


            <div class="input-group mt-3 row-12">
                <div class="input-group-prepend">
                    <span class="input-group-text ">วันที่โปรเจคต้องเสร็จ</span>
                </div>
                <input type="date" name="dead_line" id="" class="form-control col-lg-4" value="<?php echo $row['dead_line'] ?>" >
                <div class="input-group-prepend">
                    <span class="input-group-text ">วันที่สร้างโปรเจค</span>
                </div>
                <input type="timestam" name="c-time" id="" class="form-control col-lg-4" readonly value="<?php echo date("d-m-Y ", strtotime($row['create_time'])) ?>">
                <div class="input-group-prepend">
                    <span class="input-group-text ">วันที่อัพเดทโปรเจค</span>
                </div>
                <input type="date" name="update_time" id="" class="form-control col-lg-4" value="<?php echo $row['update_time'] ?>" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="form-floating mt-3">
                <textarea class="form-control" placeholder="รายละเอียดงานโปรเจค" id="floatingTextarea" name="detail"><?php echo $row['detail'] ?></textarea>
                <label for="floatingTextarea">รายละเอียดงานโปรเจค</label>
            </div>

            <div class="input-group mt-3">
                   <div class="input-group-prepend">
                       <span class="input-group-text">คนที่อัพเดท</span>
                   </div>
                   <select class="update_emp form-select " name="update_by" id="up_emp" required>
                        <option value="" selected>>----เลือกรายชื่อ----<< /option>
                                <?php foreach ($emp_result as $member) { ?>

                        <option value="<?php echo $member['emp_id'] ?>">
                            <?php echo $member['emp_id'] . " " . $member['emp_fname'] . " " . $member['emp_lname'] ?>
                        </option>

                    <?php } ?>
                    </select>
               </div>
              
            <div class="modal-footer">
                <button class="btn btn-success">บันทึกข้อมูล</button>
            </div>
        </form>
    </div>
    
</body>
</html>