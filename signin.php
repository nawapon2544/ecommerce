<?php
@session_start();
if (isset($_SESSION['user_id'])) {
  header('location:./index.php');
}
require_once('./conn.php');
require_once('./admin/lib/config_abouUs_id.php');


$title_id = ConfigABoutUsID::get_title_id();
$title_row = connect_db()->query("SELECT * FROM about_us WHERE row_id='$title_id'");
$title = $title_row->rowCount() == 1
  ? $title_row->fetch(PDO::FETCH_ASSOC)['data']
  : 'Ecommerce';


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

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title ?></title>
  <?php require_once('./head.php'); ?>
  <link rel="stylesheet" href="./css/navbar.css">
  <link rel="stylesheet" href="./css/signin.css">
</head>

<body>
  <nav id="nav" class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a id="nav-logo" class="nav-link" href="./index.php">
        <?php echo $brand ?>
      </a>
      <span class="navbar-text fw-bold">
        ลงชื่อเข้าใช้งาน
      </span>
    </div>
  </nav>
  <div class="container-fluid">
    <div class="shop-img">
      <img src="./img/shopping-cart.png" alt="" srcset="">
    </div>
    <div class="d-flex justify-content-center">
      <div id="signin">
        <h5 class="text-center text-secondary">ลงชื่อเข้าใช้งาน</h5>
        <label class="form-label">อีเมล ชื่อผู้ใช้งาน</label>
        <div class="input-group my-2">
          <span class="input-group-text" id="basic-addon1">
            <i class="fa-solid fa-user"></i>
          </span>
          <input type="text" class="form-control" id="username" placeholder="email or username">
        </div>
        <label class="form-label">รหัสผ่าน</label>
        <div class="input-group my-2">
          <span class="input-group-text" id="basic-addon1">
            <i class="fa-solid fa-key"></i>
          </span>
          <input type="password" class="form-control" id="password" placeholder="รหัสผ่าน">
        </div>
        <div class="d-flex justify-content-center">
          <button id="login" class="login btn-hover">
            เข้าสู่ระบบ
          </button>
          <span class="text-secondary">มีบัญชีแล้วหรือไม่ ? </span>
          <a id="register" href="./resgister.php" class="fw-bold btn-hover register">
            สมัครสมาชิก
          </a>
        </div>

      </div>
    </div>

  </div>
  <div id="signin-toast" class="bg-dark toast position-fixed translate-middle-x top-0 start-50 my-3" data-bs-delay="15000">
    <div class="toast-body text-center text-secondary">
      <div class="toast-icon">
        <i class="fa-solid fa-circle-exclamation"></i>
      </div>
      <h6 class="fw-bold">เกิดข้อผิดพลาด</h6>
    </div>
  </div>
  <script src="./script/signin.js"></script>
</body>

</html>