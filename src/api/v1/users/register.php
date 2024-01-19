<?php
require_once('../../../models/User.php');
require_once('../../../config/database.php');

// Gọi tệp cors.php để cấu hình CORS
require_once('../../../config/cors.php');
require_once('../../../../vendor/autoload.php');
use Firebase\JWT\JWT;
$userModel = new User($conn);

$request_method = $_SERVER['REQUEST_METHOD'];

switch ($request_method) {
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

            // Tạo JWT
            $secret_key = "your_secret_key"; // Thay thế bằng khóa bí mật thực tế
            $issuer_claim = "localhost"; // Điều này có thể thay đổi tùy thuộc vào domain của bạn
            $audience_claim = "the_client";
            $issued_at_claim = time();
            $not_before_claim = $issued_at_claim + 10; // Token không hợp lệ trước thời điểm này
            $expire_claim = $issued_at_claim + 60 * 60 * 1; // Hết hạn sau 1 giờ

            $token = array(
                "iss" => $issuer_claim,
                "aud" => $audience_claim,
                "iat" => $issued_at_claim,
                "nbf" => $not_before_claim,
                "exp" => $expire_claim,
                "data" => array(
                    "id" => $userId,
                    "username" => $username,
                    "email" => $email
                )
            );

            // Tạo JWT
            $jwt = JWT::encode($token, $secret_key, 'HS256');

            // Trả về JWT
            echo json_encode(
                array(
                    "success" => true,
                    "message" => "Registration successful!",
                    "user_id" => $userId,
                    "jwt" => $jwt,
                    "expireAt" => $expire_claim
                )
            );
        } else {
            // Người dùng đã tồn tại
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "User already exists."]);
        }
        break;
    default:
        http_response_code(405); // Phương thức không được hỗ trợ
        break;
}
