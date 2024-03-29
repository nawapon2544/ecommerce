<?php
require_once('./conn.php');
@session_start();
if (!isset($_SESSION['user_id'])) {
  header('location:./index.php');
}
$page = $_GET['p'];
$index = isset($_GET['index']) ? (int)$_GET['index'] : 0;
$limit = 5;
$entries_start = $index *  ($limit);

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM orders WHERE user_id='$user_id'";

$sql .= $page == 'all' ? "" : " AND status='cancel' ";
$sql .= " ORDER BY created DESC ";

$order_all =  connect_db()->query($sql)->rowCount();
$page_all =  ceil($order_all / $limit);

$sql .= " LIMIT $entries_start,$limit ";
$order_row = connect_db()->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ประวัติการซื้อ</title>
  <?php require_once('./head.php') ?>
  <link rel="stylesheet" href="./css/purchase.css">
</head>

<body>
  <?php require_once('./navbar.php') ?>

  <div class="container">
    <div id="order-w-target">
      <a href="./purchase.php?p=all&index=0" class="btn order-target">
        <span>ทั้งหมด</span>
      </a>
      <a href="./purchase.php?p=cancel&index=0" class="btn order-target">
        <span>ยกเลิก</span>
      </a>
    </div>
    <div class="order-tab my-2">
      <?php if ($order_row->rowCount() == 0) { ?>
        <div class="bg-white p-4  d-flex flex-column justify-content-center align-items-center">
          <div style="font-size: 2rem;">
            <i class="fa-solid fa-circle-exclamation"></i>
          </div>
          <h5 class="text-dark m-0">ไม่มีคำสั่งซื้อ</h5>
        </div>
      <?php }  ?>

      <?php if ($order_row->rowCount() > 0) { ?>
        <div>
          <?php
          while ($order = $order_row->fetch(PDO::FETCH_ASSOC)) { ?>
            <a class="bg-white order-items my-2" href="./order_detail.php?ord=<?php echo base64_encode($order['order_id'])  ?>">
              <div class="mx-2 border-1 border-bottom">
                <div class="row align-items-center p-3">
                  <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <h6 class="my-2 fw-bold text-end text-xxl-start text-xl-start text-lg-start  text-md-end text-sm-end"><?php echo $order['order_id'] ?></h6>
                  </div>
                  <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <h6 class="m-0 text-end text-success fw-bold"><?php echo $order['created'] ?></h6>
                  </div>
                </div>
              </div>

              <?php $product = json_decode($order['product']); ?>

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
            <?php  } ?>
        </div>
      <?php } ?>
      <?php if ($order_row->rowCount() > 0) { ?>
        <?php
        $route = "./purchase.php?p=$page&index=";
        $prev_disabled = $index == 0 ? 'disabled' : '';
        $next_disabled = $index == $page_all - 1  ? 'disabled' : '';
        $first_disabled = $index == 0 ? 'disabled' : '';
        $last_disabled = $index == $page_all - 1  ? 'disabled' : '';
        $last_active = $index == $page_all ? 'active' : ''
        ?>
        <nav class="p-0 m-0 d-flex justify-content-center justify-content-xxl-end justify-content-xl-end justify-content-lg-end justify-content-md-end">
          <ul class="pagination my-1">
            <a class="m-1 page-link text-dark" href="<?php echo  $route . 0  ?>">
              หน้าแรก
            </a>
            <a class="m-1 page-link text-dark" href="<?php echo  $route . $page_all - 1  ?>">
              หน้าสุดท้าย
            </a>
          </ul>
        </nav>
        <nav class="d-flex justify-content-center justify-content-xxl-end justify-content-xl-end justify-content-lg-end justify-content-md-end">
          <ul class="pagination flex-wrap">
            <li class="page-item <?php echo $prev_disabled  ?>">
              <a class="page-link" href="<?php echo  $route . $index - 1  ?>">ก่อนหน้า</a>
            </li>
            <?php if ($page_all <= 5) { ?>
              <?php for ($i = 0; $i < $page_all; $i++) {
                $active = $i == $index ? 'active' : ''; ?>
                <?php if ($i < $page_all) { ?>
                  <li class="page-item">
                    <a class="page-link <?php echo $active  ?>" href="<?php echo  $route . $i  ?>">
                      <?php echo $i + 1 ?>
                    </a>
                  </li>
                <?php } ?>
              <?php } ?>
            <?php } ?>

            <?php if ($page_all > 5) { ?>
              <?php for ($i = $index - 2; $i <= $index + 2; $i++) { ?>
                <?php if ($i >= 0) { ?>
                  <?php if ($i < $index) { ?>
                    <li class="page-item">
                      <a class="page-link <?php echo $active  ?>" href="<?php echo  $route . $i  ?>">
                        <?php echo $i + 1 ?>
                      </a>
                    </li>
                  <?php } ?>
                <?php } ?>
              <?php } ?>
              <?php for ($i = $index; $i < $index + 3; $i++) {
                $active = $i == $index ? 'active' : ''; ?>
                <?php if ($index  <= $page_all) { ?>
                  <?php if ($i < $page_all) { ?>
                    <li class="page-item">
                      <a class="page-link <?php echo $active  ?>" href="<?php echo  $route . $i  ?>">
                        <?php echo $i + 1 ?>
                      </a>
                    </li>
                  <?php } ?>
                <?php } ?>
              <?php } ?>
            <?php } ?>
            <li class="page-item <?php echo $next_disabled  ?>">
              <a class="page-link" href="<?php echo  $route . $index + 1  ?>">
                ถัดไป
              </a>
            </li>
          </ul>
        </nav>
      <?php  } ?>
    </div>
  </div>
  <script src="./script/purchase.js"></script>
</body>

</html>