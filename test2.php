<?php
// session_start();
ob_start();
date_default_timezone_set('Asia/Bangkok');
error_reporting(0);
include_once '../class/conn.php';
// include_once '../class/utilityclass.php';
// $drop=new UtilityModule;

// $mysqli = new mysqli($ServerName, $User, $Password, $DatabaseName, $port);

// Check connection
// if ($mysqli->connect_errno) {
//     echo "Failed to connect to MySQL: " . $mysqli->connect_error;
//     exit();
// }

//---------------------------------------------------------------------
// config application
//---------------------------------------------------------------------
$_APPLICATION_NAME = 'Booking Massage'; // DO NOT EDIT
$_APPLICATION_IDENTITY = 'MTY3ODI0NjU3MS42Mjg4'; // DO NOT EDIT
$_APPLICATION_VERSION = '1.0.0.0';
//---------------------------------------------------------------------
// Log Update Application Version
//	o Version 1.0.0.0 (28/2/2023)
//		o description xxxxx x x xxxxx xx
//	o Version 2.0.0.0 (20/3/2023)
//		1 description xxxxx x x xxxxx xx
//		2 description xxxxx x x xxxxx xx


//---------------------------------------------------------------------
$EMP_CODE = $_SESSION['user']; //'4501177';
// $getmogile=trim(file_get_contents('http://webkm/restful/RestProvides.php?id='.$EMP_CODE), "\xEF\xBB\xBF");
// $converjson=json_decode($getmogile, TRUE);


// $getauth=$drop->getProgramAuthen($converjson,$_APPLICATION_IDENTITY);
// $_ARRAUTH=$getauth[$_APPLICATION_IDENTITY];
//---------------------------------------------------------------------
// fix for test
//---------------------------------------------------------------------
// $_ARRAUTH['VIEW']=1;
$_ARRAUTH['ADD'] = 1;
// $_ARRAUTH['EDIT']=1;
//---------------------------------------------------------------------

#==========================================================================
?>
<html>

<head>
  <title><?php echo $_APPLICATION_NAME; ?></title>

  <style>

  </style>
  <script type="text/javascript">
    $(document).ready(function() {
      $(document).ready(function() {
        $('#example').DataTable({
          scrollY: 400,
          scrollX: true,
          language: {
            "decimal": "",
            "emptyTable": "ไม่มีรายการสินค้าในคลัง",
            "info": "แสดง _START_ - _END_ จาก _TOTAL_ รายการ",
            "infoEmpty": "แสดง 0 - 0 จาก 0 รายการ",
            "infoFiltered": "(จากทั้งหมด _MAX_ รายการ)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "แสดง _MENU_ รายการ",
            "loadingRecords": "Loading...",
            "processing": "",
            "search": "ค้นหา:",
            "zeroRecords": "ไม่พบสิ่งที่ค้นหาจากตาราง",
            "paginate": {
              "first": "First",
              "last": "Last",
              "next": "หน้าต่อไป",
              "previous": "ก่อนหน้า"
            },
            "aria": {
              "sortAscending": ": activate to sort column ascending",
              "sortDescending": ": activate to sort column descending"
            }
          },
        });
        // var table = $('#example').DataTable();

        // $('#example tbody').on('click', 'tr', function() {
        //     $(this).toggleClass('selected');
        // });

        // $('#button').click(function() {
        //     alert(table.rows('.selected').data().length + ' row(s) selected');
        // });
      });
    });

    function checkAll() {
      var form_element = document.forms[0].length;
      for (i = 0; i < form_element - 1; i++) {
        document.forms[0].elements[i].checked = true;
      }
    }

    function uncheckAll() {
      var form_element = document.forms[0].length;
      for (i = 0; i < form_element - 1; i++) {
        document.forms[0].elements[i].checked = false;
      }
    }
  </script>
</head>

