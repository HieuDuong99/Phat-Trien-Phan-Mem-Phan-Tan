<?php 
require_once 'partials/header_view.php';
 ?>
 	<link rel="stylesheet" href="<?= STATIC_DIR ?>/css/jquery-ui.min.css">
    <!-- Page Header -->
    <div class="page-header row no-gutters py-4">
      <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Trang chính</span>
        <h3 class="page-title">Biên tập và xuất bản</h3>
      </div>
    </div>

    <?php echo $context['msg']->display() ?>
            
    <div class="row">
      <div class="col-lg-6">
        <div class="card mb-4">
	    	<div class="input-group mt-3 mb-3 pb-2 col-12 border-bottom">
	          Bài viết chờ xuất bản
	        </div>
          <div class="input-group mb-3 col-12">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" id="keyword" class="form-control" placeholder="search" aria-label="search"> 
          </div>
          <div class="mb-3 col-12">
            <button type="button" class="btn btn-light mr-1" onclick="addAll()"><i class="fas fa-plus"></i> Thêm tất cả</button>
          </div>
          <div class="col-12 mb-3">
            <div class="list-group-item m-0 p-0" style="max-height: 400px; min-height: 200px; overflow: auto;">
              <ul class="list-group" id="productsList">
              	<?php foreach ($articles as $article): ?>
                  <li class="m-0 p-0 text-truncate border-top-0 border-left-0 border-right-0 border-bottom product" title="<?= $article->title ?>">
                  	<div class="btn-group">
                  		<button type="button" class="btn btn-light add" id="add<?= $article->id ?>"><i class="fas fa-plus"></i></button>
                    	<a class="btn btn-light mr-1" href="?cn=article_preview&article_id=<?= $article->id ?>">Preview</a>
                  	</div>
                    <small><?= $article->title." - ".$article->author->full_name ?></small>
                    <input type="hidden" name='articles[]' value=<?= $article->id ?>>
                  </li>
                <?php endforeach ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 mb-4">
        <div class="card">
          <form action="" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
            <div class="input-group mt-3 mb-3 pb-2 col-12 border-bottom">
              Biên tập
            </div>
            <div class="mb-3 col-12">
              <button type="button" class="btn btn-light mr-1" onclick="removeAll()"><i class="fas fa-times"></i> Xóa tất cả</button>
            </div>
            <div class="col-12 mb-3">
              <div class="list-group-item m-0 p-0" style="max-height: 400px; min-height: 200px; overflow: auto;">
                <ul class="list-group" id="chosenProducts">
                </ul>
              </div>
            </div>
            <div class="col-12 mb-3 text-center">
              <button type="submit" class="btn btn-primary">Xuất bản</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <script src="<?= STATIC_DIR ?>/js/jquery-ui.min.js"></script>
	  <script type="text/javascript">
	    function remove(button, add) {
	      $(button).parents('.product').remove();
	      $('#' + add).prop('disabled', false);
	    }
	    function add(button) {
	      $(button).prop('disabled', true);
	      var product = $(button).parents('.product').clone();
	      var add = product.find('.add').attr('id');
	      product.find('.add').remove();
	      product.children('.btn-group').prepend('<button type="button" class="btn btn-light remove" onclick="remove(this, \'' + add + '\')"><i class="fas fa-times"></i></button>');
	      product.appendTo('#chosenProducts');
	    }
	    function addAll() {
	      $('#productsList').children('.product').each(function() {
	        if ($(this).find('.add').prop('disabled') != true) {
	          add($(this).find('.add'));
	        }
	      });
	    }
	    function removeAll() {
	      $('#chosenProducts').children('.product').each(function() {
	        $(this).find('.remove').trigger('click');
	      });
	    }
	    $(function() {
	      $( "#chosenProducts" ).sortable();
	      $('.add').on('click', function() {
	        add(this);
	      });
	      $('#keyword').on('keyup', function() {
	        var keyword = $(this).val();
	        $('#productsList .product').each(function() {
	          var name = $(this).attr('title');
	          if (name.match(RegExp(keyword, 'gi')) != null) {
	            $(this).removeClass('d-none');
	          } else {
	            $(this).addClass('d-none');
	          }
	        });
	      });
	    })
	  </script>

<?php 
require_once 'partials/footer_view.php';
 ?>