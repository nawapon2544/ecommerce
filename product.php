<?php
require_once('./conn.php');
@session_start();
$isset_user_id = isset($_SESSION['user_id'])  ? 'true' : 'false';
$product_name = isset($_GET['n']) ? str_ireplace('-', ' ', $_GET['n']) : '';
$product_id = base64_decode($_GET['id']);
$sql = "SELECT * FROM products WHERE product_id='$product_id'";
$product_list = connect_db()->query($sql);
$product = $product_list->fetch(PDO::FETCH_ASSOC);
$product_img = explode(',', $product['img']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $product['product_name']  ?></title>
  <?php require_once('./head.php') ?>
  <link rel="stylesheet" href="./css/product.css">
</head>

<body>
  <?php require_once('./navbar.php') ?>
  <div class="container">
    <div class="p-0 my-3 row bg-white">
      <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
        <div id="ProductCarousel" class="carousel slide p-3" data-bs-ride="true">
          <div class="carousel-indicators">
            <?php foreach ($product_img as $index => $img) { ?>
              <?php $active = $index == 0 ? 'active' : '' ?>
              <button type="button" data-bs-target="#ProductCarousel" data-bs-slide-to="<?php echo $index  ?>" class="<?php echo $active  ?>">
              </button>
            <?php } ?>
          </div>
          <div class="carousel-inner">
            <?php foreach ($product_img as $index => $img) { ?>
              <?php $active = $index == 0 ? 'active' : '' ?>
              <div class="carousel-item <?php echo $active  ?>">
                <img src="./product-img/<?php echo $img  ?>" class="d-block w-100 carousel-img">
              </div>
            <?php } ?>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#ProductCarousel" data-bs-slide="prev">
            <span class="visually-visible text-dark">
              <i class="fa-solid fa-angle-left"></i>
            </span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#ProductCarousel" data-bs-slide="next">
            <span class="visually-visible text-dark">
              <i class="fa-solid fa-angle-right"></i>
            </span>
          </button>
        </div>
      </div>
      <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12" style="height:100% !important ;">
        <div class="py-3 px-2">
          <h5 class="fw-bold m-0 p-2">
            <?php echo $product['product_name']  ?>
          </h5>
          <div class="bg-danger bg-opacity-25 rounded px-3 py-1">
            <?php
            $prodcut_price = $product['product_price'];
            $prodcut_real_price = $product['product_real_price'];
            ?>
            <span class="text-secondary">ราคา</span>
            <?php
            if ($prodcut_real_price < $prodcut_price) { ?>
              <span class="fw-bold product-price" class="">
                <span class="product-price-discount"></span>
                <?php echo number_format($product['product_price'], 2)  ?>
              </span>
            <?php    }
            ?>
            <span class="fw-bold text-danger">
              <?php echo number_format($product['product_real_price'], 2)  ?>
            </span>
            <?php
            if ($prodcut_real_price < $prodcut_price) { ?>
              <?php
              $discount = $prodcut_price - $prodcut_real_price;
              $discount_persent = ceil(($discount * 100) / $prodcut_price); ?>
              <span class="badge bg-danger">
                <span>ลดราคา</span>
                <strong> <?php echo $discount_persent  ?></strong>
                <span>%</span>
              </span>
            <?php    } ?>

          </div>
          <div class="my-2">
            <button class="btn btn-outline-danger qty-btn" id="reduce-qty">
              <i class="fa-solid fa-minus"></i>
            </button>
            <input type="text" class="cart-qty" id="cart-qty" value="1" min="1" max="<?php echo $product['product_remain'] ?>">
            <button class="btn btn-outline-danger qty-btn" id="add-qty">
              <i class="fa-solid fa-plus"></i>
            </button>
          </div>
          <div class="my-2">
            <span class="text-dark">คงเหลือ</span>
            <span class="fw-bold text-secondary">
              <?php echo $product['product_remain'] ?>
            </span>
          </div>
          <?php  ?>

          <div class="my-2 d-flex flex-md-wrap p-1 ">
            <button data-login="<?php echo base64_encode($isset_user_id) ?>" class="flex-grow-1 m-1 btn btn-light p-2" id="buy-product" data-productId="<?php echo base64_encode($product['product_id']) ?>">
              ซื้อ
            </button>
            <button data-login="<?php echo base64_encode($isset_user_id) ?>" id="add-cart" class="flex-grow-1 m-1 btn btn-secondary p-2" data-productId="<?php echo base64_encode($product['product_id']) ?>">
              <i class="fa-solid fa-plus"></i>
              <span>เพิ่มลงรถเข็น</span>
            </button>
          </div>
        </div>
      </div>
    </div>
    <?php $product_data = json_decode($product['product_data']); ?>



    <div class="row bg-white my-3">
      <h5 class="fw-bold text-secondary my-2 ">
        คุณสมบัติสินค้า
      </h5>
      <div class="col-xxl-6 col-xl-6 col-lg-8 col-md-10 col-sm-12 col-xs-12">
        <table class="table">
          <tr>
            <th>หมวดหมู่สินค้า</th>
            <td>
              <?php echo $product['product_category']  ?>
            </td>
          </tr>
          <tr>
            <th>ประเภทสินค้า</th>
            <td>
              <?php echo $product['product_type']  ?>
            </td>
          </tr>
          <?php
          $dimension =  json_decode($product['product_dimension']);


          $width = isset($dimension->width) ? $dimension->width : '';
          $height = isset($dimension->height) ? $dimension->height : '';
          $depth = isset($dimension->depth) ? $dimension->depth : '';

          $width_size = !empty($width->size) ? $width->size : '';
          $width_unit = !empty($width->unit) ? $width->unit : '';
          $height_size = !empty($height->size) ? $height->size : '';
          $height_unit = !empty($height->unit) ?  $height->unit : '';
          $depth_size = !empty($depth->size) ? $depth->size : '';
          $depth_unit = !empty($depth->unit) ? $depth->unit : '';

          $width_text = !empty($width) ? 'W' : '';
          $heigh_text = !empty($height) ? 'H' : '';
          $depth_text = !empty($depth) ? 'D' : '';

          $dimension_text_arr = [$width_text, $heigh_text, $depth_text];
          $dimension_val_arr = [
            "$width_size $width_unit", "$height_size $height_unit",
            "$depth_size $depth_unit"
          ];

          $filter_dimention_text = array_filter(
            $dimension_text_arr,
            function ($t) {
              return !empty(trim($t));
            }
          );

          $filter_dimention_val = array_filter(
            $dimension_val_arr,
            function ($t) {
              return !empty(trim($t));
            }
          );

          $dimension_text = implode(' x ', $filter_dimention_text);
          $dimension_val = implode(' x ', $filter_dimention_val);


          ?>
          <?php if (!empty($dimension_text)) { ?>
            <tr>
              <th>ขนาด (<?php echo  $dimension_text ?>)</th>
              <td>
                <?php echo $dimension_val  ?>
              </td>
            </tr>

          <?php } ?>

          <?php foreach ($product_data as $p) { ?>
            <tr>
              <th><?php echo $p->prop_detail  ?></th>
              <td>
                <?php echo $p->detail_value  ?>
                <?php echo !empty($p->unit) ?  $p->unit : '' ?>
              </td>
            </tr>
          <?php } ?>
          <tr>
        </table>
      </div>
    </div>
    <div class="row my-2 bg-white" id="product-detail">
      <div class="col-12">
        <div>
          <h5 class="p-2 my-1">รายละเอียด</h5>
        </div>

        <div class="p-3 m-0">
          <?php echo  nl2br($product['product_detail'])  ?>
        </div>
      </div>

    </div>
    <?php require_once('./product_top_view.php') ?>
  </div>

  <?php require_once('./cart_toast_modal.php') ?>
  <script src="./script/search.js"></script>
  <script src="./script/product.js"></script>
  <?php require_once('./footer.php') ?>
</body>

</html>