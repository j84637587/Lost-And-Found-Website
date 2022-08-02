<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/definition.php") ?>
<!DOCTYPE html>
<html lang="en">

<style>
  .form-input img {
  width:100%;
  display:none;
  margin-bottom:30px;
}
</style>

<?php $_DEF["_PAGE_TITLE"] = "登入" ?>
<?php Path::IncludeOnce("/components/head.php");  ?>

<body>
  <!-- ======= Header ======= -->
  <?php Path::IncludeOnce("/components/header.php");  ?>

  <main id="main">
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2>遺失表單</h2>
          <ol>
            <li><a href="<?= Path::Path2Url("/index.php") ?>">主頁</a></li>
            <li>遺失表單</li>
          </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs Section -->

    <section id="contact" class="contact">
      <div class="container aos-init aos-animate" data-aos="fade-up">
        <div class="text-center">
          <h3>
            您可將遺失的物品資訊做刊登。<br>
          </h3>
        </div>
        <div class="row d-flex justify-content-center mt-5">
          <?php
          // 錯誤訊息
          if (isset($_POST["error_msg"])) {
          ?>
            <div class="alert alert-danger col-lg-7" role="alert">
              <?= $_POST["error_msg"] ?>
            </div>
          <?php
          }
          // 成功訊息
          if (isset($_POST["success_msg"])) {
          ?>
            <div class="alert alert-success col-lg-7" role="alert">
              <?= $_POST["success_msg"] ?>
            </div>
          <?php
          }
          ?>
          <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
            <form action="<?= Path::Path2Url("/controllers/login.php") ?>" method="post" role="form" class="php-email-form">
              <div class="form-group mt-3">
                <label for="name">物品名稱</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="物品名稱" required="true">
              </div>
              <div class="form-group mt-3">
                <label for="desc">物品概述(詳細的物品外觀、物品可能遺失地點)</label>
                <textarea rows="5" class="form-control" name="desc" id="desc" placeholder="物品概述" required="true"></textarea>
              </div>
              <div class="form-group mt-3">
                <label for="img">物品圖片<span class="text-danger">(限制20MB)</span></label>
                <input type="file" accept="image/*" onchange="showPreview(event);" class="form-control" style="height: 35px;" name="img" id="img">
              </div>
              <div class="preview">
                <img id="file-ip-1-preview">
              </div>
              <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary px-3">刊登</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>
</body>

</html>

<script type="text/javascript">
  function showPreview(event) {
    if (event.target.files.length > 0) {
      var src = URL.createObjectURL(event.target.files[0]);
      var preview = document.getElementById("file-ip-1-preview");
      preview.src = src;
      preview.style.display = "block";
    }
  }
</script>