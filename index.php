<?php
require_once('./conn.php');
require_once('./admin/lib/config_abouUs_id.php');
@session_start();

$title_id = ConfigABoutUsID::get_title_id();
$title_row = connect_db()->query("SELECT * FROM about_us WHERE row_id='$title_id'");
$title = $title_row->rowCount() == 1
  ? $title_row->fetch(PDO::FETCH_ASSOC)['data']
  : 'Ecommerce';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    <?php echo $title ?>
  </title>
  <?php require_once('./head.php') ?>
</head>

<body>
  <?php require_once('./navbar.php') ?>
  <div class="container my-3">

    <?php if (count($_GET) == 0) {

      require_once('./home.php');
    } else {

      require_once('./search.php');
    } ?>
  </div>
  <?php require_once('./cart_toast_modal.php') ?>
  <?php require_once('./footer.php')  ?>
  <script src="./script/search.js"></script>
  <script src="./script/index.js"></script>
</body>

</html>