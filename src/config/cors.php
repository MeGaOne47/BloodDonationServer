<?php
// cors.php

// Thiết lập CORS headers
header("Access-Control-Allow-Origin: *"); // Cho phép tất cả các domain truy cập
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE"); // Các phương thức được phép
header("Access-Control-Allow-Headers: *"); // Cho phép tất cả các header
header("Access-Control-Max-Age: 86400"); // Cache CORS headers trong 1 ngày

// Xử lý yêu cầu OPTIONS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}
?>
