<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . "/definition.php");
if (!isset($_SESSION['user_id'])) {
  Utility::RedirectPost(
    Path::Path2Url("/loginPage.php"),
    [
        "error_msg" =>  "只有會員才可刊登文章。",
    ]
);
}
?>
<!DOCTYPE html>
<html lang="en">

<style>
  .form-input img {
    width: 100%;
    display: none;
    margin-bottom: 30px;
  }
</style>

<?php $_DEF["_PAGE_TITLE"] = "刊登文章" ?>
<?php Path::IncludeOnce("/components/head.php");  ?>

<body>
  <?php Path::IncludeOnce("/components/header.php");  ?>

  <main id="main">
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2>刊登文章</h2>
          <ol>
            <li><a href="<?= Path::Path2Url("/index.php") ?>">主頁</a></li>
            <li>刊登文章</li>
          </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs Section -->

    <section id="contact" class="contact">
      <div class="container aos-init aos-animate" data-aos="fade-up">
        <div class="text-center">
          <h3>
            您可將遺失/拾獲的物品資訊做刊登。<br>
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
            <form action="<?= Path::Path2Url("/controllers/createItem.php") ?>" method="post" enctype="multipart/form-data" role="form" class="php-email-form">
              <div class="form-group mt-3">
                <input class="form-check-input" type="radio" id="lost" name="type" value="0" checked>
                <label class="form-check-label" for="lost">我要找</label>
              </div>
              <div class="form-group">
                <input class="form-check-input" type="radio" id="found" name="type" value="1">
                <label class="form-check-label" for="found">我找到</label>
              </div>
              <div class="form-group mt-3">
                <label for="date">遺失/拾獲日期 (點擊日曆圖示選擇)</label>
                <input id='date' name="date" type='datetime-local' class='form-control' />
              </div>
              <div class="form-group mt-3">
                <label for="name">物品名稱</label>
                <input id="name" name="name" type="text" class="form-control" placeholder="物品名稱" required="true">
              </div>
              <div class="form-group mt-3">
                <label for="desc">物品概述(詳細的物品外觀特徵、物品遺失/拾獲地點 等資訊)</label>
                <textarea rows="5" class="form-control" name="desc" id="desc" placeholder="物品概述" required="true"></textarea>
              </div>
              <div class="form-group mt-3">
                <label for="img">物品圖片<span class="text-danger">(限制20MB)</span></label>
                <input id="img" name="img" type="file" accept="image/*" onchange="showPreview(event);" class="form-control" style="height: 35px;">
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