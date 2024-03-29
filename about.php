<?php
require_once('./conn.php');
require_once('./admin/lib/config_abouUs_id.php');
$contact_id = ConfigABoutUsID::get_contact_id();
$term_id = ConfigABoutUsID::get_terms_id();
$waranty_id = ConfigABoutUsID::get_warranty_policy_id();
$delivery_id = ConfigABoutUsID::get_delivery_id();
$refund_product_id = ConfigABoutUsID::get_refund_product_id();
$refundd_money_id = ConfigABoutUsID::get_refund_money_id();
$order_cancel_id = ConfigABoutUsID::get_order_cancel_id();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require_once('./head.php') ?>
  <title>Document</title>
  <link rel="stylesheet" href="./css/about.css">
</head>

<body>
  <?php require_once('./navbar.php') ?>
  <div class="container">
    <section class="d-flex justify-content-center p-2 my-1">
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

      <h4 class="f-logo-brand">
        <?php echo $brand ?>
      </h4>

    </section>
    <div class="row mt-4">
      <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-12 col-sm-12 col-xs-12">
        <ul>
          <li class="about-items">
            <a class="about-link" href="#contact-and-about">
              <small>ติดต่อเรา</small>
            </a>
          </li>
          <?php
          $sql = "SELECT * FROM about_us";
          $row = connect_db()->query($sql);
          ?>
          <?php while ($about_us = $row->fetch(PDO::FETCH_ASSOC)) { ?>
            <?php $checked = $about_us['status'] == 'on' ? 'checked' : '' ?>
            <?php if ($about_us['status'] == 'on') { ?>
              <?php if ($about_us['row_id'] == $term_id) { ?>
                <li class="about-items">
                  <a class="about-link" href="#terms-and-conditions">
                    <small>ข้อกำหนดและเงื่อนไข</small>
                  </a>
                </li>
              <?php } ?>
              <?php if ($about_us['row_id'] == $waranty_id) { ?>
                <li class="about-items">
                  <a class="about-link" href="#warranty-policy">
                    <small>นโยบายการรับประกันสินค้า</small>
                  </a>
                </li>
              <?php } ?>
              <?php if ($about_us['row_id'] == $delivery_id) { ?>
                <li class="about-items">
                  <a class="about-link" href="#delivery">
                    <small>การจัดส่งสินค้า</small>
                  </a>
                </li>
              <?php } ?>
              <?php if ($about_us['row_id'] == $refund_product_id) { ?>
                <li class="about-items">
                  <a class="about-link" href="#refund-product">
                    <small>การคืนสินค้า</small>
                  </a>
                </li>
              <?php } ?>
              <?php if ($about_us['row_id'] == $refundd_money_id) { ?>
                <li class="about-items">
                  <a class="about-link" href="#refund-money">
                    <small>การคืนเงิน</small>
                  </a>
                </li>
              <?php } ?>
              <?php if ($about_us['row_id'] == $order_cancel_id) { ?>
                <li class="about-items active">
                  <a class="about-link" href="#order-cancel">
                    <small>การยกเลิกการสั่งซื้อสินค้า</small>
                  </a>
                </li>
              <?php } ?>
            <?php  } ?>
          <?php   } ?>
        </ul>
      </div>
      <div class="col-xxl-9 col-xl-9 col-lg-8 col-md-12 col-sm-12 col-xs-12">
        <div id="about-wrapper">
          <?php
          $sql = "SELECT * FROM about_us";
          $row = connect_db()->query($sql);
          ?>
          <?php while ($about_us = $row->fetch(PDO::FETCH_ASSOC)) { ?>
            <?php $id = str_ireplace('_', '-', $about_us['name']); ?>

            <?php if ($about_us['row_id'] == $contact_id) { ?>
              <section class="about-us-section" id="<?php echo $id  ?>">
                <?php $contact_us = json_decode($about_us['data']); ?>
                <h4 class="fw-bold" id="contact-brand">
                  <?php echo $contact_us->brand ?>
                </h4>
                <p class="m-0"><?php echo $contact_us->location ?></p>
                <p class="m-0">
                  <span><?php echo $contact_us->sub_district ?></span>
                  <span><?php echo $contact_us->district ?></span>
                  <span><?php echo $contact_us->province ?></span>
                  <span><?php echo $contact_us->postcode ?></span>
                </p>
                <p class="m-0">
                  <span>ติดต่อ</span>
                  <span><?php echo $contact_us->email ?></span>
                </p>
                <p class="m-0">
                  สอบถามข้อมูล หรือ โทรสั่งซื้อ
                  <span> <?php echo $contact_us->contact_phone ?></span>
                </p>
                <p class="m-0">
                  ร้านเปิดทำการ
                  <?php echo $contact_us->business_hours ?></p>
              </section>
            <?php } ?>
            </section>
            <?php if ($about_us['status'] == 'on') { ?>
              <?php if ($about_us['row_id'] == $term_id) { ?>
                <section class="about-us-section" id="<?php echo $id  ?>">
                  <?php echo $about_us['data']  ?>
                </section>
              <?php } ?>
              <?php if ($about_us['row_id'] == $waranty_id) { ?>
                <section class="about-us-section" id="<?php echo $id  ?>">
                  <?php echo $about_us['data']  ?>
                </section>
              <?php } ?>
              <?php if ($about_us['row_id'] == $delivery_id) { ?>
                <section class="about-us-section" id="<?php echo $id  ?>">
                  <?php echo $about_us['data']  ?>
                </section>
              <?php } ?>
              <?php if ($about_us['row_id'] == $refund_product_id) { ?>
                <section class="about-us-section" id="<?php echo $id  ?>">
                  <?php echo $about_us['data']  ?>
                </section>
              <?php } ?>
              <?php if ($about_us['row_id'] == $refundd_money_id) { ?>
                <section class="about-us-section" id="<?php echo $id  ?>">
                  <?php echo $about_us['data']  ?>
                </section>
              <?php } ?>
              <?php if ($about_us['row_id'] == $order_cancel_id) { ?>
                <section class="about-us-section" id="<?php echo $id  ?>">
                  <?php echo $about_us['data']  ?>
                </section>
              <?php } ?>
            <?php  } ?>
          <?php   } ?>
        </div>

      </div>
    </div>
  </div>
  <?php require_once('./footer.php') ?>

  <script>
    window.addEventListener('load', () => {
      const href = location.href
      const includeId = href.includes('#')
      const target = includeId ?
        href.substring(href.indexOf('#')) : 'contact-and-about'
      get_about_target(target)
      aboutUsSectionDisplay(target)
    })

    function aboutLink() {
      return $('.about-link')
    }

    function aboutUsSection() {
      return $('.about-us-section')
    }

    function get_about_target(target) {
      $.each(aboutLink(), (index, el) => {
        if ($(el).attr('href') == target) {
          $(el).addClass('active')
        } else {
          $(el).removeClass('active')
        }
      })
    }


    function aboutUsSectionDisplay(href) {
      $.each(aboutUsSection(), (index, el) => {
        const id = $(el).attr('id')
        if (`#${id}` == href) {
          $(el).css('display', 'block')
        } else {
          $(el).css('display', 'none')
        }
      })
    }


    $('.about-link').click(function() {
      const href = $(this).attr('href')
      aboutUsSectionDisplay(href)
      get_about_target(href)
    })
  </script>
</body>

</html>