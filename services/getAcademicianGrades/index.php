<?php
require "../../config/config.php";

$id = $_POST["id"];

$query = "
SELECT
    students.id AS student_id,
    students.name AS student_name,
    students.surname AS student_surname,
    grades.grade AS student_grade
FROM
    grades
JOIN
    students ON grades.student_id = students.id
WHERE
    grades.exam_id = $id;
";

$result = mysqli_query($connection, $query);

if ($result) {
    $grades = mysqli_fetch_all($result, MYSQLI_ASSOC);

    echo json_encode(array(
        "success" => true,
        "grades" => $grades,
    ));
} else {
    echo json_encode(array(
        "success" => false,
    ));
}
