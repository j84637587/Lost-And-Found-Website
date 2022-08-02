<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/definition.php") ?>
<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center">
  <div class="container d-flex align-items-center justify-content-between">
    <div class="logo">
      <h1 class="text-light"><a href="<?= Path::Path2Url("/index.php") ?>"><span>失物招領</span></a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="<?= Path::Path2Url("/index.php") ?>"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
    </div>
    <nav id="navbar" class="navbar">
      <ul>
        <li><a class="nav-link scrollto active" href="<?= Path::Path2Url("/index.php") ?>">首頁</a></li>
        <li style="display: none;"><a class="nav-link scrollto" href="#about">注意事項</a></li>
        <li><a class="nav-link scrollto" href="<?= Path::Path2Url("/itemCreatePage.php") ?>">刊登</a></li>
        <li><a class="nav-link scrollto" href="<?= Path::Path2Url("/itemListPage.php") ?>">刊登文章清單</a></li>
        <?php
        if (isset($_SESSION["user_account"])) {
        ?>
          <li><a class="nav-link scrollto" href="<?= Path::Path2Url("/controllers/logout.php") ?>">登出</a></li>
          <li><a class="getstarted scrollto" href="<?= Path::Path2Url("/itemListPage.php?profile=true") ?>"><?= $_SESSION["user_account"] ?></a></li>
        <?php
        } else {
        ?>
          <li><a class="getstarted scrollto" href="<?= Path::Path2Url("/loginPage.php") ?>">登入 / 註冊</a></li>
        <?php
        }
        ?>
      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav><!-- .navbar -->
  </div>
</header><!-- End Header -->