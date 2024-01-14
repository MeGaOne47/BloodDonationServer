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
    case 'POST':
        // Đăng ký tài khoản mới
        $data = json_decode(file_get_contents("php://input"));
        $username = $data->username;
        $email = $data->email;
        $password = $data->password;
    
        // Kiểm tra xem người dùng có tồn tại hay không
        $existingUser = $userModel->getUserByUsernameOrEmail($username, $email);
    
        if (!$existingUser) {
            // Người dùng chưa tồn tại, thực hiện đăng ký
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $userId = $userModel->createUser($username, $email, $hashedPassword);
    
            // Gán vai trò mặc định cho người dùng mới đăng ký (ví dụ: 'user')
            $defaultRoleId = 2; // ID của vai trò 'user' trong bảng roles
            $userModel->assignUserRole($userId, $defaultRoleId);
    
            // Trả về thông báo thành công hoặc ID của người dùng mới
            echo json_encode(["success" => true, "message" => "Registration successful!", "user_id" => $userId]);
        } else {
            // Người dùng đã tồn tại
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "User already exists."]);
        }
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
