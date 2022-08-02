<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/definition.php");
Path::RequireOnce("/controllers/mysql.php");

$db = DB::getInstance();

// 驗證資料是否正確
if (isset($_POST, $_POST["account"], $_POST["email"])) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = $db->filter($value);
    }
} else {
    Utility::RedirectPost(
        Path::Path2Url("/forgetPwdPage.php"),
        [
            "error_msg" =>  "請求參數錯誤，請確認後再試。",
        ]
    );
}

// 製作 SQL
$query = sprintf("SELECT password FROM user WHERE account = '%s' AND email = '%s'", $_POST["account"], $_POST["email"]);

if ($db->num_rows($query) <= 0) {
    Utility::RedirectPost(
        Path::Path2Url("/forgetPwdPage.php"),
        [
            "error_msg" =>  "無此帳號資料，請確認後再試。",
        ]
    );
}

// 取得執行query後的值
list($pwd) = $db->get_row($query);

// 返回
Utility::RedirectPost(
    Path::Path2Url("/forgetPwdPage.php"),
    [
        "success_msg" =>  '您的密碼為： <span class="text-danger">' . $pwd . ' </span>',
    ]
);
