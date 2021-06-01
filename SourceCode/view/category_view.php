<?php 
$title = $cat->name." - ";

require_once 'partials/header_view.php';
 ?>

<!--     <div class="slider_area mt-4">
      <div class="slider">
        <ul class="bxslider">
          <li><img src="<?= STATIC_DIR ?>/images/1.jpg" alt="" title="Slider caption text" /></li>
          <li><img src="<?= STATIC_DIR ?>/images/2.jpg" alt="" title="Slider caption text" /></li>
          <li><img src="<?= STATIC_DIR ?>/images/3.jpg" alt="" title="Slider caption text" /></li>
        </ul>
      </div>
    </div> -->
    <div class="content_area">
      <div class="main_content floatleft">
        <div class="left_coloum floatleft">
          <div class="single_left_coloum_wrapper">
            <h2 class="title"><?= $cat->name ?></h2>
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
        <div class="right_coloum floatright">
          <div class="single_right_coloum">
            <h2 class="title">Tin <?= mb_strtolower($cat->name) ?> nóng</h2>
            <ul>
              <?php for($i=0; $i<3; $i++): ?>
                <?php if($i<count($hot_articles)): ?>
                  <?php $article = $hot_articles[$i] ?>
                  <li>
                    <div class="single_cat_right_content">
                      <img src="<?= STATIC_DIR ?>/uploads/images/<?= $article->image ?>" alt="<?= $article->title ?>" />
                      <h3><?= $article->title ?></h3>
                      <p><?= $article->description ?></p>
                      <p class="single_cat_right_content_meta">
                        <a href="?cn=article&article_id=<?= $article->id ?>"><span>Xem chi tiết</span></a>
                      </p>
                    </div>
                  </li>
                <?php endif ?>
              <?php endfor ?>
            </ul>
          </div>
          <div class="single_right_coloum">
            <h2 class="title">Tin <?= mb_strtolower($cat->name) ?> nổi bật</h2>
            <ul>
              <?php for($i=0; $i<3; $i++): ?>
                <?php if($i<count($pop_articles)): ?>
                  <?php $article = $pop_articles[$i] ?>
                  <li>
                    <div class="single_cat_right_content">
                      <h3><?= $article->title ?></h3>
                      <p><?= $article->description ?></p>
                      <p class="single_cat_right_content_meta">
                        <a href="?cn=article&article_id=<?= $article->id ?>"><span>Xem chi tiết</span></a> <?= $article->view ?> lượt xem
                      </p>
                    </div>
                  </li>
                <?php endif ?>
              <?php endfor ?>
            </ul>
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