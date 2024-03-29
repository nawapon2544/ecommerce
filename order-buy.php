<?php
require_once('./conn.php');
require_once('./function.php');

@session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$order_id = date("YmdHis") . '-' . number_random(6) . char_random(4);
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$product = $_POST['product'];
$quantity = $_POST['quantity'];
$delivery_cost = $_POST['delivery_cost'];
$total = $_POST['total'];

$order_statement_img = "./order-statement-img";
if (!is_dir($order_statement_img)) {
  mkdir($order_statement_img);
}
$files = $_FILES['statement'];
$tmp_name = $files['tmp_name'];
$file_type = pathinfo($files['name'], PATHINFO_EXTENSION);
$statement = $order_id  . '.' . $file_type;
$tmp_target = "$order_statement_img/$statement";
$upload_statement = move_uploaded_file($tmp_name, $tmp_target);

if (!$upload_statement) {
  echo json_encode(['result' => false]);
  return;
}
if ($upload_statement) {
  $order_thum = "./order-thum";
  if (!is_dir($order_thum)) {
    mkdir($order_thum);
  }
  foreach (json_decode($_POST['product']) as $p) {
    $path_include = "./product-img/$p->thum";
    $thum_after_target = "$order_thum/$p->thum";
    if (file_exists($path_include)) {
      $upload_thum = copy($path_include, $thum_after_target);
      if (!$upload_thum) {
        echo json_encode(['result' => false]);
        return;
      }
    }
  }
  try {
    $order_date = get_date_now();
    $created = get_date_now();
    $modified = get_date_now();
    $delivery_number = "";
    $delivery_service = "";
    $pay_status = "progress";
    $status = "prepare";
    $sql = "INSERT INTO orders VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = connect_db()->prepare($sql);
    $stmt->bindParam(1, $order_id);
    $stmt->bindParam(2, $user_id);
    $stmt->bindParam(3, $product);
    $stmt->bindParam(4, $fname);
    $stmt->bindParam(5, $lname);
    $stmt->bindParam(6, $phone);
    $stmt->bindParam(7, $address);
    $stmt->bindParam(8, $order_date);
    $stmt->bindParam(9, $created);
    $stmt->bindParam(10, $modified);
    $stmt->bindParam(11, $quantity);
    $stmt->bindParam(12, $delivery_cost);
    $stmt->bindParam(13, $total);
    $stmt->bindParam(14, $delivery_number);
    $stmt->bindParam(15, $delivery_number);
    $stmt->bindParam(16, $pay_status);
    $stmt->bindParam(17, $statement);
    $stmt->bindParam(18, $status);

    if ($stmt->execute()) {

      $cart_items = [];
      foreach (json_decode($product)  as $cart) {
        array_push($cart_items, "'$cart->cart_id'");
      }

      $cart_items_delete = implode(',', $cart_items);
      $del = "DELETE FROM cart WHERE cart_id IN($cart_items_delete)";
      $cart_stmt =  connect_db()->prepare($del);
      if ($cart_stmt->execute()) {

        $product_update_err = 0;
        foreach (json_decode($product)  as $p) {
          $up = "UPDATE products SET product_remain=product_remain-$p->quantity WHERE product_id='$p->product_id'";
          $product_stmt = connect_db()->prepare($up);
          if ($product_stmt->execute()) {
          } else {
            $product_update_err++;
            return;
          }
        }

        if ($product_update_err == 0) {
          echo json_encode(['result' => true, 'order_id' => $order_id]);
        } else {
          echo json_encode(['result' => false]);
        }
      } else {
        echo json_encode(['result' => false]);
      }
    } else {
      echo json_encode(['result' => false]);
    }
  } catch (PDOException $e) {
    echo json_encode(['result' => false, 'err' => $e->getMessage()]);
  }
}
