<?php
require_once('./conn.php');
$cart_id = $_POST['cart_id'];
$sql = "DELETE FROM cart WHERE cart_id='$cart_id'";
try {
  $stmt = connect_db()->prepare($sql);
  if ($stmt->execute()) {
    echo json_encode(['result' => true]);
  } else {
    echo json_encode(['result' => false]);
  }
} catch (PDOException $e) {
  echo json_encode(['result' => false]);
}
