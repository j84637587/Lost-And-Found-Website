<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/definition.php") ?>
<!DOCTYPE html>
<html lang="en">
<?php $_DEF["_PAGE_TITLE"] = "註冊" ?>
<?php Path::IncludeOnce("/components/head.php")  ?>

<body>
  <?php Path::IncludeOnce("/components/header.php")  ?>
  <main id="main">
    <section id="contact" class="contact">
      <div class="container aos-init aos-animate" data-aos="fade-up">
        <div class="text-center">
          <h3>
            您必須加入成為本站會員，才有權限上傳物品喔。<br>
            若您尚未成為本站會員，請輸入您的帳號及密碼，然後按註冊鈕；<br>
            若您已經擁有帳號，請按登入；<br>
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
            <form action="<?= Path::Path2Url("/controllers/register.php") ?>" method="post" role="form" class="php-email-form">
              <div class="form-group mt-3">
                <label for="name">名稱</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="名稱" required="true">
              </div>
              <div class="form-group mt-3">
                <label for="email">信箱</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="帳號" required="true">
              </div>
              <div class="form-group mt-3">
                <label for="account">帳號</label>
                <input type="text" class="form-control" name="account" id="account" placeholder="帳號" required="true">
              </div>
              <div class="form-group mt-3">
                <label for="password">密碼</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="密碼" required="true">
              </div>
              <fieldset class="mt-5 px-3" style="border-width: 2px;border-style: groove;border-color: rgb(192, 192, 192);border-image: initial;">
                <legend>拾物領取注意事項</legend>
                <p>1. 認領遺失物時，須能提出證明其為遺失物之所有人，若認領人非所有人本人，須持本人及失物所有人相關證明文件始得領回遺失物。</p>
                <p>2. 遺失物若為貴重物品，須由失物所有人親自領回。</p>
                <hr/>
                <div class="form-group mt-3 d-flex justify-content-center align-items-center">
                  <label for="agreement">我了解並同意以上注意事項</label>
                  <input class="ms-3" type="checkbox" name="agreement" value="agreement" id="agreement" required="true">
                </div>
              </fieldset>
              <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary px-3">註冊</button>
              </div>
            </form>
          </div>
          <div class="text-center mt-5">
            <p>已經有帳號? <a href="<?= Path::Path2Url("loginPage.php") ?>">登入</a></p>
            <p>忘記密碼? <a href="<?= Path::Path2Url("forgetPwdPage.php") ?>">找回密碼</a></p>
          </div>
        </div>
      </div>
    </section>
  </main>
</body>

</html>