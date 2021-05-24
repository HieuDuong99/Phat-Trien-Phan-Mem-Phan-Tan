<?php 
require_once 'partials/header_view.php';
 ?>

    <!-- Page Header -->
    <div class="page-header row no-gutters py-4">
      <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Trang chính</span>
        <h3 class="page-title">Quản lí danh mục</h3>
      </div>
    </div>

    <?php echo $context['msg']->display() ?>
    
    <!-- End Page Header -->
    <div class="row">
      <div class="col-xl-7 col-lg-8 col-md-12">
        <?php if ($this->auth->user->has_perm("superuser")): ?>
        <div class="btn-group mb-4">
          <a class="btn btn-primary" href="?cn=category_create">
            Thêm mới
          </a>
        </div>
        <?php endif ?>
      </div>
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
            <h6 class="m-0">Tất cả</h6>
          </div>
          
          <div class="card-body p-0 pb-2">
            <table class="table table-responsive-sm mb-0 table-hover">
              <thead class="bg-secondary text-white">
                <tr>
                  <th scope="col" class="border-0 align-middle text-center">Tên danh mục</th>
                  <th scope="col" class="border-0 align-middle text-center">Danh mục cha</th>
                  <th scope="col" class="border-0 align-middle text-center">Active</th>

                  <?php if ($this->auth->user->has_perm("superuser")): ?>
                  <th scope="col" class="border-0 align-middle text-center">Action</th>
                  <?php endif ?>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($context["categories"] as $category): ?>
                  <tr class="item">
                    <td class="align-middle text-center"><?= $category->name ?></td>
                    <td class="align-middle text-center"><?= isset($category->parent->name)? $category->parent->name:'-' ?></td>
                    <td class="align-middle text-center"><span class="text-"><?= ($category->active)? 'active':'inactive'?></span></td>
                    
                    <?php if ($this->auth->user->has_perm("superuser")): ?>
                    <td class="align-middle text-center">
                      <div class="btn-group">
                        <a class="btn btn-warning btn-sm" href="?cn=category_edit&id=<?= $category->id ?>"><i class="fas fa-pencil-alt"></i></a>
                        
                        <button class="btn btn-danger btn-sm" type="button" onclick=""><i class="fas fa-trash-alt"></i></button>
                          <!-- <button class="btn btn-secondary btn-sm" type="button" title="Không thể xóa do có danh mục con" disabled><i class="fas fa-trash-alt"></i></button> -->
                        
                      </div>
                    </td>
                    <?php endif ?>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
              <!-- <div class="card-header">
                  <h6>Không có dữ liệu</h6>
              </div> -->
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