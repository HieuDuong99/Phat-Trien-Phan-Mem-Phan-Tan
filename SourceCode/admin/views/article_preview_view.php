<?php 
require_once 'partials/header_view.php';
 ?>
    <style>
      .article_content img {
        width: 100%;
      }
    </style>

    <!-- Page Header -->
    <div class="page-header row no-gutters py-4">
      <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Quản lí tin bài</span>
        <h3 class="page-title">Xem trước</h3>
      </div>
    </div>

    <?php echo $context['msg']->display() ?>
    
    <div class="row">
      <div class="col-8">
        <div class="card card-small mb-4">
          <div class="card-header border-bottom">
            <h4 class="m-0"><?= $context["article"]->title ?></h4>
            <span><?= date_format(date_create($context["article"]->create_time), 'd/m/Y, H:i') ?></span>
          </div>
          
          <div class="article_content card-body">
            <?= $context["article"]->content ?>
          </div>
          <div class="card-footer text-muted border-top">
            <div class="d-flex justify-content-between">
              <div>
                Tags: 
                <?php foreach ($article->tags as $tag): ?>
                  <a class="badge badge-pill badge-secondary" href="#<?= $tag->id ?>"><?= $tag->name ?></a>
                <?php endforeach; ?>
              </div>
              <span class="font-weight-bold"><?= $context["article"]->author->full_name ?></span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-4">
      	<div class="card card-small card-post card-post--1 mb-3">
          <div id="preview_image" class="card-post__image" style="background-size: contain; background-image: url(<?= STATIC_DIR."/uploads/images/".$context["article"]->image ?>)">
            <a id="preview_category" href="#" class="card-post__category badge badge-pill badge-primary"><?= $context["article"]->category->name ?></a>
          </div>
          <div class="card-body">
            <h5 class="card-title">
              <span id="preview_title" class="text-fiord-blue" href="#"><?= $context["article"]->title ?></span>
            </h5>
            <p id="preview_description" class="card-text d-inline-block"><?= $context["article"]->description ?></p>
          </div>
          <div class="card-footer text-muted border-top py-3">
            <span class="d-inline-block">Tác giả
              <strong class="text-fiord-blue"><?= $context["article"]->author->full_name ?></strong> 
            </span>
          </div>
        </div>
      </div>
      <?php if(!$article->drafft && !isset($article->review_time)): ?>
        <?php if($this->auth->user->has_perm("moderator")): ?>
          <div class="col-12">
            <div class='card card-small mb-3'>
              <div class="card-header border-bottom">
                <h6 class="m-0">Hành động</h6>
              </div>
              <div class='card-body p-0'>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item px-3">
                    <form action="?cn=review&id=<?= $article->id ?>" method="POST">
                      <button name="pass" id="btn_draft" class="btn btn-sm btn-accent">
                      <i class="material-icons">save</i> Nộp biên tập</button>
                      <button name="no_pass" class="btn btn-sm btn-danger ml-auto">
                        <i class="material-icons">cancel</i> Không đạt</button>
                    </form>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        <?php endif ?>
      <?php else: ?>
        <?php if($article->drafft && $this->auth->user->id == $article->author->id): ?>
          <div class="col-12">
            <div class='card card-small mb-3'>
              <div class="card-header border-bottom">
                <h6 class="m-0">Hành động</h6>
              </div>
              <div class='card-body p-0'>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item px-3">
                    <a href="?cn=update_article&id=<?= $article->id ?>" class="btn btn-sm btn-warning">
                      <i class="fas fa-pencil-alt"></i> Chỉnh sửa</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        <?php endif ?>
      <?php endif ?>
    </div>

    
<?php 
require_once 'partials/footer_view.php';
 ?>