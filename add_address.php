<?php
require_once('./conn.php');
require_once('./function.php');

@session_start();
$user_id = $_SESSION['user_id'];
$address_id = "ad-" . date("YmdHis") . number_random(2) . '-' . char_random(4);
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
  $sql = "INSERT INTO address VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
  $stmt = connect_db()->prepare($sql);
  $stmt->bindParam(1, $address_id);
  $stmt->bindParam(2, $user_id);
  $stmt->bindParam(3, $address_fname);
  $stmt->bindParam(4, $address_lname);
  $stmt->bindParam(5, $address_phone);
  $stmt->bindParam(6, $address_detail);
  $stmt->bindParam(7, $sub_district);
  $stmt->bindParam(8, $district);
  $stmt->bindParam(9, $province);
  $stmt->bindParam(10, $postcode);
  $stmt->bindParam(11, $created);
  $stmt->bindParam(12, $modified);

  if ($stmt->execute()) {
    echo json_encode(['result' => true]);
  } else {
    echo json_encode(['result' => false]);
  }
} catch (PDOException $e) {
  echo json_encode(['result' => false]);
}
