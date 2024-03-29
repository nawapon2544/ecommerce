<?php
$page_index = isset($_GET['index']) ? $_GET['index'] : 0;

$entries = 12;
$index  = $entries * $page_index;
$get_p_type = isset($_GET['pty']) ? $_GET['pty'] : '';
$get_p_gty = isset($_GET['gty']) ? $_GET['gty'] : '';
$get_keyword = isset($_GET['keyword']) ? str_ireplace('-', ' ', $_GET['keyword']) : '';
$get_price = isset($_GET['price']) ? $_GET['price'] : '';
$get_min_price = isset($_GET['min_price']) ? $_GET['min_price'] : '';
$get_max_price = isset($_GET['max_price']) ? $_GET['max_price'] : '';
$product_search_sql = "SELECT * FROM products ";

$product_search_sql .= !empty($get_p_gty)
  ? "WHERE product_category LIKE '%$get_p_gty%'" : '';

$product_search_sql .= !empty($get_p_type)
  ? "WHERE product_type LIKE '%$get_p_type%'" : '';
$keyword = explode(' ', $get_keyword);

function create_key_word($keyword, $column)
{
  $kw_str = "(";
  foreach ($keyword as $index =>  $kw) {
    $kw_str .= "$column LIKE '%$kw%' ";

    if ($index < count($keyword) - 1) {
      $kw_str .= " AND ";
    }
    if ($index == count($keyword) - 1) {
      $kw_str .= ") ";
    }
  }
  return $kw_str;
}

$p_name_kw = create_key_word($keyword, 'product_name');
$p_type_kw = create_key_word($keyword, 'product_type');
$p_gty_kw = create_key_word($keyword, 'product_category');
$p_detail_kw = create_key_word($keyword, 'product_detail');
$p_data_kw = create_key_word($keyword, 'product_data');
$p_kw = create_key_word($keyword, 'product_keyword');
$kw_str = " WHERE ($p_name_kw OR ";
$kw_str .= "$p_type_kw OR $p_gty_kw OR ";
$kw_str .= "$p_detail_kw OR $p_data_kw OR $p_kw)";


$product_search_sql .= !empty($get_keyword)
  ? $kw_str : '';

$product_search_sql .= !empty($get_price) ? "
 AND (product_real_price >= $get_price OR
 product_price >= $get_price)
" : '';

$product_search_sql .= !empty($get_min_price) ? "
 AND (product_real_price BETWEEN $get_min_price  AND $get_max_price OR
 product_price BETWEEN $get_min_price  AND $get_max_price)
" : '';


$product_search_result = connect_db()->query($product_search_sql);

$row_count_all = connect_db()->query($product_search_sql)->rowCount();
$product_search_sql .= " LIMIT $index,$entries";
$page_all = ceil($row_count_all / $entries);


$route = "index.php";
$route .= !empty($get_p_gty) ? "?gty=$get_p_gty" : '';
$route .= !empty($get_p_type) ? "?pty=$get_p_type" : '';
$route .= !empty($get_keyword) ? "?keyword=$get_keyword" : '';
$route .= count($_GET) > 0 ? "&index=" : "?index=";


$word = '';
$word .= !empty($get_p_gty)
  ? "หมวดหมู่สินค้า <span class='text-danger fw-bold'>'$get_p_gty'</span>"
  : '';
$word .= !empty($get_p_type)
  ? "ประเภทสินค้า  <span class='text-danger fw-bold'>'$get_p_type'</span>"
  : '';
$word .=
  !empty($get_keyword)
  ? "ค้นหา <span class='text-danger fw-bold'>'$get_keyword'</span>"
  : '';

$word .= !empty($get_min_price) ?
  " ช่วงราคา <span class='text-danger fw-bold'>'$get_min_price'</span>
  ถึง <span class='text-danger fw-bold'>'$get_max_price'</span>" : '';


$word .= !empty($get_price) ?
  " ช่วงราคา <span class='text-danger fw-bold'>'$get_price'</span>
  ขึ้นไป" : '';
$price_selected = '';

if (!empty($get_price)) {
  $price_selected = $get_price;
} else if (!empty($get_min_price)) {
  $price_selected = "$get_min_price-$get_max_price";
}

?>

<div class="dropdown">
  <button class="w-100 btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    เลือกหมวดหมู่
  </button>
  <ul class="dropdown-menu w-100">
    <?php
    $product_type_sql = "SELECT DISTINCT product_type FROM products";
    $p_type_result = connect_db()->query($product_type_sql);

    ?>
    <?php while ($p_type_row = $p_type_result->fetch(PDO::FETCH_ASSOC)) { ?>
      <?php
      $p_type_row_d = explode(',', $p_type_row['product_type'])[0];
      ?>
      <li>
        <a class="dropdown-item" href="./index.php?pty=<?php echo $p_type_row_d ?>" class="p-type-items-link">
          <i class="fa-solid fa-arrows-to-dot"></i>
          <?php echo $p_type_row_d ?>
        </a>
      </li>
    <?php } ?>

    <?php
    $product_gty_sql = "SELECT DISTINCT product_category FROM products";
    $p_gty_result = connect_db()->query($product_gty_sql);

    ?>
    <?php while ($p_gty_row = $p_gty_result->fetch(PDO::FETCH_ASSOC)) { ?>
      <?php
      $p_gty_row_d = explode(',', $p_gty_row['product_category'])[0];
      ?>
      <li>
        <a class="dropdown-item" href="./index.php?gty=<?php echo $p_gty_row_d ?>" class="p-type-items-link">
          <i class="fa-solid fa-arrows-to-dot"></i>
          <?php echo $p_gty_row_d ?>
        </a>
      </li>
    <?php } ?>
