<?php
$host = "localhost";
$port = "5433"; // Sửa đổi thành cổng PostgreSQL của bạn
$username = "postgres";
$password = "postgres";
$database = "crud_postgres";

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Kết nối thành công!";
} catch (PDOException $e) {
    echo "Lỗi kết nối: " . $e->getMessage();
    die(); // Dừng chương trình nếu có lỗi kết nối
}
