<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require_once('./head.php') ?>
  <title>Document</title>
</head>

<body>
  <?php require_once('./navbar.php') ?>
  <div class="container">
    <div class="bg-white p-2 my-2">
      <h5 class="fw-bold text-center">
        <span>หมายเลขคำสั่งซื้อ</span>
        <?php echo $_POST['order-id'] ?>
      </h5>
      <div class="text-center">
        <div class="buy-success-icon text-success" style="font-size: 3rem;">
          <i class="fa-regular fa-circle-check"></i>
        </div>
        <p class="m-0 text-success h5">สั่งซื้อสำเร็จ</p>
      </div>
      <div class="p-2 m-1 border rounded">
        <p class="m-0 fw-bold">ที่อยู่ในการจัดส่ง</p>
        <p class="m-0"><?php echo $_POST['fname'] . ' ' . $_POST['lname']   ?></p>
        <p class="m-0"><?php echo $_POST['phone'] ?></p>
        <p class="m-0"><?php echo $_POST['address-detail']  ?></p>
        <p class="m-0"><?php echo $_POST['address-text']  ?></p>
      </div>

      <p class="m-0 text-end">
        <span class="text-secondary">ยอดรวม</span>
        <span class="fw-bold text-danger">
          <?php echo number_format($_POST['total'], 2)  ?>
        </span>
      </p>
      <a href="./index.php" class="btn btn-light rounded-0">กลับหน้าแรก</a>
    </div>
  </div>
  <script>
    window.addEventListener('load', () => {
      setInterval(() => {
        location.assign('./index.php')
      }, 10000)
    })
  </script>
  <?php require_once('./footer.php')  ?>
</body>

</html>