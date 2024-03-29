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
  <title>ที่อยู่</title>
  <?php require_once('./head.php') ?>

  <link rel="stylesheet" href="./css/order_history.css">
  <link rel="stylesheet" href="./css/address_user.css">
</head>

<body>
  <?php require_once('./navbar.php') ?>

  <div class="container">
    <div class="my-2 bg-white p-2">
      <h5 class="m-0 p-2 border-bottom border-1">ที่อยู่</h5>
      <button id="add-address" class="my-2 btn btn-primary">
        <i class="fa-solid fa-plus"></i>
        เพิ่มที่อยู่
      </button>
    </div>

    <div>
      <?php
      $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
      if (!empty($user_id)) {
        $sql_address = "SELECT * FROM address WHERE user_id='$user_id' ORDER BY created desc";
        $address_row = connect_db()->query($sql_address);
        $address_count = $address_row->rowCount();
        $idx = 0;

        if ($address_count > 0) {
          while ($address = $address_row->fetch(PDO::FETCH_ASSOC)) {
            $idx++;
            $address_display = $idx == 1 ? 'block' : 'none';
            $address_checked = $idx == 1 ? 'checked' : '';
            $default_address = $idx == 1 ? 'true' : 'false';
            $name = $address['address_fname'] . ' ' . $address['address_lname'];
            $address_detail = "$address[address_detail] $address[sub_district] ";
            $address_detail .= "$address[district] $address[province] $address[postcode]";

      ?>
            <div class="my-2 p-2 address-items bg-white ">
              <div class="d-flex justify-content-end align-items-center">
                <button class="btn btn-light mx-1 address-modal" data-address="<?php echo base64_encode(json_encode($address)) ?>" data-id="<?php echo base64_encode($address['address_id'])  ?>">
                  <i class="fa-solid fa-pen-to-square"></i>
                  <span>แก้ไข</span>
                </button>
                <button class="btn btn-light mx-1 delete-address-user" data-id="<?php echo base64_encode($address['address_id'])  ?>">
                  <i class="fa-solid fa-trash-can"></i>
                  <span>ลบ</span>
                </button>
              </div>
              <div class="d-flex align-items-center">
                <div class="p-2">
                  <p class="m-0 fw-bold">
                    <?php echo $name ?>
                  </p>
                  <p class="m-0 text-secondary">
                    <?php echo $address['address_phone'] ?>
                  </p>
                  <p class="m-0">
                    <?php echo $address_detail ?>
                  </p>
                </div>
              </div>
            </div>
          <?php   }  ?>
        <?php  } ?>
      <?php  } ?>
    </div>
  </div>
  <?php require_once('./address_user_modal.php') ?>
  </div>

  <div id="address-user-toast" class="bg-dark toast position-fixed translate-middle-x top-0 start-50 my-3" data-bs-delay="1200">
    <div class="toast-body text-center text-secondary">
      <div class="toast-icon">
        <i class="fa-solid fa-circle-exclamation"></i>
      </div>
    </div>
  </div>
  <script src="./script/addressUseraAdd.js"></script>
  <script src="./script/addressUser.js"></script>
  <script src="./script/addressUserDelete.js"></script>
  <script src="./script/addressUserModal.js"></script>
  <script src="./script/addressUserLoadDistrict.js"></script>
  <script src="./script/addressUserLoadSubDistrict.js"></script>
  <script src="./script/addressUserChangeDistrict.js"></script>
</body>

</html>