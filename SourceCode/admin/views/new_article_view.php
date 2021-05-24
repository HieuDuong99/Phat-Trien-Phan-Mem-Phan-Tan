<?php require_once 'partials/header_view.php'; ?>

    <link rel="stylesheet" href="<?= STATIC_DIR ?>/css/quill.snow.css">
    <link rel="stylesheet" href="<?= STATIC_DIR ?>/css/select2.min.css">

    <!-- Page Header -->
    <div class="page-header row no-gutters py-4">
      <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h3 class="page-title">Bài viết mới</h3>
      </div>
    </div>

    <?php echo $msg->display() ?>

    <div class="row">
      <div class="col-lg-9 col-md-12">
        <div class="row">
          <div class="col-12">
            <div class="card card-small mb-3">
              <div class="card-body">
                <form id="main_form" method="POST" action="?cn=new_article" class="add-new-post" enctype="multipart/form-data">
                  <input class="form-control form-control-lg mb-3" type="text" placeholder="Tiêu đề" id="title" name="title" value="<?= $this->old_input('title') ?>">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <textarea class="form-control" placeholder="Tóm tắt" required maxlength="255" id="description" name="description"><?= $this->old_input('description') ?></textarea>
                    </div>
                    <div class="form-group col-md-6">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Ảnh minh họa</span>
                        </div>
                        <input type="file" class="form-control" id="image" name="image">
                      </div>                    
                    </div>
                  </div>
                  <div id="editor-container" class="add-new-post__editor mb-1" style="height: 500px"></div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class='card card-small mb-3'>
              <div class="card-header border-bottom">
                <h6 class="m-0">Danh mục</h6>
              </div>
              <div class='card-body p-0'>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item px-3 pb-0">
                    <div class="form-group">
                      <select id="category" class="form-control" name="category_id">
                        <option value="" selected>Không</option>
                        <?php foreach ($context["categories"] as $category): ?>
                          <option value="<?= $category->id ?>" <?php if ($this->old_input('category_id') == $category->id): ?> selected <?php endif ?>><?= $category->name ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class='card card-small mb-3'>
              <div class="card-header border-bottom">
                <h6 class="m-0">Tags</h6>
              </div>
              <div class='card-body p-0'>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex px-3">
                    <select class="form-control" name="tags[]" id="tags" multiple>
                      <?php foreach ($context["tags"] as $tag): ?>
                          <option value="<?= $tag->id ?>"><?= $tag->name ?></option>
                      <?php endforeach; ?>
                    </select>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-12">
        <!-- Post Overview -->
        <div class="card card-small card-post card-post--1 mb-3">
          <div id="preview_image" class="card-post__image" style="background-size: contain;">
            <span id="preview_category" href="#" class="card-post__category badge badge-pill badge-primary">Không</span>
          </div>
          <div class="card-body">
            <h5 class="card-title">
              <span id="preview_title" class="text-fiord-blue" href="#">Không có tiêu đề</span>
            </h5>
            <p id="preview_description" class="card-text d-inline-block">Không có tóm tắt</p>
          </div>
          <div class="card-footer text-muted border-top py-3">
            <span class="d-inline-block">Tác giả
              <strong class="text-fiord-blue"><?= $this->auth->user->full_name ?></strong> 
            </span>
          </div>
        </div>
        
        <!-- / Post Overview -->
      </div>
      <div class="col-lg-9 col-md-12">
        <div class='card card-small mb-3'>
          <div class="card-header border-bottom">
            <h6 class="m-0">Hành động</h6>
          </div>
          <div class='card-body p-0'>
            <ul class="list-group list-group-flush">
              <li class="list-group-item px-3">
                <button id="btn_draft" class="btn btn-sm btn-outline-accent">
                  <i class="material-icons">save</i> Lưu nháp</button>
                <button id="btn_review" class="btn btn-sm btn-accent ml-auto">
                  <i class="material-icons">file_copy</i> Nộp xét duyệt</button>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <script src="<?= STATIC_DIR ?>/js/quill.min.js"></script>
    <script src="<?= STATIC_DIR ?>/js/select2.min.js"></script>
    <script type="text/javascript">
      var quill;
      var content = <?= json_encode($this->old_input('content')) ?>;

      (function ($) {
          $(document).ready(function () {
            $('#tags').select2({
              placeholder: "Add tags",
              tags: true,
              createTag: function (params) {
                var term = $.trim(params.term);

                if (term === '') {
                  return null;
                }

                return {
                  id: term,
                  text: term,
                  newTag: true,
                };
              }
            });

            var toolbarOptions = [
              [{ 'header': [1, 2, 3, 4, 5, false] }],
              ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
              ['blockquote', 'code-block'],
              [{ 'header': 1 }, { 'header': 2 }],               // custom button values
              [{ 'list': 'ordered'}, { 'list': 'bullet' }],
              [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
              [{ 'indent': '-1'}, { 'indent': '+1' }],
              ['image']          // outdent/indent                                       // remove formatting button
            ];

            // Init the Quill RTE
            quill = new Quill('#editor-container', {
              modules: {
                toolbar: toolbarOptions
              },
              placeholder: 'Words can be like x-rays if you use them properly...',
              theme: 'snow'
            });

            quill.setContents(quill.clipboard.convert(content));

            $("#btn_draft").on('click', function() {
              $("#main_form").append($("<input/>").attr({
                type: 'hidden',
                value: 1,
                name: "drafft"
              }));
              $("#main_form").submit();
            }); 

            $("#btn_review").on('click', function() {
              $("#main_form").append($("<input/>").attr({
                type: 'hidden',
                value: 0,
                name: "drafft"
              }));
              $("#main_form").submit();
            });

            $("#image").on('change', function() {
              if (this.files && this.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                  console.log(e.target.result);
                  $('#preview_image').css({
                    background: "url(" + e.target.result + ")",
                    backgroundSize: "contain",
                    backgroundRepeat: 'no-repeat',
                    backgroundPosition: 'center'
                  });
                };
                
                reader.readAsDataURL(this.files[0]); 
              }
            });

            $("#description").on('change', function() {
              let value = $(this).val()!=""? $(this).val():"Không có tóm tắt";
              $("#preview_description").html(value);
            });

            $("#title").on('change', function() {
              let value = $(this).val()!=""? $(this).val():"Không có tiêu đề";
              $("#preview_title").html(value);
            });

            $("#category").on('change', function() {
              let value = $(this).val()!=""? $(this).children('option:selected').text():"Không";
              $("#preview_category").html(value);
            });

            $("#main_form").on('submit', function() {
              let content = $("<input/>").attr({
                type: 'hidden',
                value: $('#editor-container .ql-editor').html(),
                name: "content"
              });
              $(this).append(content).append($("#category")).append($("#tags"));
            });
          });
        })(jQuery);
    </script>

<?php require_once 'partials/footer_view.php'; ?>