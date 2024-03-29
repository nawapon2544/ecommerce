<div class="position-sticky top-0 m-0" style="z-index:50;">
  <div class="bg-dark m-0">
    <div class="container">
      <div class="nav-profile">
        <?php @session_start();
        if (isset($_SESSION['user_id'])) { ?>
          <?php
          $user_id = $_SESSION['user_id'];
          $user = connect_db()->query("SELECT * FROM user WHERE user_id='$user_id'");
          $user_row = $user->fetch(PDO::FETCH_ASSOC);
          $username = $user_row['username'];
          ?>
          <h6 class="text-secondary d-inline m-0"><?php echo $username ?> </h6>
          <button class="btn text-secondary" type="button" id="logout">

            <span>ออกจากระบบ</span>
            <i class="fa-solid fa-right-from-bracket"></i>
          </button>
        <?php  } else { ?>
          <a href="./signin.php" id="signin-btn" class="btn bg-transparent btn-hover text-light" type="button">
            ลงชื่อเข้าใช้งาน
          </a>
        <?php     } ?>
      </div>
    </div>
  </div>
  <nav id="nav" class="p-2">
    <style>
      .nav-link {
        padding: 6px 12px;
      }
    </style>
    <div class="container">
      <?php
      $logo_id = ConfigABoutUsID::get_logo_id();
      $logo_result = connect_db()->query("SELECT * FROM about_us WHERE row_id='$logo_id'");

      if ($logo_result->rowCount() == 0) {
        $brand = 'ecommerce';
      } else {
        $logo_row =  $logo_result->fetch(PDO::FETCH_ASSOC);
        $logo = json_decode($logo_row['data']);
        $plattern = $logo->plattern;
        $val = $logo->val;
        $brand = $plattern == 'logoText'
          ? "<span>$val</span>" :
          '<img src="./logo/' . $val . '">';
      }

      ?>
      <div class="row w-100">
        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-xs-12">
          <a id="nav-logo" class="nav-link" href="./index.php">
            <?php echo $brand ?>
          </a>
        </div>
        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 col-xs-12 ">
          <div class="nav-target-route">
            <a href="./user.php" class="nav-link nav-target">
              <i class="fa-solid fa-user"></i>
              <span>ฉัน</span>
            </a>
            <a href="./address_user.php" class="nav-link nav-target">
              <i class="fa-solid fa-location-dot"></i>
              <span>ที่อยู่</span>
            </a>
            <a href="./purchase.php?p=all" class="nav-link nav-target">
              <i class="fa-solid fa-repeat"></i>
              <span>ประวัติการซื้อ</span>

            </a>
            <a href="./cart.php" class="nav-link nav-target">
              <i class="fa-solid fa-cart-shopping"></i>
            </a>
          </div>
        </div>
      </div>

      <div class="my-1 row w-100 d-flex justify-content-center">
        <div class="col-xxl-8 col-xl-8 col-lg-10 col-md-12 col-sm-12 col-xs-12">
          <div class="d-flex">
            <input id="keyword" value="<?php echo isset($_GET['keyword']) ? str_ireplace('-', ' ', $_GET['keyword']) : '' ?>" list="search-data-list" class="form-control" placeholder="ค้นหา">
            <button id="search-product" class="mx-1 btn btn-dark">
              <i class="fa-solid fa-magnifying-glass"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <div id="navbar-toast" class="bg-dark toast position-fixed translate-middle-x top-0 start-50 my-3" data-bs-delay="1200">
    <div class="toast-body text-center text-secondary">
      <div class="toast-icon">
        <i class="fa-solid fa-circle-exclamation"></i>
      </div>
    </div>
  </div>
</div>
<script src="./script/navbar.js"></script>