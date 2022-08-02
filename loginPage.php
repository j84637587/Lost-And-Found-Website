<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/definition.php") ?>
<?php
// 檢查是否已經登入了
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
  Utility::RedirectGet(Path::Path2Url("/index.php"));
}
?>
<!DOCTYPE html>
<html lang="en">

<?php $_DEF["_PAGE_TITLE"] = "登入" ?>
<?php Path::IncludeOnce("/components/head.php");  ?>

<body>
  <?php Path::IncludeOnce("/components/header.php");  ?>

  <main id="main">
    <section id="contact" class="contact">
      <div class="container aos-init aos-animate" data-aos="fade-up">
        <div class="text-center">
          <h3>
            您必須加入成為本站會員，才有權限上傳物品喔。<br>
            若您已經擁有帳號，請輸入您的帳號及密碼，然後按登入鈕；<br>
            若尚未成為本站會員，請按加入會員；<br>
            若您忘記自己的帳號及密碼，請按找回密碼。
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
                <label for="account">帳號</label> <input type="text" class="form-control" name="account" id="account" placeholder="帳號" required="true">
              </div>
              <div class="form-group mt-3">
                <label for="password">密碼</label> <input type="password" class="form-control" name="password" id="password" placeholder="密碼" required="true">
              </div>
              <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary px-3">登入</button>
              </div>
            </form>
          </div>
          <div class="text-center mt-5">
            <p>沒有帳號? <a href="<?= Path::Path2Url("/registerPage.php") ?>">註冊</a></p>
            <p>忘記密碼? <a href="<?= Path::Path2Url("/forgetPwdPage.php") ?>">找回密碼</a></p>
          </div>
        </div>
      </div>
    </section>
  </main>
</body>

</html>

<script type="text/javascript">
  function check_data() {
    if (document.myForm.account.value.length == 0)
      alert("帳號欄位不可以空白哦！");
    else if (document.myForm.password.value.length == 0)
      alert("密碼欄位不可以空白哦！");
    else
      myForm.submit();
  }
</script>