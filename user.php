<?php
require_once('./conn.php');
@session_start();
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
  <title>ฉัน</title>
  <?php require_once('./head.php') ?>
  <link rel="stylesheet" href="./css/user.css">
</head>

<body>
  <?php require_once('./navbar.php') ?>

  <?php
  $user_id = $_SESSION['user_id'];
  $sql = "SELECT * FROM user WHERE user_id='$user_id'";
  $row = connect_db()->query($sql);
  $user = $row->fetch(PDO::FETCH_ASSOC);
  ?>
  <div class="container">
    <div class="bg-white my-3 p-2">
      <div class="d-flex justify-content-between p-2 border-2 border-bottom">
        <h5 class="text-secondary">ข้อมูลส่วนตัว</h5>
      </div>

      <div class="row justify-content-center">
        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
          <div class="my-2">
            <label class="form-label">อีเมล</label>
            <div class="input-group">
              <span class="input-group-text">
                <i class="fa-solid fa-at"></i>
              </span>
              <input type="text" data-validate="true" data-before="<?php echo  $user['email']  ?>" disabled value="<?php echo  $user['email']  ?>" class="form-control" id="email" placeholder="example@exampmail.com">
              <button id="edit-email" class="btn btn-light">
                <i class="fa-solid fa-pen-to-square"></i>
              </button>
            </div>
            <div class="d-flex justify-content-end my-2">
              <button class="bg-none btn-hover btn-control" id="confirm-edit-email">
                <i class="fa-solid fa-square-check"></i>
                ตกลง
              </button>
              <button class="bg-none btn-hover btn-control" id="cancel-edit-email">
                <i class="fa-solid fa-rectangle-xmark"></i>
                ยกเลิก
              </button>
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
              <input type="text" disabled value="<?php echo $user['phone']  ?>" class="form-control" id="phone" placeholder="090-xxxx-000">
              <button class="btn btn-light" id="edit-phone">
                <i class="fa-solid fa-pen-to-square"></i>
              </button>
            </div>

            <div class="d-flex justify-content-end my-2">
              <button class="bg-none btn-hover btn-control" id="confirm-edit-phone">
                <i class="fa-solid fa-square-check"></i>
                ตกลง
              </button>
              <button class="bg-none btn-hover btn-control" id="cancel-edit-phone">
                <i class="fa-solid fa-rectangle-xmark"></i>
                ยกเลิก
              </button>
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
              <input type="text" disabled value="<?php echo $user['username']  ?>" data-register="true" class="form-control" id="username" placeholder="username">
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
              <input type="password" disabled value=" <?php echo $user['password']  ?>" class="form-control" id="password" placeholder="password">
              <button id="change-password" class="btn btn-light">
                <i class="fa-solid fa-pen-to-square"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="row  justify-content-end align-items-center">
          <div class="d-flex justify-content-end align-items-center bg-light p-2 rounded border border-1">
            <p class="m-0 me-2">
              <span>ชื่อ</span>
              <span>นามสกุล</span>
            </p>
            <button id="edit-name" class="bg-none btn-hover ms-2">
              <i class="fa-solid fa-pen-to-square"></i>
              <span>แก้ไข</span>
            </button>
            <button class="bg-none btn-hover btn-control" id="confirm-edit-name">
              <i class="fa-solid fa-square-check"></i>
              ตกลง
            </button>
            <button class="bg-none btn-hover btn-control" id="cancel-edit-name">
              <i class="fa-solid fa-rectangle-xmark"></i>
              ยกเลิก
            </button>
          </div>
        </div>
        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
          <div class="my-2">
            <div class="input-group">
              <span class="input-group-text">
                <i class="fa-regular fa-address-book"></i>
              </span>
              <input type="text" disabled value="<?php echo $user['fname']  ?>" class="form-control" id="fname" placeholder="ป้อนชื่อ">
            </div>
          </div>
        </div>
        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
          <div class="my-2">

            <div class="input-group">
              <span class="input-group-text">
                <i class="fa-solid fa-signature"></i>
              </span>
              <input type="text" disabled value="<?php echo $user['lname'] ?>" class="form-control" id="lname" placeholder="ป้อนนามสกุล">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php require_once('./user_password_modal.php') ?>
  <div id="userToast" class="bg-dark toast position-fixed translate-middle-x top-0 start-50 my-3" data-bs-delay="1200">
    <div class="toast-body text-center text-secondary">
      <div class="toast-icon">
        <i class="fa-solid fa-circle-exclamation"></i>
      </div>
    </div>
  </div>

  <script src="./script/userUpdateName.js"></script>
  <script src="./script/userChangePassword.js"></script>
  <script src="./script/userUpdatePhone.js"></script>
  <script src="./script/userUpdateEmail.js"></script>
</body>

</html>