<?php

require "../../config/config.php";

// POST verilerini al
$exam_id = $_POST['exam_id'];
$grades_json = $_POST['grades'];

// JSON verisini decode et
$grades = json_decode($grades_json, true);

$success = true;

foreach ($grades as $gradeData) {
    $grade = $gradeData["grade"];
    $student_id = $gradeData["student_id"];

    // Mevcut bir kayıt var mı kontrol et
    $checkQuery = "SELECT * FROM grades WHERE exam_id = $exam_id AND student_id = $student_id";
    $checkResult = mysqli_query($connection, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Kayıt varsa güncelle
        $query = "UPDATE grades SET grade = $grade WHERE exam_id = $exam_id AND student_id = $student_id";
    } else {
        // Kayıt yoksa ekle
        $query = "INSERT INTO grades (exam_id, student_id, grade) VALUES ($exam_id, $student_id, $grade)";
    }

    $result = mysqli_query($connection, $query);

    if (!$result) {
        $success = false;
        break;
    }
}

echo json_encode(array(
    "success" => $success,
));
