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
</head>

<body>
  <?php require_once('./navbar.php') ?>
  <div class="container">
    <div class="my-2 bg-white p-2">
      <h5 class="m-0 p-2 border-bottom border-1">ที่อยู่</h5>
      <button class="my-2 btn btn-primary" data-bs-toggle="modal" data-bs-target="#address-modal">
        <i class="fa-solid fa-plus"></i>
        เพิ่มที่อยู่
      </button>
    </div>
    <div>
      <?php
      $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
      if (!empty($user_id)) {
        $sql_address = "SELECT * FROM address WHERE user_id='$user_id'";
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
              <div class="d-flex align-items-center">
                <div class="form-check d-none address-check-items">
                  <input class="form-check-input" data-address="<?php echo base64_encode(json_encode($address)) ?>" type="radio" name="address" <?php echo $address_checked  ?>>
                </div>
                <div class="p-2">
                  <p class="m-0 fw-bold"><?php echo $name ?></p>
                  <p class="m-0 text-secondary">
                    <?php echo $address['address_phone'] ?>
                  </p>
                  <p class="m-0"><?php echo $address_detail ?></p>
                </div>
              </div>
            </div>
          <?php   }  ?>
        <?php  } ?>
      <?php  } ?>
    </div>
  </div>
  <?php require_once('./address_modal.php') ?>
</body>

</html>