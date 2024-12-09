<?php
require "../../config/config.php";

$id = $_POST["id"];

$query = "
SELECT
    e.id AS exam_id,
    e.date AS exam_date,
    e.type AS exam_type,
    e.course_id AS course_id,
    c.name AS course_name
FROM
    exams e
JOIN
    academics_courses ac ON e.course_id = ac.course_id
JOIN
    courses c ON e.course_id = c.id
WHERE
    ac.academic_id = $id;
";

$result = mysqli_query($connection, $query);

if ($result) {
    $grades = mysqli_fetch_all($result, MYSQLI_ASSOC);

    echo json_encode(array(
        "success" => true,
        "exams" => $grades,
    ));
} else {
    echo json_encode(array(
        "success" => false,
    ));
}