<body>
  <?php
  include('data.php');
  // menu bar -------------------------------------------------------
  // include 'menubar.php';
  //-----------------------------------------------------------------	
  // ADD --------------------
  if ($_ARRAUTH['ADD'] == 1) {
    // display
    //ใช้ดึงข้อมูลตาราง product โดย ไม่เอา p_status เท่ากับ 0 
    //-------------------------------------------------------------------------------------------------------------------------------------
    $sql = "SELECT * FROM `product` WHERE (p_status  NOT IN(0)) ORDER BY `code` ASC";
    $result = mysqli_query(
      $link,
      $sql
    );

    //ใช้ดึงข้อมูลตาราง minion_table โดย minion_table.IdM เท่ากับ 4 AND ไม่เอา Status เท่ากับ 0
    //-------------------------------------------------------------------------------------------------------------------------------------
    $sql1 = "SELECT * FROM minion_table WHERE minion_table.IdM = 4 AND (Status NOT IN(0))";
    $result1 = mysqli_query($link, $sql1,) or die(mysqli_error($link));
    $unit = array();
    while ($row1 = mysqli_fetch_assoc($result1)) {
      $unit[$row1['Id']] = $row1['DropDownList'];
    }

    //ใช้ดึงข้อมูลตาราง minion_table โดย IdM เท่ากับ 3 AND ไม่เอา Status เท่ากับ 0
    //-------------------------------------------------------------------------------------------------------------------------------------
    $sql2 = "SELECT * FROM `minion_table` WHERE IdM = 3 AND (Status NOT IN(0))";
    $result2 = mysqli_query($link, $sql2,) or die(mysqli_error($link));
    $category = array();
    while ($row2 = mysqli_fetch_assoc($result2)) {
      $category[$row2['Id']] = $row2['DropDownList'];
    }

    //ใช้ดึงข้อมูลตาราง minion_table โดย minion_table.IdM เท่ากับ 2 AND ไม่เอา Status เท่ากับ 0
    //------------------------------------------------------------------------------------------------------------------------------------
    $sql3 = "SELECT * FROM minion_table WHERE minion_table.IdM = 2 AND (Status NOT IN(0))";
    $result3 = mysqli_query($link, $sql3,) or die(mysqli_error($link));
    $supplier = array();
    while ($row3 = mysqli_fetch_assoc($result3)) {
      $supplier[$row3['Id']] = $row3['DropDownList'];
    }
    $i = 0;
    echo '<div class="w-100">
        <form action="do_product_NEW.php" method="post" enctype="multipart/form-data">
            <div class="d-grid gap-2 d-flex justify-content-center">
                <a href="index.php?page=P5.1"><input class="btn btn-info" type=”button” value="เพิ่มรายการสินค้าตัวใหม่" readonly></a>
            </div>
            <div>
                <h3>รายการสินค้าหมด</h3>
            </div>';
    if (isset($_SESSION['mis'])) :
      echo '<div class="badge bg-danger text-wrap fs-5 ">';
      echo $_SESSION['mis'];
      unset($_SESSION['mis']);
      echo '</div>';
    endif;
    if (isset($_SESSION['mid'])) :
      echo '<div class="badge bg-success text-wrap fs-5 ">';
      echo $_SESSION['mid'];
      unset($_SESSION['mid']);
      echo '</div>';
    endif;
    echo '<table class="table table-light table-striped table table-bordered" id="example">';
    echo '<thead class="table-danger">';
    echo '<tr>';
    echo '<th class="align-middle">รหัสสินค้า</th>';
    echo '<th class="align-middle">วันที่รับเข้า</th>';
    echo '<th class="align-middle">รูปสินค้า</th>';
    echo '<th class="align-middle">ชื่อสินค้า</th>';
    echo '<th class="align-middle">หมวดสินค้า</th>';
    echo '<th class="align-middle">ราคา</th>';
    echo '<th class="align-middle">รายละเอียดสินค้า</th>';
    echo '<th class="align-middle">รับเข้ามา</th>';
    echo '<th class="align-middle">หน่วย</th>';
    echo '<th class="align-middle">จำนวนสินค้าต่อกล่องหรือแพ็ค</th>';
    echo '<th class="align-middle">ใส่จำนวนแจ้งเตือนสินค้าใกล้หมด</th>';
    echo '<th class="align-middle">รหัสผู้ขาย/ชื่อผู้ขาย</th>';
    echo '<th class="align-middle">จากบริษัท</th>';
    echo '<th class="align-middle">หมายเลขใบกำกับภาษี</th>';
    echo '<th>เลือกรายการ (Checkbox)</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($row = mysqli_fetch_assoc($result)) {
      echo '<tr>';
      echo '<td class="align-middle"><input type="number" class="form-control bg-dark-subtle text-emphasis-dark" name="code['.$i.']" id="code" style="width: 6rem"; value=" ' . $row["code"] . ' " readonly></td>;
          <td class="align-middle">Date("d/m/Y", strtotime('.$row["date"].')); </td>
          <td class="align-middle">
              <input type="hidden" name="old_photo['.$i.']" value="'.$row["picture"].'">
              <input type="file" class="form-control" name="picture['.$i.']" id="picture" style="width: 13rem;">
          </td>
          <td class="align-middle"><input type="text" name="product_name['.$i.']" id="product_name" style="width: 6rem;" value="'.$row["product_name"].'" required></td>
          <td class="align-middle"><select class="form-select" name="category_id['.$i.']" id="category_id" readonly style="width: 6rem;">';
      <?php
      foreach ($category as $id => $name) {
      ?>
        <option value="<?= $id ?>" <?php
                                    if ($id == @$row["category_id"])
                                      print "selected";
                                    ?>><?= $name ?></option>
      <?php
      }
      ?>
      </select></td>
      <td class="align-middle"><input type="number" name="price[<?= $i ?>]" id="price" style="width: 6rem;" value="<?= $row["price"] ?>" required></td>
      <td class="align-middle"><input type="text" name="detail[<?= $i ?>]" id="detail" style="width: 10rem; " maxlength="50" value="<?= $row["detail"] ?>"></td>
      <td class="align-middle"><input type="number" name="quantity[<?= $i ?>]" id="quantity" style="width: 6rem;" value="<?= $row["quantity"] ?>" required></td>
      <td class="align-middle"><select class="form-select" name="unit_id[<?= $i ?>]" id="unit_id" required style="width: 6rem;">
          <?php
          foreach ($unit as $id => $name) {
          ?>
            <option value="<?= $name ?>" <?php
                                          if ($id == @$row["unit_id"])
                                            print "selected";
                                          ?>><?= $name ?></option>
          <?php
          }
          ?>
        </select></td>
      <td class="align-middle"><input type="number" name="quantity1[<?= $i ?>]" id="quantity1" style="width: 10rem;" placeholder="มีสินค้ากี่ชิ้น"></td>
      <td class="align-middle"><input type="number" name="close[<?= $i ?>]" id="close" style="width: 11rem; " placeholder="จำนวนที่ตั้งเอาไว้คือ10ชิ้น"></td>
      <td class="align-middle"><input type="text" name="name[<?= $i ?>]" id="name" value="<?= @$row["name"] ?>" style="width: 10rem;" maxlength="20"></td>
      <td class="align-middle"> <select class="form-select" name="Supplier[<?= $i ?>]" id="Supplier" required style="width: 8rem;">
          <?php
          foreach ($supplier as $id => $name) {
          ?>
            <option value="<?= $id ?>" <?php
                                        if ($id == @$row["Supplier_id"])
                                          print "selected";
                                        ?>><?= $name ?></option>
          <?php
          }
          ?>
        </select></td>
      <td class="align-middle"><input type="text" name="tax[<?= $i ?>]" id="tax" value="<?= @$row["tax"] ?>" style="width: 10rem;" maxlength="20"></td>
      <td class="align-middle">
        <input type="checkbox" class="" name="idcheckbox[<?= $i ?>]" style="width: 10rem;height:3rem;" value="<?php echo $row["product_id"]; ?>">
      </td>
      </tr>

  <?php $i++;
    }
    echo '</tbody>';
    echo '</table>';
    echo '<button type="submit" id="button" class="btn btn-success ">บันทึกข้อมูล(Checkbox)</button>';
    echo '<input class="btn btn-info" onclick="checkAll()" value="เลือกทั้งหมด" readonly>';
    echo '<input class="btn btn-warning" onclick="uncheckAll()" value="ยกเลิก" readonly>';
    echo '</form>';
    echo '</div>';
  }

  // EDIT -------------------
  if ($_ARRAUTH['EDIT'] == 1) {
    // display
    echo '';
  }

  // VIEW ------------------
  if ($_ARRAUTH['VIEW'] == 1) {
    // display
    echo '';
  }
  ?>
</body>

</html>