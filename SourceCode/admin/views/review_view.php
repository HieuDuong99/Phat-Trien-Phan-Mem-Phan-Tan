<?php 
require_once 'partials/header_view.php';
 ?>

    <!-- Page Header -->
    <div class="page-header row no-gutters py-4">
      <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Quản lí tin bài</span>
        <h3 class="page-title">Kiểm duyệt</h3>
      </div>
    </div>

    <?php echo $context['msg']->display() ?>

    <div class="row">
      <div class="input-group mb-3 col-xl-5 col-lg-4 col-md-12">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
        <input type="text" id="keyword" class="form-control" placeholder="search" aria-label="search" value="<?= (isset($_GET['keyword']))? $_GET['keyword']:'' ?>"> 
      </div>
    </div>
    
    <div class="row">
      <div class="col-12">
        <div class="card card-small mb-4">
          <div class="card-header border-bottom">
            <h6 class="m-0">Bài chờ kiểm duyệt</h6>
          </div>
          
          <div class="card-body p-0 pb-2">
            <table class="table table-responsive mb-0 table-hover">
              <thead class="bg-secondary text-white">
                <tr>
                  <th scope="col" class="border-0 align-middle text-center">Hành động</th>
                  <th scope="col" class="border-0 align-middle text-center">Ảnh</th>
                  <th scope="col" class="border-0 align-middle text-center">Tiêu đề</th>
                  <th scope="col" class="border-0 align-middle text-center">Tác giả</th>
                  <th scope="col" class="border-0 align-middle text-center">Người duyệt</th>
                  <th scope="col" class="border-0 align-middle text-center">Thời gian duyệt</th>
                  <th scope="col" class="border-0 align-middle text-center">Biên tập viên</th>
                  <th scope="col" class="border-0 align-middle text-center">Xuất bản</th>
                  <th scope="col" class="border-0 align-middle text-center">Danh mục</th>
                  <th scope="col" class="border-0 align-middle text-center">Tags</th>
                  <th scope="col" class="border-0 align-middle text-center">Chỉnh sửa lần cuối</th>
                  <th scope="col" class="border-0 align-middle text-center">Thời gian tạo</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($context["articles"] as $article): ?>
                  <tr class="item">
                    <td class="align-middle text-center">
                      <div class="btn-group">
                        <?php if ($this->auth->user->has_perm("moderator")): ?>
                        <div><a class="btn btn-info btn-sm" title="Kiểm duyệt" href="?cn=article_preview&article_id=<?= $article->id ?>"><i class="material-icons">grading</i></a></div>
                        <?php endif ?>
                      </div>
                    </td>
                    <td class="align-middle text-center"><img style="max-width: 200px;" src="<?= STATIC_DIR."/uploads/images/".$article->image ?>"></td>
                    <td class="align-middle text-center"><?= $article->title ?></td>
                    <td class="align-middle text-center"><?= $article->author->full_name ?></td>
                    <td class="align-middle text-center"><?= isset($article->reviewer)? $article->reviewer->full_name:"-" ?></td>
                    <td class="align-middle text-center"><?= isset($article->reviewer)? $article->review_time:"-" ?></td>
                    <td class="align-middle text-center"><?= isset($article->editor)? $article->editor->full_name:"-" ?></td>
                    <td class="align-middle text-center"><?= isset($article->editor)? $article->publish_time:"-" ?></td>
                    <td class="align-middle text-center"><?= $article->category->name ?></td>
                    <td class="align-middle text-center"><?= join(", ",$article->getTagNames()) ?></td>
                    <td class="align-middle text-center"><?= $article->update_time ?></td>
                    <td class="align-middle text-center"><?= $article->create_time ?></td>
                    
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  
  <div class="d-flex justify-content-center">
    <?= $context["paging"] ?>
  </div>

  <script>
    var filters = [];
    var sort = "";
    var keyword = "<?= (isset($_GET['keyword']))? $_GET['keyword']:'' ?>";

    $(function() {
       $("#keyword").on('keyup', function(event) {
          if (event.keyCode == 13) {
              keyword = $('#keyword').val();
              filter();
          }
      });
    });
    function filter() {
      var url = "<?= $url.'&' ?>";
      if (keyword != "") {
        url = url + "keyword=" + keyword;
        if (filters.length > 0 || sort != "") {
          url = url + "&";
        }
      }
      $.each(filters, function(index, val) {
        url = url + "filters%5B%5D=" + val;
        if (index < filters.length-1) {
          url = url + "&";
        }
      });
      if (filters.length > 0) {
        url = url + "&";
      }
      
      if (sort != "") {
        url = url + "sort=" + sort;
      }
      if (filters.length > 0 && sort == "") {
        url = url.substr(0, url.length-1);
      }
      
      window.location.href = url;
    }
  </script>
  
<?php 
require_once 'partials/footer_view.php';
 ?>