<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/definition.php");
Path::RequireOnce("/controllers/mysql.php");

$db = DB::getInstance();

// 驗證資料是否正確
if (isset($_POST, $_POST["account"], $_POST["password"])) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = $db->filter($value);
    }
}else{
    Utility::RedirectPost(
        Path::Path2Url("/registerPage.php"),
        [
            "error_msg" =>  "請求參數錯誤，請確認後再試。",
        ]
    );
}

// 製作 SQL
$query = sprintf("SELECT id, name, account, admin FROM user WHERE account = '%s' AND password = '%s'", $_POST["account"], $_POST["password"]);

if ($db->num_rows($query) <= 0) {
    Utility::RedirectPost(
        Path::Path2Url("/loginPage.php"),
        [
            "error_msg" =>  "無此帳號密碼，請確認後再試。",
        ]
    );
}

// 取得執行query後的值
list($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_account'], $_SESSION['admin']) = $db->get_row($query);

// 返回主頁
Utility::RedirectGet(Path::Path2Url("/index.php"));