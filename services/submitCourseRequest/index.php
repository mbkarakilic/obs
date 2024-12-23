<?php
require "../../config/config.php";

// Gelen verileri al
$student_id = $_POST['student_id'];
$courses = $_POST['courses']; // JSON string olarak bekleniyor

if (!$student_id || !$courses) {
    echo json_encode([
        "success" => false,
        "message" => "Eksik veri",
    ]);
    exit;
}

// JSON stringini güvenli hale getirme
$courses = mysqli_real_escape_string($connection, $courses);

// SQL sorgusu
$query = "INSERT INTO course_registeration_requests (student_id, courses) VALUES ('$student_id', '$courses')";

$result = mysqli_query($connection, $query);

// Sonuçları kontrol et
if ($result) {
    echo json_encode([
        "success" => true,
        "message" => "Kayıt başarıyla oluşturuldu",
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Hata oluştu",
        "error" => mysqli_error($connection),
    ]);
}
