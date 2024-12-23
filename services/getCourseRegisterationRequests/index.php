<?php
require "../../config/config.php";

// Gelen ID'yi al
$id = $_POST['id'];

// Veritabanında sorgulama yap
$query = "
    SELECT
        consultants.student_id, students.name, students.surname
    FROM
        consultants
    JOIN students ON consultants.student_id = students.id
    WHERE
        consultants.academic_id = $id
";

$result = mysqli_query($connection, $query);

// Sonuçları kontrol et
if ($result) {
    $students = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $requests = [];
    foreach ($students as $student) {
        $studentId = $student["student_id"];
        $query = "
        SELECT *
        FROM course_registeration_requests
        WHERE student_id = $studentId AND status = 0;
        ";

        $result = mysqli_query($connection, $query);

        if ($result) {
            $request = mysqli_fetch_assoc($result);
            $student['request'] = $request; // Add the request to the student data
            array_push($requests, $student);
        }
    }

    echo json_encode([
        "success" => true,
        "requests" => $requests,
    ]);

} else {
    echo json_encode([
        "success" => false,
        "message" => "Öğrenci bulunamadı",
    ]);
}
