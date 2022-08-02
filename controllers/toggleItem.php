<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/definition.php");
Path::RequireOnce("/controllers/mysql.php");

// 確保只有管理員可以操作
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 'Y') {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$db = DB::getInstance();

// 驗證資料是否正確
if (isset($_POST, $_POST["id"])) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = $db->filter($value);
    }
} else {
    Utility::RedirectPost(
        Path::Path2Url("/itemListPage.php"),
        [
            "error_msg" =>  "請求參數錯誤，請確認後再試。",
        ]
    );
}

// 查看操作文章是否存在
$query = sprintf("SELECT enable FROM item WHERE id= '%s'", $_POST["id"]);
if ($db->num_rows($query) <= 0) {
    Utility::RedirectPost(
        Path::Path2Url("/itemListPage.php"),
        [
            "error_msg" =>  "無此文章，請確認後再試。",
        ]
    );
}

// 取得文章是否已經被審核
list($toggle) = $db->get_row($query);


// 更新文章審核狀態
$update = ['enable' => ($toggle == "Y" ? "N" : "Y")];
$update_where = ['id' => $_POST["id"]];
$r = $db->update('item', $update, $update_where, 1);

if (!$r) {
    Utility::RedirectPost(
        Path::Path2Url("/itemListPage.php"),
        [
            "error_msg" =>  "切換失敗，請確認後再試。",
        ]
    );
}

// 返回上一頁
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();