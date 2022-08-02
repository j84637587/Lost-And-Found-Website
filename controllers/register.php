<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/definition.php");
Path::RequireOnce("/controllers/mysql.php");

$db = DB::getInstance();

// 驗證資料是否正確
if (isset($_POST, $_POST["account"], $_POST["password"], $_POST["email"])) {
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

$query = sprintf("SELECT * FROM user WHERE account = '%s'", $_POST["account"]); // , $_POST["password"]
if ($db->num_rows($query) > 0) {
    Utility::RedirectPost(
        Path::Path2Url("/registerPage.php"),
        [
            "error_msg" =>  "此帳號已被使用，請確認後再試。",
        ]
    );
}

$query = sprintf("SELECT * FROM user WHERE email = '%s'", $_POST["email"]); // , $_POST["password"]
if ($db->num_rows($query) > 0) {
    Utility::RedirectPost(
        Path::Path2Url("/registerPage.php"),
        [
            "error_msg" =>  "此信箱已被使用，請確認後再試。",
        ]
    );
}

$r = $db->insert('user', [
    "account" => $_POST['account'],
    "password" => $_POST['password'],
    "name" => $_POST['name'],
    "email" => $_POST['email'],
]);

if (!$r) {
    Utility::RedirectPost(
        Path::Path2Url("/registerPage.php"),
        [
            "error_msg" =>  "註冊帳號失敗，請確認後再試。",
        ]
    );
}

Utility::RedirectPost(
    Path::Path2Url("/loginPage.php"),
    [
        "success_msg" =>  "帳號成功註冊！",
    ]
);
