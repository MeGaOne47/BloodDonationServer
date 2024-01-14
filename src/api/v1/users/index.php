<?php
require_once('../../../models/User.php');
require_once('../../../config/database.php');

// Gọi tệp cors.php để cấu hình CORS
require_once('../../../config/cors.php');

$userModel = new User($conn);

$request_method = $_SERVER['REQUEST_METHOD'];

switch ($request_method) {
    case 'GET':
        // Lấy danh sách tất cả người dùng
        $users = $userModel->getAllUsers();
        echo json_encode($users);
        break;
    case 'PUT':
        // Cập nhật thông tin người dùng
        $data = json_decode(file_get_contents("php://input"));
        $result = $userModel->updateUser($data->id, $data->username, $data->email);
        echo json_encode(["success" => $result]);
        break;
    case 'DELETE':
        // Xóa người dùng
        $data = json_decode(file_get_contents("php://input"));
        $result = $userModel->deleteUser($data->id);
        echo json_encode(["success" => $result]);
        break;
    default:
        http_response_code(405); // Phương thức không được hỗ trợ
        break;
}
