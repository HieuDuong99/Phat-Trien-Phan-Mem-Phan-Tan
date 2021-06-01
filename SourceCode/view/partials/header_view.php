<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= isset($title)? $title:"" ?>KNN News</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" type="text/css" href="<?= STATIC_DIR ?>/css/all.min.css" />
<!-- <link rel="stylesheet" type="text/css" href="<?= STATIC_DIR ?>/font/font.css" /> -->
<link rel="stylesheet" type="text/css" href="<?= STATIC_DIR ?>/css/bootstrap.min.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?= STATIC_DIR ?>/css/style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?= STATIC_DIR ?>/css/responsive.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?= STATIC_DIR ?>/css/jquery.bxslider.css" media="screen" />
<script type="text/javascript" src="<?= STATIC_DIR ?>/js/jquery-min.js"></script> 
</head>
<body>
<div class="body_wrapper">
  <div class="center">
    <div class="header_area">
      
      <div class="top_menu floatleft ml-2 mt-2">
        <ul>
          <?php if ($this->auth->check_login()): ?>
            <li class="pr-2">Hi <?= $this->auth->user->username ?>!</li>
          <?php endif ?>
          <li><a href="/knn">Trang chủ</a></li>
          <?php if (!$this->auth->check_login()): ?>
            <li><a href="#" data-toggle="modal" data-target="#login">Đăng nhập</a></li>
            <li><a href="?cn=register">Đăng kí</a></li>
          <?php else: ?>
            <li><a href="?cn=profile">Profile</a></li>
            <li><a href="admin/?cn=login&m=logout" onclick="return confirm('Bạn có chắc muốn đăng xuất?')">Đăng xuất</a></li>
          <?php endif ?>
        </ul>
      </div>

      <?php if (!$this->auth->check_login()): ?>
      <!-- Modal -->
      <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Đăng nhập</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <input type="text" name="username" class="form-control form-control-sm mb-2" placeholder="Username" id="username">
                <input type="password" name="password" class="form-control form-control-sm mb-2" placeholder="Password" id="password">
                <div class="d-flex">
                  <input class="mr-1" type="checkbox" name="ckRemember" id="remember">
                  <label for="remember"> Ghi nhớ đăng nhập</label>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
              <button type="button" class="btn btn-sm btn-danger" id="btnSubmit">Đăng nhập</button>
            </div>
          </div>
        </div>
      </div>
      <script>
        $(function() {
            $('#btnSubmit').on('click', function() {
                let username = $('#username').val();
                let password = $('#password').val();
                let remember = $('#remember').prop("checked");

                if (username == "" || password == "") {
                    $('#username').addClass('is-invalid');
                    $('#password').addClass('is-invalid');
                    $(".login-box").append('<div class="alert alert-danger alert-dismissible fade show" role="alert">Tài khoản và mật khẩu không được để rỗng<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    return false;
                }

                $.ajax({
                    url: 'admin/?cn=login',
                    type: 'POST',
                    data: {username: username, password: password, remember: remember},
                    success: function(result) {
                        if (JSON.parse(result).status == 1) {
                            window.location.href = "";
                        } else {
                            $('#username').addClass('is-invalid');
                            $('#password').addClass('is-invalid');
                            if ($('.alert').length > 0) {
                                $('.alert').remove();
                                $(".login-box").append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+JSON.parse(result).message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $(".login-box").append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+JSON.parse(result).message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            }
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }      
                });
            });
        });
      </script>
      <?php endif ?>

      <div class="social_plus_search floatright">
        <div class="search">
          <form action="?cn=search" method="GET" id="search_form" class="d-flex">
            <input type="hidden" value="search" name="cn" />
            <input type="text" placeholder="Tìm kiếm" id="s" name="keyword" />
            <button type="submit" class="btn" value="search"><i class="fas fa-search"></i></button>
          </form>
        </div>
      </div>
    </div>
    <div class="main_menu_area">
      <ul id="nav">
        <?php foreach ($categories as $category): ?>
          <?php if (!isset($category->parent->id)): ?>
            <li><a href="?cn=category&id=<?= $category->id ?>"><?= $category->name ?></a>
              <ul>
                <?php foreach ($categories as $subcategory): ?>
                  <?php if (isset($subcategory->parent->id)): ?>
                    <?php if ($subcategory->parent->id == $category->id): ?>
                      <li><a href="?cn=category&id=<?= $subcategory->id ?>"><?= $subcategory->name ?></a></li>
                    <?php endif ?>
                  <?php endif ?>
                <?php endforeach ?>
                <li></li>
              </ul>
            </li>
          <?php endif ?>
        <?php endforeach ?>
      </ul>
    </div>