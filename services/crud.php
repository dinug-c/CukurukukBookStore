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

function getAll($table){
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

function getSingleNoSpicy($table){
    global $db;
    $query = "SELECT * FROM $table ORDER BY Category";
    return $db->query($query);
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

function getSingleByQuery($table, $field, $value){
    global $db;
    $query = "SELECT * FROM $table WHERE $field = '$value'";
    return $db->query($query);
}

function getCountField($table, $field){
    global $db;
    $query = "SELECT $field FROM $table";
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
function deleteSingle($table,$field, $id){
    global $db;
    $query = "DELETE FROM $table WHERE $field = $id";
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

function getCategories() {
    global $db; // Pastikan variabel $db telah didefinisikan sebelumnya

    $query = "SELECT id, namaKategori FROM kategori"; // Gantilah "kategori" dengan nama tabel kategori yang sesuai di database Anda
    $result = $db->query($query);

    if (!$result) {
        die("Could not query the database: <br/>" . $db->error . "<br/>Query: " . $query);
    }

    $categories = array();
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }

    return $categories;
}

function getCountByCategory() {
    global $db; // Variabel koneksi database yang Anda gunakan

    $query = "SELECT Category, COUNT(*) AS Count FROM buku GROUP BY Category";
    $result = $db->query($query);

    $categoryCounts = array();

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $categoryCounts[] = $row;
        }
        $result->free();
    }

    return $categoryCounts;
}

// Fungsi untuk mengambil penjualan buku berdasarkan kategori dari tabel penjualan
function getSalesByCategory() {
    global $db; // Variabel koneksi database yang Anda gunakan

    $query = "SELECT kategori.namaKategori AS CategoryName, penjualan.jumlah AS TotalSales
              FROM penjualan
              JOIN kategori ON penjualan.kategoriId = kategori.id
              GROUP BY kategori.namaKategori";

    $result = $db->query($query);

    $salesByCategory = array();

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $salesByCategory[] = $row;
        }
        $result->free();
    }

    return $salesByCategory;
}


?>
