<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/definition.php");
Path::RequireOnce("/controllers/mysql.php");
Path::RequireOnce("/controllers/upload.php");

$db = DB::getInstance();
$isProfile = isset($_GET['profile']) && $_GET['profile'] == 'true'; // 是否為主頁模式
$isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] == 'Y';  // 是否為管理員

if ($isProfile) {
  $query = sprintf("SELECT * FROM item WHERE user_id='%s' ORDER BY id", $_SESSION['user_id']);
} else {
  $where = "";
  if (isset($_GET['sel_type']) && in_array($_GET['sel_type'], ["found", "lost"])) {
    $where .= " AND type='" . $_GET['sel_type'] . "'";
  }

  if (isset($_GET['keyWord']) && !empty($_GET['keyWord'])) {
    $where .= " AND (name LIKE '%" . $_GET['keyWord'] . "%' OR description LIKE '%" . $_GET['keyWord'] . "%')";
  }

  if (isset($_GET['start_time']) && !empty($_GET['start_time'])) {
    $where .= " AND date >= '" . $_GET['start_time'] . "'";
  }

  if (isset($_GET['end_time']) && !empty($_GET['end_time'])) {
    $where .= " AND date <= '" . $_GET['end_time'] . "'";
  }

  if ($isAdmin) {
    if (isset($_GET['sel_enable']) && in_array($_GET['sel_enable'], ["Y", "N"])) {
      $where .= " AND enable = '" . $_GET['sel_enable'] . "'";
    }
  }
  $query = sprintf("SELECT * FROM item WHERE del_date IS NULL AND (enable='Y' OR user_id='%s' OR 'Y'='%s') %s ORDER BY id", $_SESSION['user_id'], isset($_SESSION['admin']) ? $_SESSION['admin'] : "N", $where);
}
$items = $db->get_results($query);

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

<?php $_DEF["_PAGE_TITLE"] = "刊登清單" ?>
<?php Path::IncludeOnce("/components/head.php");  ?>

