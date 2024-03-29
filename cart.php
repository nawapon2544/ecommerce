<?php
require_once('./conn.php');
@session_start();
if (!isset($_SESSION['user_id'])) {
  header('location:./signin.php');
}
$user_id = $_SESSION['user_id'];
$sql = "SELECT  cart.*,products.* FROM cart ";
$sql .= "LEFT JOIN products ON cart.product_id=products.product_id ";
$sql .= "WHERE cart.user_id='$user_id' AND products.product_remain > 0 ";
$sql .= " ORDER BY cart.modified DESC";

$row = connect_db()->query($sql);
$row_count = $row->rowCount();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require_once('./head.php') ?>
  <title>รถเข็น</title>
  <link rel="stylesheet" href="./css/cart.css">
</head>

<body>
  <?php require_once('./navbar.php') ?>
  <div id="carts" data-last="<?php echo $row_count  ?>" data-offset="false" class="my-2">
    <div class="container my-2">
      <?php while ($product = $row->fetch(PDO::FETCH_ASSOC)) { ?>
        <div class="bg-white my-2 cart-items d-flex p-2 align-items-center border-1 border-bottom">
          <div class="d-flex justify-content-center" style="width: 10%;">
            <div class="form-check">
              <input class="form-check-input" name="cart-order" type="checkbox" value="<?php echo base64_encode(json_encode($product)) ?>">
            </div>
          </div>
          <div style="width: 90%;">
            <div class="row align-items-center">
              <div class="col-xxl-4 col-xl-4 col-lg-3 col-md-8 col-sm-12 col-xs-12">
                <div class="row align-items-center">
                  <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-12 col-sm-12 col-xs-12">
                    <img class="table-img" src="./product-img/<?php echo explode(',', $product['img'])[0]  ?>">
                  </div>
                  <div class="col-xxl-10 col-xl-10 col-lg-9 col-md-12 col-sm-12 col-xs-12">
                    <div class="text-xl-start text-lg-start text-center">
                      <p class="m-0 w-100 "> <?php echo $product['product_name']  ?></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-4 col-sm-12 col-xs-12 text-end my-1">
                <div>
                  <?php
                  $prodcut_price = $product['product_price'];
                  $prodcut_real_price = $product['product_real_price'];
                  ?>
                  <?php
                  if ($prodcut_real_price < $prodcut_price) { ?>
                    <span class="fw-bold product-price">
                      <span class="product-price-discount"></span>
                      <?php echo number_format($product['product_price'], 2)  ?>
                    </span>
                  <?php    }
                  ?>
                  <span class="fw-bold text-danger">
                    <?php echo number_format($product['product_real_price'], 2)  ?>
                  </span>
                </div>

              </div>
              <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-12 col-sm-12 col-xs-12 my-1">
                <div class="d-flex justify-content-end">
                  <button class="btn btn-light btn-qty" data-target="reduce-qty" data-price="<?php echo base64_encode($product['product_real_price'])  ?>" data-productId="<?php echo base64_encode($product['product_id']) ?>">
                    <i class="fa-solid fa-minus"></i>
                  </button>
                  <input type="text" class="cart-qty" name="cart-qty" value="<?php echo $product['quantity']  ?>" min="1" max="<?php echo $product['product_remain']   ?>">
                  <button class="btn btn-light btn-qty" data-target="add-qty" data-price="<?php echo base64_encode($product['product_real_price'])  ?>" data-productId="<?php echo base64_encode($product['product_id']) ?>">
                    <i class="fa-solid fa-plus"></i>
                  </button>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-8 col-sm-8 col-xs-8 my-1">
                <?php $total = (float)$product['product_real_price'] * (float)$product['quantity']  ?>
                <input disabled class="border-0 bg-transparent w-100 text-end" type="text" value="<?php echo number_format($total, 2) ?>">
              </div>
              <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-4 col-sm-4 col-xs-4 text-end">
                <button class="btn btn-light delete-cart" data-cartId="<?php echo base64_encode($product['cart_id'])  ?>">
                  <i class="fa-solid fa-trash-can"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      <?php   } ?>
    </div>
    <?php
    $sql = "SELECT  cart.*,products.* FROM cart ";
    $sql .= "LEFT JOIN products ON cart.product_id=products.product_id ";
    $sql .= "WHERE cart.user_id='$user_id' AND products.product_remain < 1 ";
    $sql .= " ORDER BY cart.modified DESC";
    $sold_out = connect_db()->query($sql); ?>
    <?php if ($sold_out->rowCount() > 0) { ?>
      <div class="container my-2">
        <h5 class="text-secondary">สินค้าหมดแล้ว</h5>

        <?php while ($product = $sold_out->fetch(PDO::FETCH_ASSOC)) { ?>
          <div class="bg-white my-2 cart-items d-flex p-2 align-items-center border-1 border-bottom disabled">
            <div class="d-flex justify-content-center" style="width: 10%;">

            </div>
            <div style="width: 90%;">
              <div class="row align-items-center">
                <div class="col-xxl-4 col-xl-4 col-lg-3 col-md-8 col-sm-12 col-xs-12">
                  <div class="row align-items-center">
                    <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-12 col-sm-12 col-xs-12">
                      <img class="table-img" src="./product-img/<?php echo explode(',', $product['img'])[0]  ?>">
                    </div>
                    <div class="col-xxl-10 col-xl-10 col-lg-9 col-md-12 col-sm-12 col-xs-12">
                      <div class="text-xl-start text-lg-start text-center">
                        <p class="m-0 w-100 "> <?php echo $product['product_name']  ?></p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-4 col-sm-12 col-xs-12 text-end my-1">
                  <div>
                    <?php
                    $prodcut_price = $product['product_price'];
                    $prodcut_real_price = $product['product_real_price'];
                    ?>
                    <?php
                    if ($prodcut_real_price < $prodcut_price) { ?>
                      <span class="fw-bold product-price">
                        <span class="product-price-discount"></span>
                        <?php echo number_format($product['product_price'], 2)  ?>
                      </span>
                    <?php    }
                    ?>
                    <span class="fw-bold text-danger">
                      <?php echo number_format($product['product_real_price'], 2)  ?>
                    </span>
                  </div>

                </div>
                <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-12 col-sm-12 col-xs-12 my-1">
                  <div class="d-flex justify-content-end">
                    <button class="btn btn-light btn-qty" disabled data-target="reduce-qty" data-price="<?php echo base64_encode($product['product_real_price'])  ?>" data-productId="<?php echo base64_encode($product['product_id']) ?>">
                      <i class="fa-solid fa-minus"></i>
                    </button>
                    <input type="text" class="cart-qty" disabled name="cart-qty" value="<?php echo $product['quantity']  ?>" min="1" max="<?php echo $product['product_remain']   ?>">
                    <button class="btn btn-light btn-qty" disabled data-target="add-qty" data-price="<?php echo base64_encode($product['product_real_price'])  ?>" data-productId="<?php echo base64_encode($product['product_id']) ?>">
                      <i class="fa-solid fa-plus"></i>
                    </button>
                  </div>
                </div>
                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-8 col-sm-8 col-xs-8 my-1">
                  <?php $total = (float)$product['product_real_price'] * (float)$product['quantity']  ?>
                  <input disabled class="border-0 bg-transparent w-100 text-end" type="text" value="<?php echo number_format($total, 2) ?>">
                </div>
                <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-4 col-sm-4 col-xs-4 text-end">
                  <button class="btn btn-light delete-cart" data-cartId="<?php echo base64_encode($product['cart_id'])  ?>">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        <?php   } ?>
      </div>
    <?php  }  ?>
  </div>

  <div id="cart-bar">
    <div class="container text-xl-start text-lg-start text-md-end text-sm-end text-xs-end ">
      <button class="btn btn-light" id="delete-orders">
        <i class="fa-solid fa-trash-can"></i>
      </button>
      <button class="btn btn-dark" id="select-orders">
        เลือกทั้งหมด
      </button>
      <button class="btn btn-danger" id="order-product">
        สั่งสินค้า
      </button>
    </div>
  </div>
  <?php require_once('./cart_toast_modal.php') ?>
  <script src="./script/cart.js"></script>
</body>

</html>