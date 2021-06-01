<?php 
require_once 'partials/header_view.php';
 ?>
 <style>
   .single_left_coloum_wrapper .content {
      margin-left: 10px;
   }
   .single_left_coloum_wrapper .article.title {
      border: none;
   }
   .margin-left-10 {
      margin-left: 10px;
   }
   .bigger-text {
      font-size: 14px;
   }
   @media only screen and (max-width: 767px) {
    .single_left_coloum_wrapper .content {
      margin-left: 3px;
    }
    .margin-left-10 {
      margin-left: 3px;
    }
   }
 </style>

    <div class="content_area">
      <div class="d-flex justify-content-center">
        <div class="col-md-12 col-lg-6 single_left_coloum_wrapper">
          <h2 class="title">Đăng kí</h2>
          <div class="content">
            <?= $msg->display() ?>
            <form id="register_form" action="" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <input id="res_username" type="text" placeholder="Username" class="form-control form-control-sm" name="username" required>
              </div>
              <div class="form-group">
                <input id="res_password" type="password" placeholder="Mật khẩu" class="form-control form-control-sm" name="password" required>
              </div>
              <div class="form-group">
                <input id="res_cf_password" type="password" placeholder="Nhập lại mật khẩu" class="form-control form-control-sm" name="cf_password" required>
              </div>
              <div class="form-group">
                <input id="full_name" type="text" placeholder="Tên" class="form-control form-control-sm" name="full_name" required>
              </div>
              <div class="form-group">
                <input id="email" type="email" placeholder="Email" class="form-control form-control-sm" name="email" required>
              </div>
              <div class="form-group">
                <input id="phone_number" type="text" placeholder="SĐT" class="form-control form-control-sm" name="phone_number">
              </div>
              <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-sm btn-danger" id="btnSubmit">Đăng kí</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

<?php 
require_once 'partials/footer_view.php';
 ?>