<?php 
require_once 'partials/header_view.php';
 ?>
<!-- Page Header -->
<div class="page-header row no-gutters py-4">
  <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
    <h3 class="page-title">Danh mục</h3>
  </div>
</div>

<?php echo $context['msg']->display() ?>

<!-- End Page Header -->
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-body">
        <form action="" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
          <div class="row">
            <div class="form-group col-md-6">
              <label for="name">Tên danh mục:</label>
              <input type="text" class="form-control" id="name" name="name" value="<?= $this->item('name') ?>">
              <div class="invalid-feedback"></div>
            </div>
            <div class="form-group col-md-6">
              <label for="status">Danh mục chính:</label>
              <select id="inputState" class="form-control" name="parent_id">
                <option value=0 selected>Không</option>
              	<?php foreach ($context['categories'] as $category): ?>
              		<?php if (!isset($category->parent->id)): ?>
              			<option value="<?= $category->id ?>" <?= $this->item('parent')? $this->item('parent')->id==$category->id? 'selected':'':'' ?>><?= $category->name ?></option>
              		<?php endif ?>
              	<?php endforeach ?>
              </select>
            </div>
            <div class="form-group col-12">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="form-control custom-control-input" id="active" name="active" value=1 <?= $this->item('active')? 'checked':''?>>
                <label class="custom-control-label" for="active">Active</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-12">
              <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
 <?php 
require_once 'partials/footer_view.php';
 ?>