<?php

echo 'adsdad';
echo '<select>';
foreach ($result as $id) {
    echo '<option value="'.$id['emp_id'].'">'.$id['emp_id'].' '.$id['emp_fname'].' '.$id['emp_lname'].'</option>';
}
echo '</select>';
?>
// include("gen_time");
?>