<?php
require "../../config/config.php";

// Gelen verileri al
$id = $_POST['id'];
$nationalId = $_POST['nationalId'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$courses = json_decode($_POST['courses'], true); // courses JSON stringini diziye dönüştür

// Akademisyen bilgilerini güncelle
$query = "UPDATE academics SET nationalId = '$nationalId', name = '$firstname', surname = '$lastname' WHERE id = $id";
$result = mysqli_query($connection, $query);

if ($result) {
    // İlk olarak, mevcut kurs ilişkilerini sil
    $deleteQuery = "DELETE FROM academics_courses WHERE academic_id = $id";
    $deleteResult = mysqli_query($connection, $deleteQuery);

    if ($deleteResult) {
        // Yeni kurs ilişkilerini ekle
        foreach ($courses as $course) {
            $courseId = $course['course_id']; // Kurs ID'sini al
            $insertQuery = "INSERT INTO academics_courses (academic_id, course_id) VALUES ($id, $courseId)";
            $insertResult = mysqli_query($connection, $insertQuery);

            // Hata kontrolü
            if (!$insertResult) {
                echo json_encode([
                    "success" => false,
                    "message" => "Kurs ekleme sırasında hata oluştu",
                ]);
                exit;
            }
        }

        echo json_encode([
            "success" => true,
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Mevcut kurslar silinemedi",
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Akademisyen bilgileri güncellenemedi",
    ]);
}
