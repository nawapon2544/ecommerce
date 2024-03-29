<?php
require_once('./conn.php');
require_once('./function.php');

$address_id = $_POST['address_id'];
$address_fname = $_POST['address_fname'];
$address_lname = $_POST['address_lname'];
$address_phone = $_POST['address_phone'];
$address_detail = $_POST['address_detail'];
$sub_district = $_POST['sub_district'];
$district = $_POST['district'];
$province = $_POST['province'];
$postcode = $_POST['postcode'];

$created = date("Y-m-d H:i:s");
$modified = date("Y-m-d H:i:s");

try {
  $sql = "UPDATE address SET address_fname='$address_fname',";
  $sql .= "address_lname='$address_lname',";
  $sql .= "address_phone='$address_phone',";
  $sql .= "address_detail='$address_detail',";
  $sql .= "sub_district='$sub_district',";
  $sql .= "district='$district',";
  $sql .= "province='$province',";
  $sql .= "postcode='$postcode',";
  $sql .= "modified='$modified' ";
  $sql .= " WHERE address_id='$address_id'";

  $stmt = connect_db()->prepare($sql);
  echo $sql;
  if ($stmt->execute()) {
    echo json_encode(['result' => true]);
  } else {
    echo json_encode(['result' => false]);
  }
} catch (PDOException $e) {
  echo json_encode(['result' => false, 'err' => $e->getMessage()]);
}
