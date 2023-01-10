<?php
include_once("config.php");
$input = filter_input_array(INPUT_POST);
if ($input['action'] == 'edit') {	
    $update_field='';
    if(isset($input['so'])) {
        $update_field.= "so='".$input['so']."'";
    }	
    if($update_field && $input['id']) {
        $sql_query = "UPDATE opname SET $update_field WHERE id='" . $input['id'] . "'";	
        mysqli_query($conn, $sql_query) or die("database error:". mysqli_error($conn));		
    }
}
?>