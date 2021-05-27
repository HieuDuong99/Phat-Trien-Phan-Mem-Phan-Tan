<?php 
require_once 'partials/header_view.php';
 ?>

          <div class="main-content-container container-fluid px-4">
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
              <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">Overview</span>
                <h3 class="page-title">User Profile</h3>
              </div>
            </div>
            <!-- End Page Header -->

            <?php echo $context['msg']->display() ?>
            
            <!-- Default Light Table -->
            <div class="row">
              <div class="col">
                <div class="card card-small mb-4 pt-3">
                  <div class="card-header border-bottom text-center">
                    <div class="mb-3 mx-auto d-fex align-items-center rounded-circle overflow-hidden" style="width: 110px; height: 110px;">
                      <img src="<?= !empty($this->auth->user->avatar_img)? STATIC_DIR.'/uploads/images/avatars/'.$this->auth->user->avatar_img:STATIC_DIR.'/images/default_ava.jpg' ?>" alt="User Avatar" style="width: 100%; height: 100%"> 
                  	</div>
                    <h4 class="mb-0"><?= $this->auth->user->full_name ?></h4>
                  </div>
                  <div class="card-body border-bottom">
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">Mã thành viên: </div>
                      <div class="font-weight-normal text-right"><?= $this->auth->user->id ?></div>
                    </div>
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">Tên đăng nhập: </div>
                      <div class="font-weight-normal text-right"><?= $this->auth->user->username ?></div>
                    </div>
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">Ngày tham gia: </div>
                      <div class="font-weight-normal text-right"><?= $this->auth->user->create_time ?></div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <form method="POST" action="" enctype="multipart/form-data">
                      <div class="form-group">
                        <label>Tên: </label>
                        <input type="text" placeholder="Tên" class="form-control" name="full_name" value="<?= $this->auth->user->full_name ?>">
                      </div>
                      <div class="form-group">
                        <label>SĐT: </label>
                        <input type="text" placeholder="SĐT" class="form-control" name="phone_number" value="<?= $this->auth->user->phone_number ?>">
                      </div>
                      <div class="form-group">
                        <label>Email: </label>
                        <input type="email" placeholder="SĐT" class="form-control" name="email" value="<?= $this->auth->user->email ?>">
                      </div>
                      <div class="form-group">
                        <label>Ảnh đại diện mới: </label>
                        <input type="file" class="form-control" id="avatar_img" name="avatar_img">              
                      </div>
                      <div class="d-flex justify-content-center">
                        <button class="btn btn-primary">Lưu</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <?php if ($this->auth->user->has_perm('author')): ?>
              <div class="col-lg-8">
                <div class="card card-small mb-4">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Bài báo</h6>
                  </div>
                  <div class="card-body p-0 pb-2">
    		            <table class="table table-responsive-sm mb-0 table-hover">
    		              <thead class="bg-secondary text-white">
    		                <tr>
    		                  <th scope="col" class="border-0 align-middle text-center">Ảnh</th>
    		                  <th scope="col" class="border-0 align-middle text-center">Tiêu đề</th>
    		                  <th scope="col" class="border-0 align-middle text-center">Nháp</th>
    		                  <th scope="col" class="border-0 align-middle text-center">Thời gian tạo</th>
    		                  <th scope="col" class="border-0 align-middle text-center">Hành động</th>
    		                </tr>
    		              </thead>
    		              <tbody>
    		                <?php foreach ($context["articles"] as $article): ?>
    		                  <tr class="item">
    		                    <td class="align-middle text-center"><img style="max-width: 200px;" src="<?= STATIC_DIR."/uploads/images/".$article->image ?>"></td>
    		                    <td class="align-middle text-center"><?= $article->title ?></td>
    		                    <td class="align-middle text-center"><?= $article->drafft? "True":"False" ?></td>
    		                    <td class="align-middle text-center"><?= $article->create_time ?></td>
    		              		<td class="align-middle text-center">
    		                      <div class="btn-group">
    		                        <div><a class="btn btn-info btn-sm" href="?cn=article_preview&article_id=<?= $article->id ?>"><i class="fas fa-info-circle"></i></a></div>

                                <?php if ($article->drafft && $this->auth->user->id == $article->author->id): ?>
                                <div><a class="btn btn-warning btn-sm" href="?cn=update_article&id=<?= $article->id ?>"><i class="fas fa-pencil-alt"></i></a></div>
                                <?php endif ?>

                                <?php if ($this->auth->user->id == $article->author->id && $article->drafft): ?>
                                <form action="?cn=delete_article" method="POST">
                                  <input type="hidden" name="delete_id" value="<?= $article->id ?>">
                                  <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Bạn có chắc muốn xóa ?')"><i class="fas fa-trash-alt"></i></button>
                                </form>
                                <?php endif ?>
    		                      </div>
    		                    </td>
    		                  </tr>
    		                <?php endforeach; ?>
    		              </tbody>
    		            </table>
    		          </div>
                </div>
                <div class="d-flex justify-content-center">
                  <?= $paging ?>
                </div>
              </div>
            <?php endif ?>
            </div>
            <!-- End Default Light Table -->
          </div>

<?php 
require_once 'partials/footer_view.php';
 ?>
