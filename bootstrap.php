<?php
//bootstrap.php
define('_DIR_ROOT', __DIR__);

// Xử lý http root. Kết quả trả về ví dụ: http://localhost/my_project
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    $web_root = 'https://' . $_SERVER['HTTP_HOST'];
} else {
    $web_root = 'http://' . $_SERVER['HTTP_HOST'];
}

// Lấy đường dẫn thư mục gốc của máy chủ web
$document_root = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/');

// Lấy đường dẫn hiện tại của dự án
$dir_root = rtrim(str_replace('\\', '/', _DIR_ROOT), '/');

// Tìm thư mục con của dự án dựa trên đường dẫn hiện tại và thư mục gốc của máy chủ
$folder = str_replace($document_root, '', $dir_root);
$folder = ltrim($folder, '/');

// Kết hợp để tạo URL gốc của dự án
$web_root = $web_root . '/' . $folder;
define('_WEB_ROOT', $web_root);



require_once 'configs/routes.php';
require_once 'app/App.php'; // Load app
require_once 'core/BaseController.php'; // Load Base Controller
require_once 'core/Database.php'; // Load Connect Database