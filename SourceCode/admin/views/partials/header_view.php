<!doctype html>
<html class="no-js h-100" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>KNN - Administrator Tools</title>
    <meta name="description" content="A high-quality &amp; free Bootstrap admin dashboard template pack that comes with lots of templates and components.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="<?= STATIC_DIR ?>/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?= STATIC_DIR ?>/css/bootstrap.min.css">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="<?= STATIC_DIR ?>/styles/shards-dashboards.1.1.0.min.css">
    <link rel="stylesheet" href="<?= STATIC_DIR ?>/styles/extras.1.1.0.min.css">
    <script async defer src="<?= STATIC_DIR ?>/js/buttons.js"></script>
    <script src="<?= STATIC_DIR ?>/js/jquery-3.4.0.min.js"></script>
  </head>
  <body class="h-100">
    <div class="container-fluid">
      <div class="row">
        <!-- Main Sidebar -->
        <aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
          <div class="main-navbar">
            <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
              <a class="navbar-brand w-100 mr-0" href="#" style="line-height: 25px;">
                <div class="d-table m-auto">
                  <img id="main-logo" class="d-inline-block align-top mr-1" style="max-width: 25px;" src="<?= STATIC_DIR ?>/images/shards-dashboards-logo.svg" alt="Shards Dashboard">
                  <span class="d-none d-md-inline ml-1">KNN - Administrator Tools</span>
                </div>
              </a>
              <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                <i class="material-icons">&#xE5C4;</i>
              </a>
            </nav>
          </div>
          <div class="nav-wrapper">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link <?php echo $GLOBALS["cn"]=="home"? "active":"" ?>" href="?cn=home">
                  <i class="material-icons">edit</i>
                  <span>Trang chủ</span>
                </a>
              </li>

              <?php if ($this->auth->user->has_perm('author')): ?>
              <li class="nav-item">
                <a class="nav-link" href="#author" data-toggle="collapse" data-target="#author" aria-expanded="true" aria-controls="author">
                  <i class="material-icons">article</i>
                  <span>Công cụ tác giả</span>
                </a>
              </li>
              <div class="collapse show" id="author">
                <li class="nav-item">
                  <a class="pl-5 py-2 nav-link <?php echo $GLOBALS["cn"]=="new_article"? "active":"" ?>" href="?cn=new_article">
                    <i class="material-icons">note_add</i>
                    <span>Soạn bài</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="pl-5 py-2 nav-link <?php echo $GLOBALS["cn"]=="my_article"? "active":"" ?>" href="?cn=my_article">
                    <i class="material-icons">article</i>
                    <span>Bài báo của tôi</span>
                  </a>
                </li>
              </div>
              <?php endif ?>

              <li class="nav-item">
                <a class="nav-link" href="#article" data-toggle="collapse" data-target="#article" aria-expanded="true" aria-controls="article">
                  <i class="material-icons">vertical_split</i>
                  <span>Quản lí tin bài</span>
                </a>
              </li>
              <div class="collapse show" id="article">
                <li class="nav-item">
                  <a class="pl-5 py-2 nav-link <?php echo $GLOBALS["cn"]=="article"? "active":"" ?>" href="?cn=article">
                    <i class="material-icons">vertical_split</i>
                    <span>Tất cả bài báo</span>
                  </a>
                </li>
                <?php if ($this->auth->user->has_perm('moderator')): ?>
                <li class="nav-item">
                  <a class="pl-5 py-2 nav-link <?php echo $GLOBALS["cn"]=="review"? "active":"" ?>" href="?cn=review">
                    <i class="material-icons">rate_review</i>
                    <span>Kiểm duyệt</span>
                  </a>
                </li>
                <?php endif ?>
              </div>

              <?php if ($this->auth->user->has_perm('editor')): ?>
              <li class="nav-item">
                <a class="nav-link <?php echo $GLOBALS["cn"]=="editor"? "active":"" ?>" href="?cn=editor">
                  <i class="material-icons">view_module</i>
                  <span>Biên tập và xuất bản</span>
                </a>
              </li>
              <?php endif ?>

              <li class="nav-item">
                <a class="nav-link <?php echo $GLOBALS["cn"]=="category"? "active":"" ?>" href="?cn=category">
                  <i class="material-icons">table_chart</i>
                  <span>Quản lí danh mục</span>
                </a>
              </li>

              <?php if ($this->auth->user->has_perm('superuser')): ?>
              <li class="nav-item">
                <a class="nav-link <?php echo $GLOBALS["cn"]=="user"? "active":"" ?>" href="?cn=user">
                  <i class="material-icons">person</i>
                  <span>Quản lí người dùng</span>
                </a>
              </li>
              <?php endif ?>
            </ul>
          </div>
        </aside>
        <!-- End Main Sidebar -->
        <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
          <div class="main-navbar sticky-top bg-white">
            <!-- Main Navbar -->
            <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0 justify-content-end">
              <ul class="navbar-nav border-left flex-row ">
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle text-nowrap px-3 d-flex align-items-center" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="user-avatar rounded-circle mr-2 overflow-hidden d-flex align-items-center" style="height: 2.5rem;">
                        <img class="user-avatar" src="<?= STATIC_DIR ?>/images/default_ava.jpg" alt="User Avatar">
                    </div>
                    <span><?php echo $this->auth->user->username ?></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-small dropdown-menu-md-right">
                    <a class="dropdown-item" href="?cn=profile">
                      <i class="material-icons">&#xE7FD;</i> Profile</a>
                    <?php if ($this->auth->user->has_perm("author")): ?>  
                    <a class="dropdown-item" href="?cn=new_article">
                      <i class="material-icons">note_add</i> Bài viết mới</a>
                    <?php endif; ?>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="?cn=login&m=logout" onclick="return confirm('Bạn có chắc muốn đăng xuất?')">
                      <i class="material-icons text-danger">&#xE879;</i> Logout </a>
                  </div>
                </li>
              </ul>
              <nav class="nav">
                <a href="#" class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-left" data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
                  <i class="material-icons">&#xE5D2;</i>
                </a>
              </nav>
            </nav>
          </div>
          <!-- / .main-navbar -->
          <div class="main-content-container container-fluid px-4">
