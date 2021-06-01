<?php foreach ($cmts as $cmt): ?>
<div class="mb-2">
  <div class="font-weight-bold mb-1"><?= $cmt->user->username ?></div>
  <div class="mb-1"><?= $cmt->content ?></div>
  <div class="text-secondary"><?= date_format(date_create($cmt->create_time), 'd/m/Y, H:i') ?></div>
</div>
<?php endforeach ?>
<?php if($cmt_page > $page): ?>
  <div class="d-flex justify-content-center">
    <button class="btn btn-sm py-0" style="font-size: 12px" id="more-cmt" page="<?= $page + 1 ?>">Xem thêm bình luận</button>
  </div>
<?php endif ?>