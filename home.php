<section id="product-list-q">
  <div class="list-unstyled row  p-0 m-0">
    <?php
    $product_type_sql = "SELECT DISTINCT product_type FROM products";
    $p_type_result = connect_db()->query($product_type_sql);

    ?>
    <?php while ($p_type_row = $p_type_result->fetch(PDO::FETCH_ASSOC)) { ?>
      <?php
      $p_type_row_d = explode(',', $p_type_row['product_type'])[0];
      ?>
      <div class="col-4 col-xxl-2 col-xl-2 col-lg-3 col-md-4 col-sm-6  p-type-items">
        <a href="./index.php?pty=<?php echo $p_type_row_d ?>" class="p-type-items-link">
          <i class="fa-solid fa-hurricane"></i>
          <?php echo $p_type_row_d ?>
        </a>
      </div>
    <?php } ?>

    <?php
    $product_gty_sql = "SELECT DISTINCT product_category FROM products";
    $p_gty_result = connect_db()->query($product_gty_sql);

    ?>
    <?php while ($p_gty_row = $p_gty_result->fetch(PDO::FETCH_ASSOC)) { ?>
      <?php
      $p_gty_row_d = explode(',', $p_gty_row['product_category'])[0];
      ?>
      <div class="col-4 col-xxl-2 col-xl-2 col-lg-3 col-md-4 col-sm-6 p-type-items">
        <a href="./index.php?gty=<?php echo $p_gty_row_d ?>" class="p-type-items-link">
          <i class="fa-solid fa-hurricane"></i>
          <?php echo $p_gty_row_d ?>
        </a>
      </div>
    <?php } ?>
  </div>
</section>
<?php
$slide_sql = "SELECT * FROM slide";
$slide_result = connect_db()->query($slide_sql);
$slide_list = [];
while ($slide = $slide_result->fetch(PDO::FETCH_ASSOC)) {
  array_push($slide_list, $slide);
}
?>
<div class="my-2">
  <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">
    <div class="carousel-indicators">
      <?php foreach ($slide_list as $idx => $slide) {
        $slide_active = $idx == 0 ? 'active' : '';
      ?>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?php echo $idx ?>" class="<?php echo $slide_active ?>">
        </button>
      <?php } ?>

    </div>
    <div class="carousel-inner">
      <?php foreach ($slide_list as $idx => $slide) {
        $slide_active = $idx == 0 ? 'active' : '';
      ?>
        <div class="carousel-item <?php echo $slide_active ?>">
          <img src="./picture-slide/<?php echo $slide['img'] ?>" class="d-block w-100">
          <div class="carousel-caption d-none d-md-block">
            <p>
              <?php echo $slide['descript'] ?>
            </p>
          </div>
        </div>
      <?php } ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</div>

<section>
  <?php
  $sql = "SELECT * FROM products WHERE product_remain > 0  ORDER BY modified DESC LIMIT 0,8";
  $product_list = connect_db()->query($sql);
  ?>
  <h5 class="badge bg-danger">
    สินค้ามาใหม่
  </h5>
  <div class="row g-2">
    <?php while ($product = $product_list->fetch(PDO::FETCH_ASSOC)) {   ?>
      <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-sm-12 col-xs-12">
        <div class="card my-2 p-3 h-100">
          <img src="./product-img/<?php echo  explode(',', $product['img'])[0] ?>" class="card-img-top">
          <div class="my-2 card-body ">
            <h5 class="card-title text-center text-truncate">
              <?php echo $product['product_name'] ?>
            </h5>

            <div id="price" class="text-center p-1">
              <?php
              $prodcut_price = (float) $product['product_price'];
              $prodcut_real_price = (float)  $product['product_real_price'];
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
              <?php if ($prodcut_real_price < $prodcut_price) { ?>
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

            <?php if (isset($_SESSION['user_id'])) {  ?>
              <div class="product-control-btn">
                <button type="button" class="m-1 btn btn-warning w-100 add-cart" data-productId="<?php echo base64_encode($product['product_id'])  ?>">
                  เพิ่มลงรถเข็น
                </button>

                <button type="button" class="w-100 m-1 btn btn-dark buy-product" data-productId="<?php echo base64_encode($product['product_id'])  ?>">
                  ซื้อ
                </button>
              </div>
            <?php   } ?>

            <?php
            $product_name = str_ireplace(' ', '-', $product['product_name']);
            $href = "./product.php?id=" . base64_encode($product['product_id']) . "&n=$product_name";
            ?>
            <a href="<?php echo $href  ?>" class="btn border-0 btn-light d-block btn-hover">
              ดูรายละเอียด
            </a>
          </div>
        </div>
      </div>
    <?php  } ?>
  </div>
</section>
<script>
  window.addEventListener('load', () => {
    $.ajax({
      url: './request/fetch_website_views.php',
      type: 'post',
    })
  })
</script>