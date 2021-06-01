<?php 
$title = "Tìm kiếm - ";

require_once 'partials/header_view.php';
 ?>

    <div class="content_area">
      <div class="main_content floatleft d-flex justify-content-center">
        <div class="col-12">
          <div class="single_left_coloum_wrapper">
            <h2 class="title">Kết quả tìm kiếm: "<?= $keyword ?>"</h2>
            <?php foreach ($articles as $article): ?>
              <div class="d-flex mb-4">
                <div class="col-md-4">
                  <img src="<?= STATIC_DIR ?>/uploads/images/<?= $article->image ?>" alt="<?= $article->title ?>" />
                </div> 
                <div class="col-md-8">
                  <h3 class="mb-1"><?= $article->title ?></h3>
                  <p class="mb-2"><?= $article->description ?></p>
                  <a class="readmore" href="?cn=article&article_id=<?= $article->id ?>">Xem chi tiết</a>
                </div>
              </div>
            <?php endforeach ?>
          </div>
          <div class="d-flex justify-content-center">
            <?= $paging ?>
          </div>
        </div>
      </div>
      <div class="sidebar floatright">
        <div class="single_sidebar">
          <?php if(!$this->auth->check_login()): ?>
          <div class="news-letter">
            <h2>Đăng kí thành viên</h2>
            <p>Đăng kí thành viên để bình luận, và hơn thế nữa!</p>
            <form>
              <a href="?cn=register"><input type="button" value="Đăng kí" id="form-submit" data-toggle="modal" data-target="#register"/></a>
            </form>
            <p class="news-letter-privacy"></p>
          </div>
          <?php endif ?>
        </div>
        <div class="single_sidebar"> <img src="<?= STATIC_DIR ?>/images/add1.png" alt="" /> </div>
        <div class="single_sidebar">
          <h2 class="title">Quảng cáo</h2>
          <img src="<?= STATIC_DIR ?>/images/add2.png" alt="" /> </div>
      </div>
    </div>

<?php 
require_once 'partials/footer_view.php';
 ?>