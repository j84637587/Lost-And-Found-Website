<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/definition.php");
Path::RequireOnce("/controllers/mysql.php");
Path::RequireOnce("/controllers/upload.php");

$db = DB::getInstance();

// 驗證資料是否正確
if (isset($_POST, $_POST["id"], $_POST["type"], $_POST["name"], $_POST["desc"], $_POST["sel_type"]) && ($_POST["type"] == '0' || $_POST["type"] == '1')) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = $db->filter($value);
    }
} else {
    Utility::RedirectPost(
        Path::Path2Url("/itemEditPage.php"),
        [
            "error_msg" =>  "請求參數錯誤，請確認後再試。",
        ]
    );
}

// 只有會員才可編輯表單。
if (!isset($_SESSION['user_id'])) {
    Utility::RedirectPost(
        Path::Path2Url("/loginPage.php"),
        [
            "error_msg" =>  "只有會員才可編輯表單。",
        ]
    );
}

// 製作 SQL 確保文章沒有被刪除且是使用者所有
$query = sprintf("SELECT id, img_path FROM item WHERE del_date IS NULL AND user_id = '%s' AND id = '%s'", $_SESSION['user_id'], $_POST["id"]);
if ($db->num_rows($query) <= 0) {
    die($query);
    Utility::RedirectPost(
        Path::Path2Url("/itemListPage.php"),
        [
            "error_msg" =>  "無此文章或文章已被刪除，請確認後再試。",
        ]
    );
}

// 取得執行query後的值
list($id, $fn) = $db->get_row($query);

// 計算說明欄位的長度並驗證是否合法
$desc_len = mb_strlen($_POST["desc"], "utf-8");
if ($desc_len > 400) {
    Utility::RedirectPost(
        Path::Path2Url("/itemEditPage.php"),
        [
            "error_msg" =>  "說明欄位字數 $desc_len 過多，最大為 200 個字，請修改後再試。",
        ]
    );
}

if ($_POST["sel_type"] == "renew" && !empty($_FILES['img'])) {
    // 檢查檔案是否出現錯誤
    if ($_FILES['img']['error'] == UPLOAD_ERR_FORM_SIZE) {
        throw new RuntimeException('Exceeded filesize limit.');
    } else if ($_FILES['img']['error'] != UPLOAD_ERR_OK && $_FILES['img']['error'] != UPLOAD_ERR_NO_FILE) {
        throw new RuntimeException('Unknown errors.');
    }

    $upload = Upload::factory('images/');
    $upload->file($_FILES['img']);

    //set max. file size (in mb)
    $upload->set_max_file_size(21); // 最大20 21是故意做緩衝

    //set allowed mime types
    // $upload->set_allowed_mime_types(array('application/pdf')); // 檔案類型限制 先不加

    // 如果有原圖就沿用檔名
    if (!isset($fn) || empty($fn))
        $fn = Utility::guidv4($_SESSION["user_account"] . date("Y-m-d H:i:s")) . "." . pathinfo($_FILES['img']['name'], 4); // 取得UID來避免檔案名重複
    $results = $upload->upload($fn);    // 保存檔案
} else if ($_POST["sel_type"] == "delete") {
    if (!empty($fn))
        unlink("../images/$fn");
    $fn = "";
}

// 更新資料
$update = [
    "type" => ($_POST["type"] == '0' ?  'lost' : 'found'),
    'name' => $_POST["name"],
    "description" => $_POST['desc'],
    "date" => $_POST['date'],
    "img_path" => $fn,
    "enable" => "N",
];
$update_where = ['id' => $_POST["id"], 'user_id' => $_SESSION['user_id']];
$r = $db->update('item', $update, $update_where, 1);

if (!$r) {
    die("編輯失敗，請確認後再試。");
    Utility::RedirectPost(
        Path::Path2Url("/itemListPage.php"),
        [
            "error_msg" =>  "編輯失敗，請確認後再試。",
        ]
    );
}

// 取得剛剛新增的物品ID
Utility::RedirectPost(
    Path::Path2Url("/itemListPage.php"),
    [
        "success_msg" =>  "編輯完成，您的文章將於管理員審核後開放瀏覽。",
    ]
);