</div>
</section>
<div>
  <div class="row p-2 align-items-center justify-content-center">
    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-12 col-sm-12">
      <select data-price="<?php echo $price_selected  ?>" class="form-select" id="product-price-list">
        <option value="" selected>เลือกราคา</option>
        <option value="0-999">0-999</option>
        <option value="1000-1999">1,000-1,999</option>
        <option value="2000-4999">2,000-4,999</option>
        <option value="5000-9999">5,000-9,999</option>
        <option value="10000-14999">10,000-14,999</option>
        <option value="15000-19999">15,000-19,999</option>
        <option value="20000">20,000</option>
      </select>
    </div>
    <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-12">
      <div class="my-2">
        <button id="search-product-reset" class="btn btn-dark">
          ล้างค้นหา
        </button>
      </div>
    </div>
  </div>
  <p class="my-2 p-2" style="background-color: #F5F5F5;">
    <?php echo $word ?>
  </p>
</div>
<div style="min-height:40vh ;">
  <?php if ($product_search_result->rowCount() == 0) { ?>
    <div class="bg-white p-4">
      <i class="fa-solid fa-face-sad-cry" style="font-size: 2rem;"></i>
      <p class="m-0 text-dark">ไม่พบสินค้า</p>
    </div>
  <?php  } ?>
  <?php if ($product_search_result->rowCount() > 0) { ?>
    <div class="row g-2">
      <?php while ($product_search = $product_search_result->fetch(PDO::FETCH_ASSOC)) {   ?>
        <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-sm-12 col-xs-12">
          <div class="card my-2 border-0 rounded-0 p-3 h-100">
            <img src="./product-img/<?php echo  explode(',', $product_search['img'])[0] ?>" class="card-img-top">
            <div class="my-2 card-body">
              <h5 class="card-title text-center text-truncate">
                <?php echo $product_search['product_name'] ?>
              </h5>

              <div class="text-center p-1">
                <?php
                $prodcut_price = (float) $product_search['product_price'];
                $prodcut_real_price = (float)  $product_search['product_real_price'];
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
                  <button type="button" class="m-1 btn btn-warning add-cart" data-productId="<?php echo base64_encode($product_search['product_id'])  ?>">
                  <i class="bi bi-cart3"></i>
                    เพิ่มลงรถเข็น
                  </button>

                  <button type="button" class="m-1 btn btn-dark buy-product" data-productId="<?php echo base64_encode($product_search['product_id'])  ?>">
                    ซื้อ
                  </button>

                </div>
              <?php   } ?>

              <?php
              $product_name = str_ireplace(' ', '-', $product_search['product_name']);
              $href = "./product.php?id=" . base64_encode($product_search['product_id']) . "&n=$product_name";
              ?>
              <a href="<?php echo $href  ?>" class="btn border-0 btn-light d-block btn-hover">
                ดูรายละเอียด
              </a>
            </div>
          </div>
        </div>
      <?php  } ?>
    </div>
    <?php if ($product_search_result->rowCount() > 0) { ?>
      <?php
      $first_active = $page_index == 0 ? 'disabled' : '';
      $last_active = $page_index == $page_all - 1 ? 'disabled' : ''
      ?>
      <nav class="d-flex justify-content-end my-2">
        <ul class="pagination pagination-sm my-2">
          <li class="page-item <?php echo $first_active  ?>">
            <a class="page-link" href="./<?php echo $route . 0 ?>">
              หน้าแรก
            </a>
          </li>
          <li class="page-item <?php echo $last_active  ?>">
            <a class="page-link" href="./<?php echo $route . $page_all - 1 ?>">
              หน้าสุดท้าย
            </a>
          </li>
        </ul>
      </nav>

      <nav class="d-flex justify-content-end">
        <ul class="pagination pagination-sm">
          <?php if ($page_index >= 1) {
            $prefix = $page_index - 1
          ?>
            <li class="page-item">
              <a class="page-link" href="./<?php echo $route . $prefix ?>">
                <i class="fa-solid fa-angle-left"></i>
              </a>
            </li>
          <?php   }  ?>
          <?php
          if ($page_all <= 5) { ?>
            <?php
            for ($i = 0; $i < $page_all; $i++) {
              $page_active = $i == $page_index ? 'active' : '';
            ?>
              <li class="page-item <?php echo $page_active  ?>">
                <a class="page-link" href="./<?php echo $route . $i ?>">
                  <?php echo $i + 1 ?>
                </a>
              </li>
            <?php }  ?>
          <?php  } ?>
          <?php
          if ($page_all > 5) { ?>
            <?php for ($i = $page_index - 2; $i <= $page_index; $i++) {
              $page_active = $i == $page_index ? 'active' : '';
              if ($i >= 0) { ?>
                <li class="page-item <?php echo $page_active  ?>">
                  <a class="page-link" href="./<?php echo $route . $i ?>">
                    <?php echo $i + 1  ?>
                  </a>
                </li>
              <?php }  ?>
            <?php      }  ?>
            <?php for ($i = $page_index + 1; $i <= $page_index + 2; $i++) {
              $page_active = $i == $page_index ? 'active' : '';
              if ($i < $page_all) { ?>
                <li class="page-item <?php echo $page_active  ?>">
                  <a class="page-link" href="./<?php echo $route . $i ?>">
                    <?php echo $i + 1  ?>
                  </a>
                </li>
              <?php  }
              ?>
            <?php      }  ?>
          <?php }  ?>
          <?php if ($page_index < $page_all - 1) {
            $sufix = $page_index + 1
          ?>
            <li class="page-item">
              <a class="page-link" href="./<?php echo $route . $sufix ?>">
                <i class="fa-solid fa-angle-right"></i>
              </a>
            </li>
          <?php   }  ?>
        </ul>
      </nav>
    <?php } ?>
  <?php } ?>

</div>

