<?php

require_once('./conn.php');
$order_id = base64_decode($_GET['ord']);
$sql = "SELECT * FROM orders WHERE order_id='$order_id' ";
$row = connect_db()->query($sql);
$order = $row->fetch(PDO::FETCH_ASSOC);
$address = json_decode($order['address']);
$product = json_decode($order['product']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require_once('./head.php') ?>
  <title>ecommmerce</title>
</head>

<body>
  <?php require_once('./navbar.php')  ?>
  <div class="container">

    <div class="my-2 bg-white row g-2 border-1 border-bottom p-2 align-items-center">
      <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
        <div class="fw-bold m-0 text-end text-xxl-start text-xl-start text-lg-start  text-md-end text-sm-end">
          <p class="m-0">หมายเลขคำสั่งซื้อ</p>
          <p class="m-0 text-secondary"><?php echo $order['order_id'] ?></p>
        </div>
      </div>
      <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
        <p class="fw-bold text-success m-0 text-end">
          <?php echo $order['created'] ?>
        </p>
      </div>
    </div>

    <?php if (!empty($order['delivery_service']) && !empty($order['delivery_number'])) { ?>
      <div class="bg-white p-2 text-end my-2 ">
        <p class="m-0">
          <span>จัดส่งโดย</span>
          <span class="text-secondary">
            <?php echo $order['delivery_service']  ?>
          </span>
        </p>
        <p class="m-0">
          <span>หมายเลขขนส่ง</span>
          <span class="fw-bold text-danger">
            <?php echo $order['delivery_number']  ?>
          </span>
        </p>
      </div>
    <?php }  ?>

    <div class="g-2 row">
      <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
        <div class="bg-white  p-3 my-2">
          <h5 class="m-0">ที่อยู่</h5>
          <p class="m-0">
            <?php echo $order['fname'] . ' ' . $order['lname'] ?>
          </p>
          <p class="m-0">
            <?php echo $order['phone'] ?>
          </p>
          <p class="m-0"><?php echo $address[0] ?></p>
          <p class="m-0"><?php echo str_ireplace(',',' ',$address[1]) ?></p>
        </div>
      </div>

      <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
        <div class="bg-white p-3 my-2">
          <?php foreach ($product as $p) { ?>
            <div class="border-1 border-bottom">
              <div class="row p-2 align-items-center">
                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-4 col-sm-4 col-xs-4">
                  <div class="text-center">
                    <img style="height:3rem" src="./order-thum/<?php echo $p->thum  ?>" alt="" srcset="">
                  </div>
                </div>
                <div class="col-xxl-6 col-xl-6 col-lg-4 col-md-8 col-sm-8 col-xs-8">
                  <h5 class="m-0 text-secondary text-center text-xxl-start text-xl-start text-lg-start text-md-start">
                    <?php echo $p->product_name ?>
                  </h5>
                </div>
                <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-8 col-sm-8 col-xs-8">
                  <div class="text-end p-2">
                    <span class="text-secondary">จำนวน</span>
                    <span class="text-danger fw-bold">
                      x<?php echo $p->quantity ?>
                    </span>
                  </div>
                </div>
                <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-4 col-sm-4 col-xs-4">
                  <div class="m-0 text-end p-3">
                    <?php
                    $prodcut_price = (float) $p->product_price;
                    $prodcut_real_price = (float)  $p->product_real_price;
                    ?>
                    <?php
                    if ($prodcut_real_price < $prodcut_price) { ?>
                      <span class="fw-bold product-price">
                        <span class="product-price-discount"></span>
                        <?php echo number_format($prodcut_price, 2)  ?>
                      </span>
                    <?php    }
                    ?>
                    <span class="fw-bold text-danger">
                      <?php echo number_format($prodcut_real_price, 2)  ?>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
          <p class="m-0 text-end p-3">
            <span>รวมทั้งสิ้น</span>
            <strong class="text-danger"> <?php echo number_format($order['total'], 2)  ?></strong>
          </p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>