<?php
require_once('./conn.php');
require_once('./admin/lib/config_abouUs_id.php');
$logo_id = ConfigABoutUsID::get_logo_id();
$sql = "SELECT * FROM about_us WHERE row_id='$logo_id'";
$row = connect_db()->query($sql);
$about_us = $row->fetch(PDO::FETCH_ASSOC);

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
  <link rel="stylesheet" href="./css/register.css">
  <link rel="stylesheet" href="./navbar.php">
</head>

<body>
  <nav id="nav" class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="./index.php">
      <?php echo $brand ?>
      </a>
      <span class="navbar-text fw-bold">
        สมัครสมาชิก
      </span>
    </div>
  </nav>
  <div class="container">
    <div id="register">
      <h5 class="text-center text-secondary">สมัครสมาชิก</h5>
      <div class="row justify-content-center">
        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
          <div class="my-2">
            <label class="form-label">อีเมล</label>
            <div class="input-group">
              <span class="input-group-text">
                <i class="fa-solid fa-at"></i>
              </span>
              <input type="text" data-register="false" class="form-control" id="email" placeholder="example@exampmail.com">
            </div>
          </div>
        </div>
        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
          <div class="my-2">
            <label class="form-label">เบอร์ติดต่อ</label>
            <div class="input-group">
              <span class="input-group-text">
                <i class="fa-solid fa-phone-volume"></i>
              </span>
              <input type="text" class="form-control" id="phone" placeholder="090-xxxx-000">
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
          <div class="my-2">
            <label class="form-label">ชื่อผู้ใช้งาน</label>
            <div class="input-group">
              <span class="input-group-text">
                <i class="fa-solid fa-user"></i>
              </span>
              <input type="text" data-register="false" class="form-control" id="username" placeholder="username">
            </div>
          </div>
        </div>
        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
          <div class="my-2">
            <label class="form-label">รหัสผ่าน</label>
            <div class="input-group">
              <span class="input-group-text">
                <i class="fa-solid fa-key"></i>
              </span>
              <input type="password" class="form-control" id="password" placeholder="password">
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
          <div class="my-2">
            <label class="form-label">ชื่อ</label>
            <div class="input-group">
              <span class="input-group-text">
                <i class="fa-regular fa-address-book"></i>
              </span>
              <input type="text" class="form-control" id="fname" placeholder="ป้อนชื่อ">
            </div>
          </div>
        </div>
        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
          <div class="my-2">
            <label class="form-label">นามสกุล</label>
            <div class="input-group">
              <span class="input-group-text">
                <i class="fa-solid fa-signature"></i>
              </span>
              <input type="text" class="form-control" id="lname" placeholder="ป้อนนามสกุล">
            </div>
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-center">
        <button class="fw-boldregister bg-none btn-hover d-inline" id="add-register">
          สมัครสมาชิก
        </button>
        <span class="mx-2 text-secondary">หรือ ?</span>
        <a href="./signin.php" class="login d-inline">เข้าสู่ระบบ</a>
      </div>
    </div>
    <div id="register-toast" class="bg-dark toast position-fixed translate-middle-x top-0 start-50 my-3" data-bs-delay="1200">
      <div class="toast-body text-center text-secondary">
        <div class="toast-icon">
          <i class="fa-solid fa-circle-exclamation"></i>
        </div>
      </div>
    </div>
  </div>
  <script src="./script/register.js"></script>
</body>

</html>