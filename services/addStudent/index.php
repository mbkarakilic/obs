<?php

require "../../config/config.php";

// POST verilerini alın
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$nationalId = $_POST["nationalId"];
$departmentId = $_POST["department_id"];
$consultantId = $_POST["consultant_id"];

// INSERT sorgusu
$query = "INSERT INTO students (name, surname, nationalId, department_id) VALUES ('$firstname', '$lastname', '$nationalId', $departmentId)";

// Sorguyu çalıştır ve kontrol et
if (mysqli_query($connection, $query)) {
    // INSERT başarılı ise son eklenen ID'yi al
    $last_id = mysqli_insert_id($connection);

    // UPDATE sorgusu
    $update_query = "
        UPDATE students
        SET username = FLOOR(1000000000 + RAND() * 9000000000)
        WHERE id = $last_id
    ";

    if (mysqli_query($connection, $update_query)) {
        $query = "INSERT INTO consultants (academic_id, student_id) VALUES ($consultantId, $last_id)";
        $res = array(
            "success" => mysqli_query($connection, $query),
        );
    }

    echo json_encode($res);

} else {
    $res = array(
        "success" => false,
    );

    echo json_encode($res);
}