<body>
  <!-- ======= Header ======= -->
  <?php Path::IncludeOnce("/components/header.php");  ?>

  <main id="main">
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2>刊登清單</h2>
          <ol>
            <li><a href="<?= Path::Path2Url("/index.php") ?>">主頁</a></li>
            <li>刊登清單</li>
          </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs Section -->

    <section id="contact" class="contact">
      <div class="container aos-init aos-animate" data-aos="fade-up">
        <?php if (!$isProfile) { ?>
          <div class="text-center">
            <h3>
              在這裡您可以瀏覽本網站刊登的協尋與拾獲物品。<br>
            </h3>
          </div>
          <form action="<?= Path::Path2Url("/itemListPage.php") ?>" method="get" role="form" class="php-email-form">
            <div class="row align-items-end">
              <?php
              if ($isAdmin) {
              ?>
                <div class="form-group col-1 col-md-1 mx-2">
                  <label for="sel_enable">狀態</label>
                  <select name="sel_enable" id="sel_enable" class="form-select">
                    <option value="any" selected>不限</option>
                    <option value="N">待審核</option>
                    <option value="Y">審核</option>
                  </select>
                </div>
              <?php
              }
              ?>
              <div class="form-group col-1 col-md-1 mx-2">
                <label for="type">類型</label>
                <select name="sel_type" class="form-select">
                  <option value="any" selected>不限</option>
                  <option value="lost">協尋</option>
                  <option value="found">尋獲</option>
                </select>
              </div>
              <div class="form-group col-2 col-md-2 mx-2">
                <label for="keyWord">關鍵字搜尋</label>
                <input type="text" class="form-control" name="keyWord" id="keyWord" placeholder="關鍵字">
              </div>
              <div class="form-group col-2 col-md-2 mx-2">
                <label for="start_time">起始日期</label>
                <input type="datetime-local" class="form-control" name="start_time" id="start_time">
              </div>
              <div class="form-group col-2 col-md-2 mx-2">
                <label for="end_time">結束日期</label>
                <input type="datetime-local" class="form-control" name="end_time" id="end_time">
              </div>
              <div class="form-group col-2 col-md-2 mx-2">
                <button type="submit" class="btn btn-primary">查詢</button>
              </div>
            </div>
          </form>
        <?php } else { ?>

          <div class="text-center">
            <h3>
              這裡為您所刊登的文章。<br>
            </h3>
          </div>
        <?php } ?>
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
          <div class="col-lg-12 mt-5 mt-lg-0 d-flex align-items-stretch aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th scope="col">類型</th>
                  <th scope="col">物品名</th>
                  <th scope="col">敘述</th>
                  <th scope="col">時間點</th>
                  <th scope="col">照片</th>
                  <th scope="col">操作</th>
                </tr>
              </thead>
              <tbody id="table">
                <?php
                foreach ($items as $item) {
                ?>
                  <tr>
                    <td>
                      <?php
                      if ($isAdmin && $item['enable'] == 'N') {
                        echo "待審核";
                      }
                      if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $item['user_id']) {
                        echo "我的";
                      }
                      ?>
                      <?= $item['type'] == 'found' ? "尋獲" : "協尋" ?>
                    </td>
                    <td>
                      <?= $item['name'] ?>
                    </td>
                    <td style="max-width: 40vw;">
                      <pre style="white-space: pre-wrap;word-wrap: break-word;"><?= $item['description'] ?></pre>
                    </td>
                    <td>
                      <?= $item['date'] ?>
                    </td>
                    <td style="max-width: 10vw;">
                      <?php
                      if (isset($item['img_path']) && $item['img_path'] != "") {
                      ?>
                        <img src="<?= Path::Path2Url("/images/" . $item['img_path']) ?>" class="img-fluid" alt="">
                      <?php
                      }
                      ?>
                    </td>
                    <td>
                      <?php
                      $isMyPost = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $item['user_id'];
                      if (isset($item['del_date']) && !empty($item['del_date'])) {
                      ?>
                        <p class="text-danger">文章已刪除，刪除原因：<?= $item['del_reason'] ?></p>
                        <?php
                      } else if ($isAdmin) {
                        if ($item['enable'] == 'N') {
                        ?>
                          <form action='<?= Path::Path2Url("/controllers/toggleItem.php") ?>' style="display: inline-block;" method="post">
                            <input type="hidden" name="id" value="<?= $item['id'] ?>">
                            <button type="submit" name="toggle_btn" class="btn btn-success">審核</button>
                          </form>
                        <?php
                        }
                        if ($isMyPost) {
                        ?>
                          <form action='<?= Path::Path2Url("/itemEditPage.php") ?>' style="display: inline-block;" method="post">
                            <input type="hidden" name="id" value="<?= $item['id'] ?>">
                            <button type="submit" name="editItem_btn" class="btn btn-info">編輯</button>
                          </form>
                        <?php
                        }
                        ?>
                        <form action='<?= Path::Path2Url("/controllers/deleteItem.php") ?>' style="display: inline-block;" method="post" onsubmit="return getReason(this);">
                          <input type="hidden" name="id" value="<?= $item['id'] ?>">
                          <input type="hidden" name="reason" value="">
                          <button type="submit" name="delete_btn" class="btn btn-danger">刪除</button>
                        </form>
                      <?php
                      } else if ($isMyPost) {
                      ?>
                        <form action='<?= Path::Path2Url("/itemEditPage.php") ?>' style="display: inline-block;" method="post">
                          <input type="hidden" name="id" value="<?= $item['id'] ?>">
                          <button type="submit" name="editItem_btn" class="btn btn-info">編輯</button>
                        </form>
                        <form action='<?= Path::Path2Url("/controllers/deleteItem.php") ?>' style="display: inline-block;" method="post" onsubmit="return getReason(this);">
                          <input type="hidden" name="id" value="<?= $item['id'] ?>">
                          <button type="submit" name="delete_btn" class="btn btn-danger">刪除</button>
                        </form>
                      <?php
                      }
                      ?>
                    </td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
  </main>
</body>

</html>

<script type="text/javascript">
  function getReason(form) {
    let reason = prompt("請輸入刪除原因", "");
    console.log(reason);
    if (reason == "" || reason == null) {
      return false;
    }
    form.reason.value = reason;
    return confirm("您確定要刪除嗎?");
  }

  function showPreview(event) {
    if (event.target.files.length > 0) {
      var src = URL.createObjectURL(event.target.files[0]);
      var preview = document.getElementById("file-ip-1-preview");
      preview.src = src;
      preview.style.display = "block";
    }
  }
</script>