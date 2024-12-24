<?php
require "../../config/config.php";

// Gelen verileri al
$student_id = $_POST['student_id'];
$place = $_POST['place'];
$role = $_POST['role'];
$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];

// SQL sorgusu
$query = "INSERT INTO internships (place, role, fromDate, toDate) VALUES ('$place', '$role', '$fromDate', '$toDate')";
$result = mysqli_query($connection, $query);

// Sonuçları kontrol et
if ($result) {
    $lastInsertId = mysqli_insert_id($connection);
    $query = "INSERT INTO internship_registeration_requests (student_id, internship_id, status) VALUES ($student_id, $lastInsertId, 0)";
    $result = mysqli_query($connection, $query);

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
} else {
    echo json_encode([
        "success" => false,
        "message" => "Hata oluştu",
        "error" => mysqli_error($connection),
    ]);
}
