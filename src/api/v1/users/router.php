<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Max-Age: 86400");

// Xử lý yêu cầu OPTIONS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}

require_once('../../../config/database.php');
require_once('../../../models/User.php');

$userModel = new User($conn);

$request_uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

// Xác định endpoint và phương thức HTTP
$endpoint = $request_uri[4] ?? null; // Điều này phụ thuộc vào cách bạn cấu hình URL

switch ($endpoint) {
    case 'login':
        require_once('./login.php');
        break;
    case 'register':
        require_once('./register.php');
        break;
    case 'usersInfo': 
        require_once('./usersInfo.php');
        break;
    // Các endpoint khác có thể được thêm vào tương tự
    default:
        http_response_code(404);
        echo json_encode(["error" => "Endpoint not found"]);
        break;
}
