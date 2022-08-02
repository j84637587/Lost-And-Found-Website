<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/definition.php") ?>
<!DOCTYPE html>
<html lang="en">

<style>
  .form-input img {
    width: 100%;
    display: none;
    margin-bottom: 30px;
  }
</style>

<?php $_DEF["_PAGE_TITLE"] = "查詢密碼" ?>
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
            請輸入您的帳號及E-mail，然後按 [查詢] 鈕。<br>
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
            <form action="<?= Path::Path2Url("/controllers/forgetPwd.php") ?>" method="post" role="form" class="php-email-form">
              <div class="form-group mt-3">
                <label for="account">帳號</label>
                <input type="text" class="form-control" name="account" id="account" placeholder="帳號" required="true">
              </div>
              <div class="form-group mt-3">
                <label for="email">Email</label>
                <input type="test" class="form-control" name="email" id="email" placeholder="Email" required="true">
              </div>
              <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary px-3">查詢</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>
</body>

</html>