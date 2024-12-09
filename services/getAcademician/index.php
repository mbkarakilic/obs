<?php
require "../../config/config.php";

// Gelen ID'yi al
$id = $_POST['academicianId'];

// Veritabanında sorgulama yap
$query = "SELECT * FROM academics WHERE id = $id";
$result = mysqli_query($connection, $query);
$academician = mysqli_fetch_assoc($result);

if ($result) {
    $query = "
    SELECT
    c.id AS course_id,
        c.name AS course_name
    FROM
        academics_courses ac
    JOIN
        courses c ON ac.course_id = c.id
    WHERE
        ac.academic_id = $id";

    $result = mysqli_query($connection, $query);
    $courses = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Akademisyen ve ders kontrolü
    if ($result) {
        echo json_encode([
            "success" => true,
            "academician" => $academician,
            "courses" => $courses,
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Akademisyen bulunamadi",
    ]);
}
