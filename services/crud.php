<?php
require_once "db.php";
function createSingle($table, $data){
    global $db;
    $fields = array_keys($data);
    $values = array_map(function($value){
        global $db;
        return "'".$db->real_escape_string($value)."'";
    }, array_values($data));
    $fields = implode(", ", $fields);
    $values = implode(", ", $values);
    $query = "INSERT INTO $table ($fields) VALUES ($values)";

    return $db->query($query);
}
function getSingle($table, $id){
    global $db;
    $query = "SELECT * FROM $table WHERE id = $id";
    $result = $db->query($query);
    if($result){
        return $result->fetch_assoc();
    }else{
        return false;
    }
}

function getSingleOrdered($table, $order){
    global $db;
    $query = "SELECT * FROM $table ORDER BY $order";
    return $db->query($query);
}

function getSingleOrderedJSON($table, $order){
    global $db;
    $result = getSingleOrdered($table, $order);
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return json_encode($data);
}

function getSingleBy($table, $field, $value){
    global $db;
    $query = "SELECT * FROM $table WHERE $field = '$value'";
    $result = $db->query($query);
    if($result){
        return $result->fetch_assoc();
    }else{
        return false;
    }
}

function getSingleMultipleBy($table,$fields, $values){
    global $db;
    $set = array();
    for($i=0; $i<count($fields); $i++){
        $set[] = $fields[$i]."='".$values[$i]."'";
    }
    $set = implode(" AND ", $set);
    $query = "SELECT * FROM $table WHERE $set";
    $result = $db->query($query);
    return $result;
}

function getList($table){
    global $db;
    $query = "SELECT * FROM $table";
    $result = $db->query($query);
    if($result){
        $data = array();
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return $data;
    }else{
        return false;
    }
}
function updateSingle($table, $id, $data){
    global $db;
    $fields = array_keys($data);
    $values = array_map(function($value){
        global $db;
        return $db->real_escape_string($value);
    }, array_values($data));
    $set = array();
    for($i=0; $i<count($fields); $i++){
        $set[] = $fields[$i]."='".$values[$i]."'";
    }
    $set = implode(", ", $set);
    $query = "UPDATE $table SET $set WHERE id = $id";
    $result = $db->query($query);
    if($result){
        return true;
    }else{
        return false;
    }
}
function deleteSingle($table, $id){
    global $db;
    $query = "DELETE FROM $table WHERE id = $id";
    $result = $db->query($query);
    if($result){
        return true;
    }else{
        return false;
    }
}
function deleteList($table, $ids){
    global $db;
    $ids = implode(", ", $ids);
    $query = "DELETE FROM $table WHERE id IN ($ids)";
    $result = $db->query($query);
    if($result){
        return true;
    }else{
        return false;
    }
}
?>
