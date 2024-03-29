<?php
require_once('./conn.php');
?>
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

<div id="address-area">
  <div class="my-2">
    <button class="btn btn-light rounded-0 address-target" data-active="false" data-target="province" data-display="true">
      จังหวัด
    </button>
    <button class="btn btn-light rounded-0 address-target" disabled data-active="false" data-target="district" data-display="false">
      อำเภอ
    </button>
    <button class="btn btn-light rounded-0 address-target" disabled data-active="false" data-target="sub-district" data-display="false">
      ตำบล
    </button>
  </div>
  <div class="address" id="province">
    <?php
    $province_row = connect_db()->query("SELECT * FROM province ORDER BY province");
    $province_id = 0;
    while ($province = $province_row->fetch(PDO::FETCH_ASSOC)) { ?>
      <?php $province_id++  ?>
      <label for="p-<?php echo  $province_id  ?>" class="check-address text-start d-block btn btn-light  rounded-0">
        <input type="radio" class="d-none" name="province" id="p-<?php echo  $province_id  ?>" value="<?php echo $province['province'] ?>">
        <span><?php echo  $province['province']  ?></span>
      </label>
    <?php }  ?>
  </div>
  <div class="address" id="district"></div>
  <div class="address" id="sub-district"></div>
</div>

<div class="my-2">
  <label class="form-label">รายละเอียดที่อยู่</label>
  <textarea class="form-control" id="address-detail" rows="2"></textarea>
</div>