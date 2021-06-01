<?php 
$title = $article->title." - ";

require_once 'partials/header_view.php';
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
      <div class="main_content floatleft">
        <div class="left_coloum floatleft">
          <div class="single_left_coloum_wrapper">
            <div class="d-flex margin-left-10 py-1 justify-content-between bigger-text">
              <span class="font-weight-bold"><?= $article->category->name ?></span>
              <span><?= date_format(date_create($context["article"]->create_time), 'd/m/Y, H:i') ?></span>
            </div>
            <h2 class="article title font-weight-bold mb-2"><?= $article->title ?></h2>
            <div class="content text-justify">
              <?= $article->content ?>
              <div class="d-flex justify-content-between">
                <div>
                  Tags: 
                  <?php foreach ($article->tags as $tag): ?>
                    <a class="badge badge-pill badge-secondary" href="?cn=tag&id=<?= $tag->id ?>"><?= $tag->name ?></a>
                  <?php endforeach; ?>
                </div>
                <span class="font-weight-bold"><?= $article->author->full_name ?></span>
              </div>
              <div class="d-flex justify-content-between py-1 mt-1">
                <button class="btn btn-sm btn-light text-danger <?= $liked? 'active':'' ?>" id="like" active="true" type="button" title="<?= $this->auth->check_login()? $liked? 'Bỏ thích bài viết này':'Thích bài viết này':'Hãy đăng nhập để thích bài viết' ?>" <?= $this->auth->check_login()? '':'disabled' ?>><i class="<?= $liked? 'fas':'far' ?> fa-heart"></i></button>
              </div>
            </div>
          </div>
          <div class="single_left_coloum_wrapper">
            <h2 class="title">Bình luận</h2>
            <div class="content">
              <?php if($this->auth->check_login()): ?>
              <div class="mb-3 d-flex justify-content-stretch">
                <input id="comment" type="text" style="width: 100%;" placeholder="Aa">
                <div class="input-group-append">
                  <button class="btn btn-sm" type="button" id="btn-comment"><i class="fas fa-paper-plane"></i></button>
                </div>
              </div>
              <?php else: ?>
                <div class="mb-3 font-italic">
                  Trở thành thành viên để bình luận.
                </div>
              <?php endif ?>
              <div id="cmt-container">
                <?php foreach ($cmts as $cmt): ?>
                <div class="mb-2">
                  <div class="font-weight-bold mb-1"><?= $cmt->user->username ?></div>
                  <div class="mb-1"><?= $cmt->content ?></div>
                  <div class="text-secondary"><?= date_format(date_create($cmt->create_time), 'd/m/Y, H:i') ?></div>
                </div>
                <?php endforeach ?>
                <?php if($cmt_page > 1): ?>
                  <div class="d-flex justify-content-center">
                    <button class="btn btn-sm py-0" style="font-size: 12px" id="more-cmt" page="2">Xem thêm bình luận</button>
                  </div>
                <?php endif ?>
              </div>   
            </div>
          </div>
        </div>
        <div class="right_coloum floatright">
          <div class="single_right_coloum">
            <h2 class="title">Tin nổi bật</h2>
            <ul>
              <?php for($i=0; $i<3; $i++): ?>
                <?php if($i<count($pop_articles)): ?>
                  <?php $pop_article = $pop_articles[$i] ?>
                  <li>
                    <div class="single_cat_right_content">
                      <h3><?= $pop_article->title ?></h3>
                      <p><?= $pop_article->description ?></p>
                      <p class="single_cat_right_content_meta"><a href="?cn=article&article_id=<?= $pop_article->id ?>"><span>Xem chi tiết</span></a> <?= $pop_article->view ?> lượt xem</p>
                    </div>
                  </li>
                <?php endif ?>
              <?php endfor ?>
            </ul>
          </div>
          <div class="single_right_coloum">
            <h2 class="title">Tag nổi bật</h2>
            <?php foreach($hot_tags as $tag): ?>
              <a href="?cn=tag&id=<?= $tag->id ?>" style="font-size: 12px" class="badge badge-pill badge-light mb-1"><?= $tag->name ?></a>
            <?php endforeach ?>
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

    <script>
      var article_id = <?= $article->id ?>;
    </script>

    <?php if($this->auth->check_login()): ?>
    <script>
      var username = '<?= $this->auth->user->username ?>';
      var user_id = <?= $this->auth->user->id ?>;

      function comment(content) {
        if (content != "") {
          $.ajax({
            url: '?cn=comment',
            type: 'POST',
            data: {
              article_id: article_id,
              user_id: user_id,
              content: content
            },
            success: function(result) {
              result = JSON.parse(result);
              
              if (result.status == 1) {
                $("#comment").val('');
                $("#cmt-container").prepend('<div class="mb-2"><div class="font-weight-bold mb-1">' + username + '</div><div class="mb-1">' + content + '</div><div class="text-secondary">' + result.comment.create_time + '</div></div>');
              } else {
                alert("Chưa thể thực hiện bình luận.");
              }
            },
            error: function(error) {
                console.log(error);
            }  
          });
        }
      };

      $(function() {
        $("#comment").on('keyup', function(event) {
          if (event.keyCode == 13) {
              comment($(this).val());
          }
        });

        $("#btn-comment").on('click', function(event) {
          comment($("#comment").val());
        });

        $("#like").on('click', function(event) {
          let like_btn = $(this);
          $.ajax({
            url: '?cn=like',
            type: 'POST',
            data: {
              article_id: article_id,
              user_id: user_id
            },
            success: function(result) {
              result = JSON.parse(result);
              
              if (result.status == 1) {
                like_btn.toggleClass('active').children('i').toggleClass('far').toggleClass('fas');
                if (like_btn.hasClass('active')) {
                  like_btn.attr('title','Bỏ thích bài viết này');
                } else {
                  like_btn.attr('title','Thích bài viết này');
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

    <script>
      $(function() {
        $(document).on('click', '#more-cmt', function() {
          let page = $(this).attr('page');
          let spinner = $('<div class="d-flex justify-content-center"><div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div></div>');
          $(this).remove();
          $('#cmt-container').append(spinner);
          $.ajax({
            url: '?cn=ajax_article_comment',
            type: 'POST',
            data: {
              article_id: article_id,
              page: page,
            },
            success: function(result) {
              spinner.remove();
              $('#cmt-container').append(result);
            },
            error: function(error) {
                console.log(error);
            }  
          });
        });
      });
    </script>

<?php 
require_once 'partials/footer_view.php';
 ?>