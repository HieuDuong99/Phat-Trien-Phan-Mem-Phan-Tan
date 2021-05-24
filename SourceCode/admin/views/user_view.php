<?php 
require_once 'partials/header_view.php';
 ?>

    <!-- Page Header -->
    <div class="page-header row no-gutters py-4">
      <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Trang chính</span>
        <h3 class="page-title">Quản lí người dùng</h3>
      </div>
    </div>

    <?= $msg->display() ?>

    <div class="row">
      <div class="col-xl-7 col-lg-8 col-md-12">
        <div class="btn-group mb-4">
          <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#register">
            Thêm mới
          </button>
        </div>
      </div>
      <div class="input-group mb-3 col-xl-5 col-lg-4 col-md-12">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
        <input type="text" id="keyword" class="form-control" placeholder="search" aria-label="search" value="<?= (isset($_GET['keyword']))? $_GET['keyword']:'' ?>"> 
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card card-small mb-4">
          <div class="card-header border-bottom">
            <h6 class="m-0">Tất cả</h6>
          </div>
          
          <div class="card-body p-0 pb-2">
            <table class="table table-responsive-lg mb-0 table-hover">
              <thead class="bg-secondary text-white">
                <tr>
                  <th scope="col" class="border-0 align-middle text-center">Hành động</th>
                  <th scope="col" class="border-0 align-middle text-center">Avatar</th>
                  <th scope="col" class="border-0 align-middle text-center">Username</th>
                  <th scope="col" class="border-0 align-middle text-center">Email</th>
                  <th scope="col" class="border-0 align-middle text-center">Tên</th>
                  <th scope="col" class="border-0 align-middle text-center">SĐT</th>
                  <th scope="col" class="border-0 align-middle text-center">Superuser</th>
                  <th scope="col" class="border-0 align-middle text-center">Quyền</th>
                  <th scope="col" class="border-0 align-middle text-center">Chỉnh sửa lần cuối</th>
                  <th scope="col" class="border-0 align-middle text-center">Thời gian tạo</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($users as $user): ?>
                  <tr class="item">
                    <td class="align-middle text-center">
                      <div class="btn-group">
                        <div><a class="btn btn-warning btn-sm" href="?cn=user_details&id=<?= $user->id ?>"><i class="fas fa-pencil-alt"></i></a></div>
                      </div>
                    </td>
                    <td class="align-middle text-center"><img style="max-width: 50px;" src="<?= !empty($user->avatar_img)? STATIC_DIR.'/uploads/images/avatars/'.$user->avatar_img:STATIC_DIR.'/images/default_ava.jpg' ?>"></td>
                    <td class="align-middle text-center"><?= $user->username ?></td>
                    <td class="align-middle text-center"><?= $user->email ?></td>
                    <td class="align-middle text-center"><?= $user->full_name ?></td>
                    <td class="align-middle text-center"><?= $user->phone_number ?></td>
                    <td class="align-middle text-center"><?= $user->super_user? 'true':'false' ?></td>
                    <td class="align-middle text-center"><?= join(", ",$user->permissions) ?></td>
                    <td class="align-middle text-center"><?= $user->update_time ?></td>
                    <td class="align-middle text-center"><?= $user->create_time ?></td>
                    
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  
  <div class="d-flex justify-content-center">
    <?= $context["paging"] ?>
  </div>

<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Thành viên mới</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body py-3">
        <form id="register_form" action="" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label>Username: </label>
            <input id="res_username" type="text" placeholder="Username" class="form-control" name="username" required>
          </div>
          <div class="form-group">
            <label>Mật khẩu: </label>
            <input id="res_password" type="password" placeholder="Mật khẩu" class="form-control" name="password" required>
          </div>
          <div class="form-group">
            <label>Nhập lại mật khẩu: </label>
            <input id="res_cf_password" type="password" placeholder="Nhập lại mật khẩu" class="form-control" name="cf_password" required>
          </div>
          <div class="form-group">
            <label>Tên: </label>
            <input id="full_name" type="text" placeholder="Tên" class="form-control" name="full_name" required>
          </div>
          <div class="form-group">
            <label>Email: </label>
            <input id="email" type="email" placeholder="Email" class="form-control" name="email" required>
          </div>
          <div class="form-group">
            <label>SĐT: </label>
            <input id="phone_number" type="text" placeholder="SĐT" class="form-control" name="phone_number">
          </div>
          <div class="form-group">
            <label>Quyền: </label>
            <div class="custom-control custom-checkbox">
              <input id="super_user" type="checkbox" class="custom-control-input" name="super_user" value="1">
              <label class="custom-control-label" for="super_user">Superuser</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input id="author1" type="checkbox" class="custom-control-input" name="perms[]" value="1">
              <label class="custom-control-label" for="author1">Tác giả</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input id="editor" type="checkbox" class="custom-control-input" name="perms[]" value="2">
              <label class="custom-control-label" for="editor">Biên tập viên</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input id="moderator" type="checkbox" class="custom-control-input" name="perms[]" value="3">
              <label class="custom-control-label" for="moderator">Kiểm duyệt viên</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input id="staff" type="checkbox" class="custom-control-input" name="perms[]" value="4">
              <label class="custom-control-label" for="staff">Nhân viên</label>
            </div>
          </div>
          <div class="form-group">
            <label>Ảnh đại diện: </label>
            <input type="file" class="form-control" id="avatar_img" name="avatar_img">              
          </div>
          <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary" id="btnSubmit">Tạo</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

  <script>
    var filters = [];
    var sort = "";
    var keyword = "<?= (isset($_GET['keyword']))? $_GET['keyword']:'' ?>";

    $(function() {
       $("#keyword").on('keyup', function(event) {
          if (event.keyCode == 13) {
              keyword = $('#keyword').val();
              filter();
          }
      });
    });
    function filter() {
      var url = "<?= $url.'&' ?>";
      if (keyword != "") {
        url = url + "keyword=" + keyword;
        if (filters.length > 0 || sort != "") {
          url = url + "&";
        }
      }
      $.each(filters, function(index, val) {
        url = url + "filters%5B%5D=" + val;
        if (index < filters.length-1) {
          url = url + "&";
        }
      });
      if (filters.length > 0) {
        url = url + "&";
      }
      
      if (sort != "") {
        url = url + "sort=" + sort;
      }
      if (filters.length > 0 && sort == "") {
        url = url.substr(0, url.length-1);
      }
      
      window.location.href = url;
    }
  </script>

<?php 
require_once 'partials/footer_view.php';
 ?>