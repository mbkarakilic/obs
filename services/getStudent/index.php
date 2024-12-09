<?php
require "../../config/config.php";

// Gelen ID'yi al
$id = $_POST['studentId'];

// Veritabanında sorgulama yap
$query = "
    SELECT
        students.*,
        departments.name AS department_name
    FROM
        students
    JOIN
        departments
    ON
        students.department_id = departments.id
    WHERE
        students.id = $id
";

$result = mysqli_query($connection, $query);

// Sonuçları kontrol et
if ($result) {
    $student = mysqli_fetch_assoc($result);

    $query = "
    SELECT a.name
    FROM consultants c
    JOIN academics a ON c.academic_id = a.id
    WHERE c.student_id = 50; -- Burada istediğiniz student_id'yi belirtin
    ";

    $result = mysqli_query($connection, $query);

    if ($result) {
        $academician = mysqli_fetch_assoc($result);
        $student["academician"] = $academician["name"];
        echo json_encode([
            "success" => true,
            "student" => $student,
        ]);
    }

} else {
    echo json_encode([
        "success" => false,
        "message" => "Öğrenci bulunamadı",
    ]);
}
