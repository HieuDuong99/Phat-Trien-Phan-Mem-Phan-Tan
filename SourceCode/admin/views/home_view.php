<?php 
require_once 'partials/header_view.php';
 ?>

<!-- Page Header -->
<div class="page-header row no-gutters py-4">
  <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
    <span class="text-uppercase page-subtitle">Trang chủ</span>
    <h3 class="page-title">Tổng Quan</h3>
  </div>
</div>
<!-- End Page Header -->
<!-- Small Stats Blocks -->
<div class="row">
  <div class="col-lg col-md-6 col-sm-6 mb-4">
    <div class="stats-small stats-small--1 card card-small">
      <div class="card-body p-0 d-flex">
        <div class="d-flex flex-column m-auto">
          <div class="stats-small__data text-center">
            <span class="stats-small__label text-uppercase">Bài báo xuất bản</span>
            <h6 class="stats-small__value count my-3"><?= $publish_count ?></h6>
          </div>
        </div>
        <canvas height="120" class="blog-overview-stats-small-1"></canvas>
      </div>
    </div>
  </div>
  <div class="col-lg col-md-4 col-sm-6 mb-4">
    <div class="stats-small stats-small--1 card card-small">
      <div class="card-body p-0 d-flex">
        <div class="d-flex flex-column m-auto">
          <div class="stats-small__data text-center">
            <span class="stats-small__label text-uppercase">Bình luận mới (7 ngày gần nhất)</span>
            <h6 class="stats-small__value count my-3"><?= $cmt_count ?></h6>
          </div>
        </div>
        <canvas height="120" class="blog-overview-stats-small-3"></canvas>
      </div>
    </div>
  </div>
  <div class="col-lg col-md-4 col-sm-6 mb-4">
    <div class="stats-small stats-small--1 card card-small">
      <div class="card-body p-0 d-flex">
        <div class="d-flex flex-column m-auto">
          <div class="stats-small__data text-center">
            <span class="stats-small__label text-uppercase">Người dùng mới (7 ngày gần nhất)</span>
            <h6 class="stats-small__value count my-3"><?= $user_count ?></h6>
          </div>
        </div>
        <canvas height="120" class="blog-overview-stats-small-4"></canvas>
      </div>
    </div>
  </div>
</div>

<?php 
require_once 'partials/footer_view.php';
 ?>