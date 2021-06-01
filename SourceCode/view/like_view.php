<?php 
$title = "Thích - ";

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
          <h2 class="title">Thích</h2>
          <div class="content">
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
            <div class="d-flex justify-content-center">
              <?= $paging ?>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php 
require_once 'partials/footer_view.php';
 ?>