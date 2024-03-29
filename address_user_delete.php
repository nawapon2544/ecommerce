<?php
require_once('./conn.php');
$address_id = $_POST['address_id'];
$sql =  "DELETE FROM address WHERE address_id='$address_id'";
try{
  $stmt = connect_db()->prepare($sql);
  if($stmt->execute()){
    echo json_encode(['result'=>true]);
  }else{
    echo json_encode(['result'=>false]);
  }
}catch (PDOException $e){
  echo json_encode(['result'=>true,'err'=>$e->getMessage()]);
}
