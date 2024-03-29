<?php
require_once('./conn.php');
require_once('./admin/lib/create_darshboard_func.php');
$sql = "SELECT * FROM orders";
$dashboard = new CreateDashboard($sql);
$product_id  =  $dashboard->getProductID();
$best_saller_list = $dashboard->max_total_in_array('product_id', $product_id);
$best_saller_id = array_splice($best_saller_list['subject'], 0, 5);


?>
<div class="my-3">
  <h5 class="bg-danger d-inline px-2 text-light rounded-3">
    รายการแนะนำ
  </h5>
  <div class="row">
    <?php foreach ($best_saller_id as $id) { ?>
      <?php
      $best_product_sql = "SELECT * FROM products WHERE product_id='$id' ";
      $best_product_result = connect_db()->query($best_product_sql);
      $best_product = $best_product_result->fetch(PDO::FETCH_ASSOC);

      $best_product_name = str_ireplace(' ', '-', $best_product['product_name']);
      $best_product_href = "./product.php?&n=$product_name&id=" . base64_encode($best_product['product_id']);
      ?>
      <a href="<?php echo $best_product_href  ?>" class="col-12 col-xxl-3 col-xl-3 col-lg-4 col-md-4 col-sm-6 btn border-0 btn-hover ">

        <div class="card rounded-0 h-100">
          <p class="bg-dark text-light d-inline px-2">
            ขายดี
            <i class="fa-solid fa-star"></i>
          </p>
          <img src="./product-img/<?php echo  explode(',', $best_product['img'])[0] ?>" class="card-img-top">
          <div class="my-2 card-body">
            <h5 class="card-title text-center text-truncate">
              <?php echo $best_product['product_name'] ?>
            </h5>
            <div class="text-center p-1">
              <?php
              $best_prodcut_price = (float) $best_product['product_price'];
              $best_prodcut_real_price = (float)  $best_product['product_real_price'];
              ?>

              <?php
              if ($best_prodcut_real_price < $best_prodcut_price) { ?>
                <span class="fw-bold product-price">
                  <span class="product-price-discount"></span>
                  <?php echo number_format($best_prodcut_price, 2)  ?>
                </span>
              <?php    }
              ?>
              <span class="fw-bold text-danger">
                <?php echo number_format($best_prodcut_real_price, 2)  ?>
              </span>
              <?php if ($best_prodcut_real_price < $best_prodcut_price) { ?>
                <?php
                $best_discount = $best_prodcut_price - $best_prodcut_real_price;
                $best_discount_persent = ceil(($best_discount * 100) / $best_prodcut_price); ?>
                <span class="badge bg-danger">
                  <span>ลดราคา</span>
                  <strong> <?php echo $best_discount_persent  ?></strong>
                  <span>%</span>
                </span>
              <?php    } ?>
            </div>
          </div>
        </div>
      </a>
    <?php } ?>
    <?php
    $best_view_sql = "SELECT product_view.*,products.* FROM ";
    $best_view_sql .= " product_view LEFT JOIN products ON ";
    $best_view_sql .= " product_view.product_id=products.product_id ";
    $best_view_sql .= " ORDER BY product_view.view DESC LIMIT 0,5";
    $best_product_view_result = connect_db()->query($best_view_sql);
    ?>
    <?php while ($best_view = $best_product_view_result->fetch(PDO::FETCH_ASSOC)) {

      $best_view_name = str_ireplace(' ', '-', $best_view['product_name']);
      $best_view_href = "./product.php?&n=$best_view_name&id=" . base64_encode($best_view['product_id']);
    ?>
      <a href="<?php echo $best_view_href  ?>" class="col-12 col-xxl-3 col-xl-3 col-lg-4 col-md-4 col-sm-6 btn border-0 btn-hover ">

        <div class="card rounded-0 h-100">
          <p class="bg-dark text-light d-inline px-2">
            ยอดนิยม
            <i class="fa-solid fa-star"></i>
          </p>
          <img src="./product-img/<?php echo  explode(',', $best_view['img'])[0] ?>" class="card-img-top">
          <div class="my-2 card-body">
            <h5 class="card-title text-center text-truncate">
              <?php echo $best_view['product_name'] ?>
            </h5>
            <div class="text-center p-1">
              <?php
              $best_view_price = (float) $best_view['product_price'];
              $best_view_real_price = (float)  $best_view['product_real_price'];
              ?>

              <?php
              if ($best_view_real_price < $best_view_price) { ?>
                <span class="fw-bold product-price">
                  <span class="product-price-discount"></span>
                  <?php echo number_format($best_view_price, 2)  ?>
                </span>
              <?php    }
              ?>
              <span class="fw-bold text-danger">
                <?php echo number_format($best_view_real_price, 2)  ?>
              </span>
              <?php if ($best_view_price > $best_view_real_price) { ?>
                <?php
                $best_view_discount = $best_view_price - $best_view_real_price;
                $best_view_discount_p = ceil(($best_view_discount * 100) / $best_view_price); ?>
                <span class="badge bg-danger">
                  <span>ลดราคา</span>
                  <strong> <?php echo $best_view_discount_p  ?></strong>
                  <span>%</span>
                </span>
              <?php    } ?>
            </div>
          </div>
        </div>
      </a>
    <?php } ?>
  </div>
</div>