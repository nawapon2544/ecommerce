<?php
require_once('./conn.php');
require_once('./admin/lib/config_abouUs_id.php');

$term_id = ConfigABoutUsID::get_terms_id();
$waranty_id = ConfigABoutUsID::get_warranty_policy_id();
$delivery_id = ConfigABoutUsID::get_delivery_id();
$refund_product_id = ConfigABoutUsID::get_refund_product_id();
$refundd_money_id = ConfigABoutUsID::get_refund_money_id();
$order_cancel_id = ConfigABoutUsID::get_order_cancel_id();
?>
<footer class="footer">
  <div class="container p-2">
    <div class="row p-2 ">
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
      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12">
        <h4 class="f-logo-brand">
          <?php echo $brand ?>
        </h4>
      </div>
      <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
          <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <a class="f-about-link" href="./about.php?#contact-and-about">
              <small>ติดต่อเรา</small>
            </a>
          </div>
          <?php
          $sql = "SELECT * FROM about_us";
          $row = connect_db()->query($sql);
          ?>
          <?php while ($about_us = $row->fetch(PDO::FETCH_ASSOC)) { ?>
            <?php $checked = $about_us['status'] == 'on' ? 'checked' : '' ?>
            <?php if ($about_us['status'] == 'on') { ?>
              <?php if ($about_us['row_id'] == $term_id) { ?>
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                  <a class="f-about-link" href="./about.php?#terms-and-conditions">
                    <small>ข้อกำหนดและเงื่อนไข</small>
                  </a>
                </div>
              <?php } ?>
              <?php if ($about_us['row_id'] == $waranty_id) { ?>
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                  <a class="f-about-link" href="./about.php?#warranty-policy">
                    <small>นโยบายการรับประกันสินค้า</small>
                  </a>
                </div>
              <?php } ?>
              <?php if ($about_us['row_id'] == $delivery_id) { ?>
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                  <a class="f-about-link" href="./about.php?#delivery">
                    <small>การจัดส่งสินค้า</small>
                  </a>
                </div>
              <?php } ?>
              <?php if ($about_us['row_id'] == $refund_product_id) { ?>
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                  <a class="f-about-link" href="./about.php?#refund-product">
                    <small>การคืนสินค้า</small>
                  </a>
                </div>
              <?php } ?>
              <?php if ($about_us['row_id'] == $refundd_money_id) { ?>
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                  <a class="f-about-link" href="./about.php?#refund-money">
                    <small>การคืนเงิน</small>
                  </a>
                </div>
              <?php } ?>
              <?php if ($about_us['row_id'] == $order_cancel_id) { ?>

                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                  <a class="f-about-link" href="./about.php?#order-cancel">
                    <small>การยกเลิกการสั่งซื้อสินค้า</small>
                  </a>
                </div>
              <?php } ?>
            <?php  } ?>
          <?php   } ?>
        </div>

      </div>
      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12">
        <?php
        $payment_sql = "SELECT DISTINCT(bank) FROM payment WHERE status='on' LIMIT 0,4";
        $payment_r = connect_db()->query($payment_sql);
        ?>
        <h5 class="text-light">
          ช่องการชำระเงิน
        </h5>
        <?php while ($payment = $payment_r->fetch(PDO::FETCH_ASSOC)) { ?>
          <img class="bank-icon-img" src="./icon-bank/<?php echo $payment['bank'] ?>.png">
        <?php   }  ?>
        <?php
        $qrcode_id = ConfigABoutUsID::get_qrcode_id();
        $qrcode_sql = "SELECT * FROM about_us WHERE row_id='$qrcode_id' ";
        $qrcode_r = connect_db()->query($qrcode_sql);
        ?>
        <?php if ($qrcode_r->rowCount() == 1) { ?>
          <div class="row p-2 m-1">
            <div class="col-12 col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-12">
              <img class="qrcode" src="./icon-bank/pp.webp">
            </div>
          </div>
        <?php   } ?>
      </div>
    </div>
  </div>

</footer>
<div class="f-b-right">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
        Copyright&copy; <?php echo date("Y") ?> All rights reserved.
      </div>
      <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <div class="text-end">
          <?php
          require_once('./admin/lib/tracking_chanel_social.php');
          $sql = "SELECT * FROM tracking_chanel";
          $row = connect_db()->query($sql);

          ?>
          <?php while ($tracking_chanel = $row->fetch(PDO::FETCH_ASSOC)) { ?>
            <?php if ($tracking_chanel['set_default'] == 'on') { ?>
              <a class="f-track-link" target="_blank" href="<?php echo  $tracking_chanel['social_link']  ?>">
                <?php echo  set_text_social($tracking_chanel['social']) ?>
              </a>
            <?php   } ?>
          <?php }  ?>
        </div>
      </div>
    </div>
  </div>
</div>