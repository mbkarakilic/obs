<?php
require "../../config/config.php";

$id = $_POST["id"];

$query = "
SELECT
students.id AS student_id,
students.name AS student_name,
courses.name AS course_name,
exams.date AS exam_date,
exams.type AS exam_type,
grades.grade AS student_grade
FROM
grades
JOIN
students ON grades.student_id = students.id
JOIN
exams ON grades.exam_id = exams.id
JOIN
courses ON exams.course_id = courses.id
WHERE
students.id = $id;
";

$result = mysqli_query($connection, $query);
$grades = mysqli_fetch_all($result, MYSQLI_ASSOC);

$requestResult = array(
    "success" => $result ? true : false,
    "grades" => $grades,
);

echo json_encode($requestResult);
