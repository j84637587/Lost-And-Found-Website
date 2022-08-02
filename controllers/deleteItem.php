<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/definition.php");
Path::RequireOnce("/controllers/mysql.php");

$db = DB::getInstance();

// 驗證資料是否正確
if (isset($_POST, $_POST["id"], $_POST["reason"])) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = $db->filter($value);
    }
} else {
    die("error");
    Utility::RedirectPost(
        Path::Path2Url("/itemListPage.php"),
        [
            "error_msg" =>  "請求參數錯誤，請確認後再試。",
        ]
    );
}

// 確保只有文章使用者可以刪除(管理員除外)
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 'Y') {
    $query = sprintf("SELECT * FROM item WHERE id = '%s' AND user_id = '%s'", $_POST["id"], $_SESSION["user_id"]);
    if ($db->num_rows($query) <= 0) {
        Utility::RedirectPost(
            Path::Path2Url("/itemListPage.php"),
            [
                "error_msg" =>  "無此文章，請確認後再試。",
            ]
        );
    }
}

// 更新刪除資訊
$update = ['del_reason' => $_POST["reason"], 'del_date' => date('Y-m-d H:i:s')];
$update_where = ['id' => $_POST["id"]];
$r = $db->update('item', $update, $update_where, 1);

if (!$r) {
    Utility::RedirectPost(
        Path::Path2Url("/itemListPage.php"),
        [
            "error_msg" =>  "刪除失敗，請確認後再試。",
        ]
    );
}

// 返回上一頁
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
