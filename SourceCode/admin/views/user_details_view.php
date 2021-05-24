<?php 
require_once 'partials/header_view.php';
 ?>
<!-- Page Header -->
<div class="page-header row no-gutters py-4">
  <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
    <h3 class="page-title">Thông tin người dùng</h3>
  </div>
</div>

<?= $msg->display() ?>

<!-- End Page Header -->
<div class="row">
  <div class="col-lg-4">
    <div class="card card-small mb-4">
      <div class="card-header border-bottom text-center">
        <div class="mb-3 mx-auto d-fex align-items-center rounded-circle overflow-hidden" style="width: 110px; height: 110px;">
          <img src="<?= !empty($this->item->avatar_img)? STATIC_DIR.'/uploads/images/avatars/'.$this->item('avatar_img'):STATIC_DIR.'/images/default_ava.jpg' ?>" alt="User Avatar" style="width: 100%; height: 100%"> 
        </div>
        <h4 class="mb-0"><?= $this->item('full_name') ?></h4>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div class="text-nowrap">Mã thành viên: </div>
          <div class="font-weight-normal text-right"><?= $this->item('id') ?></div>
        </div>
        <div class="d-flex justify-content-between">
          <div class="text-nowrap">Tên đăng nhập: </div>
          <div class="font-weight-normal text-right"><?= $this->item('username') ?></div>
        </div>
        <div class="d-flex justify-content-between">
          <div class="text-nowrap">Ngày tham gia: </div>
          <div class="font-weight-normal text-right"><?= $this->item('create_time') ?></div>
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
            <input type="text" placeholder="Tên" class="form-control" name="full_name" value="<?= $this->item('full_name') ?>">
          </div>
          <div class="form-group">
            <label>SĐT: </label>
            <input type="text" placeholder="SĐT" class="form-control" name="phone_number" value="<?= $this->item('phone_number') ?>">
          </div>
          <div class="form-group">
            <label>Email: </label>
            <input type="email" placeholder="SĐT" class="form-control" name="email" value="<?= $this->item('email') ?>">
          </div>
          <div class="form-group">
            <label>Quyền: </label>
            <div class="custom-control custom-checkbox">
              <input id="super_user" type="checkbox" class="custom-control-input" name="super_user" value="1" <?= $this->item->has_perm('superuser')? 'checked':'' ?>>
              <label class="custom-control-label" for="super_user">Superuser</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input id="author1" type="checkbox" class="custom-control-input" name="perms[]" value="1" <?= in_array('author', $this->item('permissions'))? 'checked':'' ?>>
              <label class="custom-control-label" for="author1">Tác giả</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input id="editor" type="checkbox" class="custom-control-input" name="perms[]" value="2" <?= in_array('editor', $this->item('permissions'))? 'checked':'' ?>>
              <label class="custom-control-label" for="editor">Biên tập viên</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input id="moderator" type="checkbox" class="custom-control-input" name="perms[]" value="3" <?= in_array('moderator', $this->item('permissions'))? 'checked':'' ?>>
              <label class="custom-control-label" for="moderator">Kiểm duyệt viên</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input id="staff" type="checkbox" class="custom-control-input" name="perms[]" value="4" <?= in_array('staff', $this->item('permissions'))? 'checked':'' ?>>
              <label class="custom-control-label" for="staff">Nhân viên</label>
            </div>
          </div>
          <div class="form-group">
            <label>Ảnh đại diện mới: </label>
            <input type="file" class="form-control" id="avatar_img" name="avatar_img">              
          </div>
          <div class="d-flex justify-content-center">
            <button class="btn btn-primary">Lưu</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

 <?php 
require_once 'partials/footer_view.php';
 ?>