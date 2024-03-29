<div class="modal fade" id="address-user-modal">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ที่อยู่</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <?php require_once('./address_user_modal_form.php') ?>
      </div>
      <div class="modal-footer">
        <button type="button" id="address-submit" class="btn btn-light">
          <i class="fa-solid fa-square-check"></i>
          <span>บันทึก</span>
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  $('#address-submit').click(function() {
    const state = getStateProp($(this), 'data-state')
    const address_id = getStateProp($(this), 'data-id')
    console.log(state)


    const addressForm = [{
        'formtype': 'text',
        'input': $('#address-fname'),
        'msg': 'กรุณาป้อนชื่อ'
      },
      {
        'formtype': 'text',
        'input': $('#address-lname'),
        'msg': 'กรุณาป้อนนามสกุล'
      },
      {
        'formtype': 'text',
        'input': $('#address-phone'),
        'msg': 'กรุณาป้อนเบอร์ติดต่อ'
      },
      {
        'formtype': 'text',
        'input': $('#address-text'),
        'msg': 'กรุณาเลือกที่อยู่'
      },
      {
        'formtype': 'text',
        'input': $('#address-detail'),
        'msg': 'กรุณาป้อนที่อยู่'
      }
    ]

    let emptyCount = 0

    addressForm.forEach((fd) => {
      const {
        input,
        msg
      } = fd
      const v = input.val().trim()
      input.next().remove()
      if (v == '') {
        emptyCount++
        $(input).after(createValidate(msg))
      }
    })

    if (emptyCount == 0) {
      const [subDistrict, district, province, postcode] = $('#address-text').val().split(',')
      console.log(subDistrict, district, postcode, province)
      const data = {
        'address_fname': $('#address-fname').val(),
        'address_lname': $('#address-lname').val(),
        'address_phone': $('#address-phone').val(),
        'address_detail': $('#address-detail').val(),
        'sub_district': subDistrict,
        'district': district,
        'province': province,
        'postcode': postcode
      }

      if (state == 'edit') {
        Object.assign(data, {
          'address_id': address_id
        })
      }
      const route = state == 'add' ?
        './add_address.php' : './address_user_update.php'

      console.log(route)
      $.ajax({
        url: route,
        type: 'post',
        data: data,
        success: function(response) {
          console.log(response)
          if (validateErr(response)) {
          
            createToastMsg($('#address-user-toast'), 'เกิดข้อผิดพลาด')
          } else {
            const obj = get_response_object(response)

            if (!obj.result) {
              createToastMsg($('#address-user-toast'), 'เพิ่มที่อยู่ไม่สำเร็จ')
            }

            if (obj.result) {
              location.reload()
            }
          }
        }
      })
    }

  })
</script>