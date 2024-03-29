<div class="modal fade" id="user-password-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">รหัสผ่าน</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="user-change-password-form">
          <div class="my-2">
            <label class="form-label">รหัสผ่านเดิม</label>
            <div class="input-group">
              <input type="password" data-validate="false" class="form-control" id="before-password" placeholder="กรอกรหัสเดิม">
              <button type="button" class="input-group-text obscure-text" data-obscure="true">
                <i class="fa-solid fa-eye"></i>
              </button>
            </div>
          </div>
          <div class="my-2">
            <label class="form-label">รหัสผ่านใหม่</label>
            <div class="input-group">
              <input type="password" data-validate="false" class="form-control" id="after-password" placeholder="กรอกรหัสผ่านใหม่">
              <button type="button" class="input-group-text obscure-text" data-obscure="true">
                <i class="fa-solid fa-eye"></i>
              </button>
            </div>
          </div>

          <div class="my-2">
            <label class="form-label">ยืนยันรหัสผ่าน</label>
            <div class="input-group">
              <input type="password" data-validate="false" class="form-control" id="confirm-password" placeholder="กรอกรหัสผ่านใหม่อีกครั้ง">
              <button type="button" class="input-group-text obscure-text" data-obscure="true">
                <i class="fa-solid fa-eye"></i>
              </button>
            </div>
        </form>


      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">
        ปิด
      </button>
      <button type="button" id="password-update" class="btn btn-light">
      <i class="fa-solid fa-square-check"></i>
        <span>บันทึก</span>
      </button>
    </div>
  </div>
</div>
</div>