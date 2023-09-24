<?php
function getCountByAS($table, $field, $value){
    global $db;
    $query = "SELECT COUNT(*) AS $field FROM $table WHERE $field = '$value'";
    $result = $db->query($query);
    if($result){
        return $result->fetch_assoc();
    }else{
        return false;
    }
}
?>