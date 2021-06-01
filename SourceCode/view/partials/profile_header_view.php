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
      
      <div class="top_menu floatleft ml-2 mt-2 mb-4">
        <ul>
          <?php if ($this->auth->check_login()): ?>
            <li class="pr-2">Hi <?= $this->auth->user->username ?>!</li>
          <?php endif ?>
          <li><a href="/knn">Trang chủ</a></li>
          <?php if ($this->auth->check_login()): ?>
            <li><a href="#" class="font-weight-bold">Profile</a></li>
            <li><a href="admin/?cn=login&m=logout" onclick="return confirm('Bạn có chắc muốn đăng xuất?')">Đăng xuất</a></li>
          <?php endif ?>
        </ul>
      </div>
    </div>

    <div class="main_menu_area">
      <ul id="nav">
        <li><a href="?cn=profile">Thông tin cá nhân</a></li>
        <li><a href="?cn=history">Lịch sử</a></li>
        <li><a href="?cn=liked">Thích</a></li>
      </ul>
    </div>