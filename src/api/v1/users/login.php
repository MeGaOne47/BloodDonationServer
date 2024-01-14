<?php
require_once('../../../models/User.php');
require_once('../../../config/database.php');

// Gọi tệp cors.php để cấu hình CORS
require_once('../../../config/cors.php');

$userModel = new User($conn);

$request_method = $_SERVER['REQUEST_METHOD'];

switch ($request_method) {
    case 'POST':
        // Đăng nhập
        $data = json_decode(file_get_contents("php://input"));
        $email = $data->email; // Thêm dòng này để lấy email từ yêu cầu
        $password = $data->password;
    
        // Kiểm tra xác thực người dùng
        $loggedInUser = $userModel->loginUser($email, $password);
    
        if ($loggedInUser) {
            // Đăng nhập thành công, có thể trả về thông tin người dùng hoặc thông báo thành công
            echo json_encode(["success" => true, "message" => "Login successful!", "user_id" => $loggedInUser['id']]);
        } else {
            // Đăng nhập thất bại
            http_response_code(401);
            echo json_encode(["success" => false, "message" => "Login failed. Invalid credentials."]);
        }
        break;
    default:
        http_response_code(405); // Phương thức không được hỗ trợ
        break;
}
