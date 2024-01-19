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
        // Đăng nhập
        $data = json_decode(file_get_contents("php://input"));
        $email = $data->email; // Thêm dòng này để lấy email từ yêu cầu
        $password = $data->password;

        // Kiểm tra xác thực người dùng
        $loggedInUser = $userModel->loginUser($email, $password);

        if ($loggedInUser) {
            // Tạo JWT
            $secret_key = "hungnguyentanhung24022002"; // Thay thế bằng khóa bí mật thực tế
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
                    "id" => $loggedInUser['id'],
                    "username" => $loggedInUser['username'],
                    "email" => $loggedInUser['email']
                )
            );

            // Tạo JWT
            $jwt = JWT::encode($token, $secret_key, 'HS256');

            // Trả về JWT
            echo json_encode(
                array(
                    "message" => "Login successful.",
                    "jwt" => $jwt,
                    "expireAt" => $expire_claim
                )
            );
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
