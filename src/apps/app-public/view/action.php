<div class="container h-100" style="min-height: 80vh;">
  <div class="pad-col" style="padding: 39px;"><br><br></div>

  <div style="padding: 30px;"></div>
  <div class="row">
    <div class="col-12 text-center bg-white border-radius-xl shadow">
      <br><br>
      <?php if (isset($_GET['unsubscribe'])) : ?>
        <div class="card mb-3 ">
          <h6 class="text-<?= ($data['error']) ? 'danger' : 'success' ?> mb-3" style="font-size: 1.5em;"><?= $data['message'] ?></h6>
        </div>
        <p class="mb-3 ">
          <a href="./home" class="btn btn-secondary border-radius-lg"> Back to home page </a>
        </p>
      <?php else : ?>
        <h5>
          <p><span>Confirm below if you would like to unsubscribe</span></p>
          <br>
          <a class="btn btn-block btn-secondary shadow-none border-radius-lg" href="?distroy=true&mail=<?= $_GET['mail'] ?>&unsubscribe=true">Unsubscribe</a>
        </h5>
      <?php endif; ?>
    </div>
  </div>
</div>