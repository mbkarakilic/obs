<?php

require "../../config/config.php";

// POST verilerini alın
$courseName = $_POST["courseName"];
$departmentId = (int) ($_POST["department_id"]);
$semester = (int) $_POST["semester"];

// INSERT sorgusu
$query = "INSERT INTO courses (name, department_id, semester) VALUES ('$courseName', $departmentId, $semester)";

// Sorguyu çalıştır ve kontrol et
if (mysqli_query($connection, $query)) {

    $res = array(
        "success" => true,
    );

    echo json_encode($res);

} else {
    $res = array(
        "success" => false,
    );

    echo json_encode($res);
}
