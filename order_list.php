<?php
require_once('./conn.php');
require_once('./admin/lib/payment_display.php');
require_once('./admin/lib/config_abouUs_id.php');
@session_start();
$order = json_decode($_POST['order']);
if (!isset($_SESSION['user_id'])) {
  header('location:./index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>สั่งสินค้า</title>
  <?php require_once('./head.php') ?>
  <link rel="stylesheet" href="./css/product.css">
  <link rel="stylesheet" href="./css/buy-product.css">
  <link rel="stylesheet" href="./css/address_form.css">
  <link rel="stylesheet" href="./css/order_list.css">
</head>

<body>
  <?php require_once('./navbar.php') ?>
  <div class="container mt-2 mb-4">

    <div>
      <h5 class="row bg-white p-2 ">การสั่งซื้อ</h5>
      <?php
      $order_list = [];
      $sum_total = 0;
      $sum_delivery_cost = 0;
      foreach ($order as $ord) { ?>
        <?php
        $_product_id = $ord->product_id;
        $qty = $ord->qty;
        $_cart_id = $ord->cart_id;
        $sql = "SELECT * FROM products WHERE product_id='$_product_id'";
        $product_result  =  connect_db()->query($sql);
        $product = $product_result->fetch(PDO::FETCH_ASSOC);
        $product_img = explode(',', $product['img']);

        $buy_product = [];
        $buy_product['product_name'] = $product['product_name'];
        $buy_product['thum'] = $product_img[0];
        $buy_product['product_price'] = $product['product_price'];
        $buy_product['product_real_price'] = $product['product_real_price'];
        $buy_product['quantity'] = $qty;
        $buy_product['product_id'] = $product['product_id'];
        $buy_product['cart_id'] = $_cart_id;
        ?>
        <div class="my-2">

          <div class="row p-3 align-items-center border-1 border-bottom bg-white">

            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12 border-1">
              <div class="row align-items-center">
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 text-center">
                  <img src="./product-img/<?php echo $product_img[0]  ?>" class="table-img">
                </div>
                <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
                  <p class="m-0 text-xl-start text-lg-start text-center"> <?php echo $product['product_name']  ?></p>
                </div>
              </div>
            </div>
            <div class="text-center col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12">
              <div class="text-end">
                <span class="text-secondary">ราคา</span>
                <?php
                $prodcut_price = (float)$product['product_price'];
                $prodcut_real_price = (float) $product['product_real_price'];
                ?>
                <?php
                if ($prodcut_real_price < $prodcut_price) { ?>
                  <span class="fw-bold" id="product-price">
                    <span id="product-price-discount"></span>
                    <?php echo number_format($product['product_price'], 2)  ?>
                  </span>
                <?php    }
                ?>
                <span class="fw-bold text-danger">
                  <?php echo number_format($product['product_real_price'], 2)  ?>
                </span>
              </div>
            </div>
          </div>
          <div class="row p-3 align-items-center bg-white">
            <div class="col-12 text-end">
              <span class="text-secondary">จำนวน</span>
              <span class="fw-bold text-danger">
                <?php echo $qty ?>
              </span>
              <span class="text-secondary">
                ชิ้น
              </span>
            </div>
            <div class="col-12 text-end">
              <span class="text-secondary">รวมสินค้า</span>
              <?php $product_total = (int)$qty * (float)$product['product_real_price']  ?>
              <span class="fw-bold text-danger">
                <?php echo number_format($product_total, 2) ?>
              </span>
            </div>
            <?php
            $delivery_cost = (array)json_decode($product['delivery_cost']);
            $dry = 0;
            foreach ($delivery_cost as $q) {
              if ($q->count == $qty) {
                $dry = $q->delivery_cost;
              }
            }
            $total = $dry + $product_total;
            $buy_product['delivery_cost'] = $dry;
            $buy_product['total'] = $total;
            $sum_total += $total;
            $sum_delivery_cost += $dry;
            array_push($order_list, $buy_product);
            ?>
          </div>
        </div>
      <?php } ?>
    </div>
    <div class="row bg-white p-3">
      <div class="col-12 text-end">
        <span class="text-secondary">ค่าจัดส่ง</span>
        <span class="fw-bold text-danger">
          <?php echo number_format($sum_delivery_cost, 2) ?>
        </span>
      </div>
      <div class="col-12 text-end">
        <span class="text-secondary">รวมทั้งสิน</span>
        <span class="fw-bold text-danger">
          <?php echo number_format($sum_total, 2) ?>
        </span>
      </div>
    </div>
    <?php require_once('./address_form.php') ?>
    <div class="row">

      <div class="my-2 bg-white p-2">
        <h5 class="fw-lighter p-1">ช่องทางการชำระเงิน</h5>
        <?php
        $qrcode_id = ConfigABoutUsID::get_qrcode_id();
        $qrcode_sql = "SELECT * FROM about_us WHERE row_id='$qrcode_id'";
        $qrcode = connect_db()->query($qrcode_sql);
        ?>
        <?php if ($qrcode->rowCount() == 1) { ?>
          <div class="row">
            <div class="col-12 col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-12">
              <img class="qrcode" src="./logo/<?php echo $qrcode->fetch(PDO::FETCH_ASSOC)['data']  ?>">
            </div>
          </div>
        <?php }  ?>
        <?php
        $pay_sql = "SELECT * FROM payment WHERE status='on' LIMIT 0,5";
        $payment_row = connect_db()->query($pay_sql);
        ?>
        <?php while ($payment = $payment_row->fetch(PDO::FETCH_ASSOC)) { ?>
          <div class="d-flex flex-wrap align-items-center">
            <img class="bank-icon" src="./icon-bank/<?php echo  $payment['bank'] ?>.png">
            <div class="m-2">
              <p class="m-0">
                <?php echo get_bank($payment['bank']) ?>
              </p>
              <p class="m-0">
                <?php echo $payment['account_number'] ?>
              </p>
            </div>
          </div>
        <?php  } ?>
        <div class="row justify-content-center">
          <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12">
            <div class="my-1">
              <label for="statement" class="form-label btn btn-dark btn-hover border-0  w-100">
                <input type="file" id="statement">
                <i class="fa-solid fa-up-down"></i>
                อัพโหลดหลักฐานชำระเงิน
              </label>
            </div>
          </div>
          <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12">
            <div class="my-1">
              <button id="order-buy" class="btn btn-light w-100" data-buy-product="<?php echo base64_encode(json_encode($order_list))  ?>">
                ซื้อ
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="order-modal" class="modal modal-hidden-border border-0 rounded-0" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body">
            <h6 class="my-1 p-3 text-danger">กรุณาเลือกที่อยู่ก่อน</h6>
            <button type="button" class="btn btn-dark rounded-0 w-100" data-bs-dismiss="modal">
              ตกลง
            </button>
          </div>
        </div>
      </div>
    </div>
    <div id="address-toast" class="bg-dark toast position-fixed  bottom-0 end-0 my-3" data-bs-delay="1200">
      <div class="toast-body text-center text-secondary">
        <div class="toast-icon">
          <i class="fa-solid fa-circle-exclamation"></i>
        </div>
      </div>
    </div>

    <div id="order-toast" class="bg-dark toast position-fixed translate-middle-x  top-0 start-50 my-3" data-bs-delay="1200">
      <div class="toast-body text-center text-secondary">
        <div class="toast-icon">
          <i class="fa-solid fa-circle-exclamation"></i>
        </div>
      </div>
    </div>
  </div>
  <script src="./script/order_list.js"></script>
</body>

</html>