<?php
require_once('./conn.php');
require_once('./admin/lib/config_abouUs_id.php');
$icon_id = ConfigABoutUsID::get_icon_id();
$sql = "SELECT data FROM about_us WHERE row_id='$icon_id'";
$icon_row = connect_db()->query($sql);
$icon = $icon_row->fetch(PDO::FETCH_ASSOC);
?>
<?php if ($icon_row->rowCount() == 1) { ?>
  <link rel="icon" href="./logo/<?php echo $icon['data']  ?>" sizes="16x16">
<?php } ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="./css/index.css">
<link rel="stylesheet" href="./css/style.css">
<link rel="stylesheet" href="./css/font.css">
<link rel="stylesheet" href="./css/navbar.css">
<link rel="stylesheet" href="./css/footer.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="./js/code.jquery.com_jquery-3.7.0.min.js"></script>
<script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="./js/alert.js"></script>
<script src="./js/createElement.js"></script>
<script src="./js/toast.js"></script>
<script src="./js/function.js"></script>
<script src="./js/setNumberFormat.js"></script>
<script src="./js/setStyle.js"></script>