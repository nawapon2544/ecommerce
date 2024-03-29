<?php require_once('./conn.php'); ?>
<form id="address-user-form">
  <div class="my-2">
    <input type="text" class="form-control" id="address-fname" placeholder="ชื่อ">
  </div>
  <div class="my-2">
    <input type="text" class="form-control" id="address-lname" placeholder="นามสกุล">
  </div>
  <div class="my-2">
    <input type="text" class="form-control" id="address-phone" placeholder="เบอร์ติดต่อ">
  </div>
  <div class="my-2">
    <label class="form-label">ที่อยู่</label>
    <input type="text" class="form-control" id="address-text" placeholder="ตำบล,อำเภอ,จังหวัด,รหัสไปรษณีย์">
  </div>

  <div id="target-control" class="my-2">
    <button type="button" class="bg-none address-user-target" data-target="province">
      จังหวัด
    </button>
    <button type="button" class="bg-none address-user-target" data-target="district">
      อำเภอ
    </button>
    <button type="button" class="bg-none address-user-target" data-target="subdistrict">
      ตำบล
    </button>
  </div>
  <div id="address-section">
    <div class="address-tab" id="address-province">
      <?php
      $province_row = connect_db()->query("SELECT * FROM province ORDER BY province");
      $province_id = 0;
      while ($province = $province_row->fetch(PDO::FETCH_ASSOC)) { ?>
        <?php $province_id++  ?>
        <label for="province-<?php echo  $province_id  ?>" class="address-label">
          <input type="radio" class="d-none" name="province" id="province-<?php echo  $province_id  ?>" value="<?php echo $province['province'] ?>">
          <span><?php echo  $province['province']  ?></span>
        </label>
      <?php }  ?>
    </div>
    <div class="address-tab" id="address-district"></div>
    <div class="address-tab" id="address-subdistrict"></div>
  </div>
  <div id="address-control" class="my-2">
    <button type="button" id="cancel-address" class="btn btn-light mx-1">
      <i class="fa-solid fa-ban"></i>
      <span>ยกเลิก</span>
    </button>
    <button type="button" id="no-address" class="btn btn-light mx-1">
      <i class="fa-solid fa-circle-xmark"></i>
      <span>ไม่มี</span>
    </button>
  </div>
  <div class="my-2">
    <label class="form-label">รายละเอียดที่อยู่</label>
    <textarea class="form-control" id="address-detail" rows="2"></textarea>
  </div>
</form>