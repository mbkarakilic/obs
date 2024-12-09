<?php
require "../../config/config.php";

// Gelen ID'yi al
$id = $_POST['id'];

// Veritabanında sorgulama yap
$query = "
SELECT students.*, departments.name AS department_name
FROM consultants
JOIN students ON consultants.student_id = students.id
JOIN departments ON students.department_id = departments.id
WHERE consultants.academic_id = $id;
";
$result = mysqli_query($connection, $query);
$students = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Sonuçları kontrol et
if ($result) {
    echo json_encode([
        "success" => true,
        "students" => $students,
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Hata oluştu",
    ]);
}
