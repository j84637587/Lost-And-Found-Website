<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/definition.php");
Path::RequireOnce("/controllers/mysql.php");
Path::RequireOnce("/controllers/upload.php");

$db = DB::getInstance();

// 驗證資料是否正確
if (
    isset($_POST, $_POST["type"], $_POST["name"], $_POST["desc"])
    && ($_POST["type"] == '0' || $_POST["type"] == '1')
) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = $db->filter($value);
    }
} else {
    Utility::RedirectPost(
        Path::Path2Url("/itemCreatePage.php"),
        [
            "error_msg" =>  "請求參數錯誤，請確認後再試。",
        ]
    );
}

// 計算說明欄位的長度並驗證是否合法
$desc_len = mb_strlen($_POST["desc"], "utf-8");
if ($desc_len > 400) {
    Utility::RedirectPost(
        Path::Path2Url("/itemCreatePage.php"),
        [
            "error_msg" =>  "說明欄位字數 $desc_len 過多，最大為 200 個字，請修改後再試。",
        ]
    );
}

$fn = ""; // 檔名
if (!empty($_FILES['img'])) {
    // 檢查檔案是否出現錯誤
    if($_FILES['img']['error'] == UPLOAD_ERR_FORM_SIZE){
        throw new RuntimeException('Exceeded filesize limit.');
    }else if ($_FILES['img']['error'] != UPLOAD_ERR_OK && $_FILES['img']['error'] != UPLOAD_ERR_NO_FILE) {
        throw new RuntimeException('Unknown errors.');
    }

    $upload = Upload::factory('images/');
    $upload->file($_FILES['img']);

    //set max. file size (in mb)
    $upload->set_max_file_size(21); // 最大20 21是故意做緩衝

    //set allowed mime types
    // $upload->set_allowed_mime_types(array('application/pdf')); // 檔案類型限制 先不加

    $fn = Utility::guidv4($_SESSION["user_account"] . date("Y-m-d H:i:s")) . "." . pathinfo($_FILES['img']['name'], 4); // 取得UID來避免檔案名重複
    $results = $upload->upload($fn);    // 保存檔案
}

// 新增資料
$r = $db->insert_safe("item", [
    "type" => ($_POST["type"] == '0' ?  'lost' : 'found'),
    "name" => $_POST['name'],
    "description" => $_POST['desc'],
    "date" => $_POST['date'],
    "user_id" => $_SESSION['user_id'],
    "img_path" => $fn,
]);

if (!$r) {
    // 新增失敗要刪除保存的圖片
    if(!empty($fn))
        unlink("../images/$fn");
    Utility::RedirectPost(
        Path::Path2Url("/itemCreatePage.php"),
        [
            "error_msg" =>  "刊登失敗，請確認後再試。",
        ]
    );
}

// 取得剛剛新增的物品ID
$last = $db->lastid();
Utility::RedirectPost(
    Path::Path2Url("/itemListPage.php?id=$last"),
    [
        "success_msg" =>  "刊登完成，您的文章將於管理員審核後開放瀏覽。",
    ]
);
