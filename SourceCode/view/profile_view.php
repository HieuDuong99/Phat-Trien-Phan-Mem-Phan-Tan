<?php 
$title = "Thông tin các nhân - ";

require_once 'partials/profile_header_view.php';
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
        <div class="col-12 single_left_coloum_wrapper">
          <h2 class="title">Thông tin các nhân</h2>
          <div class="content">
            <?= $msg->display() ?>
            <div class="row">
              <div class="col-lg-4">
                <div class="card card-small mb-4">
                  <div class="card-header border-bottom text-center">
                    <div class="mb-3 mx-auto d-fex align-items-center rounded-circle overflow-hidden" style="width: 110px; height: 110px;">
                      <img src="<?= !empty($this->auth->user->avatar_img)? STATIC_DIR.'/uploads/images/avatars/'.$this->auth->user->avatar_img:STATIC_DIR.'/images/default_ava.jpg' ?>" alt="User Avatar" style="width: 100%; height: 100%"> 
                    </div>
                    <h4 class="mb-0"><?= $this->auth->user->full_name ?></h4>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">Mã thành viên: </div>
                      <div class="font-weight-normal text-right"><?= $this->auth->user->id ?></div>
                    </div>
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">Tên đăng nhập: </div>
                      <div class="font-weight-normal text-right"><?= $this->auth->user->username ?></div>
                    </div>
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">Ngày tham gia: </div>
                      <div class="font-weight-normal text-right"><?= $this->auth->user->create_time ?></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-8">
                <div class="card card-small mb-4">
                  <div class="card-body">
                    <form method="POST" action="" enctype="multipart/form-data">
                      <div class="form-group">
                        <label>Tên: </label>
                        <input type="text" placeholder="Tên" class="form-control form-control-sm" name="full_name" value="<?= $this->auth->user->full_name ?>">
                      </div>
                      <div class="form-group">
                        <label>SĐT: </label>
                        <input type="text" placeholder="SĐT" class="form-control form-control-sm" name="phone_number" value="<?= $this->auth->user->phone_number ?>">
                      </div>
                      <div class="form-group">
                        <label>Email: </label>
                        <input type="email" placeholder="SĐT" class="form-control form-control-sm" name="email" value="<?= $this->auth->user->email ?>">
                      </div>
                      <div class="form-group">
                        <label>Ảnh đại diện mới: </label>
                        <input type="file" class="form-control form-control-sm" id="avatar_img" name="avatar_img">              
                      </div>
                      <div class="d-flex justify-content-center">
                        <button class="btn btn-sm btn-danger">Lưu</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php 
require_once 'partials/footer_view.php';
 ?>