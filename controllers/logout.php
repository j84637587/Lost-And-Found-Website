<?php
header("Content-Type:text/html; charset=utf-8");
//開啟Session
session_start();
//清除Session
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once($_SERVER['DOCUMENT_ROOT'] . "./definition.php") ?>
<?php $_DEF["_PAGE_TITLE"] = "登出" ?>
<?= Path::IncludeOnce("/components/head.php") ?>

<body>
  <!-- ======= Header ======= -->
  <?= Path::IncludeOnce("/components/header.php") ?>

  <section id="contact" class="contact">
    <div class="container aos-init aos-animate mt-5" data-aos="fade-up">
      <div class="text-center">
        <h3>
          您登出了<br>
          <p><a href="/">返回主頁</a></p>
        </h3>
      </div>
    </div>
  </section>
</body>
</html>