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
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="<?= STATIC_DIR ?>/js/jquery-3.4.0.min.js"></script>
  </head>
  <body class="h-100">
    <div class="container-fluid">
      <div class="row">
        
        <!-- End Main Sidebar -->
        <main class="main-content col-12 p-0">
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
                    <a class="dropdown-item text-danger" href="?cn=login&m=logout">
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
		   	<div class="error">
			    <div class="error__content">
			      <h3><?= $context["error_title"] ?></h3>
			      <p><?= $context["error_info"] ?></p>
			    </div>
			</div>
          </div>
        </main>
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="<?= STATIC_DIR ?>/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sharrre/2.0.1/jquery.sharrre.min.js"></script>
    <script src="<?= STATIC_DIR ?>/scripts/extras.1.1.0.min.js"></script>
    <script src="<?= STATIC_DIR ?>/scripts/shards-dashboards.1.1.0.min.js"></script>
  </body>
</html>