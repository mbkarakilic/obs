<?php
require "../../config/config.php";

$id = $_POST["id"];

$query = "
SELECT 
    e.id AS exam_id,
    e.date AS exam_date,
    e.type AS exam_type,
    e.percent AS exam_percent,
    e.course_id,
    c.name AS course_name,
    sc.student_id
FROM 
    student_courses sc
INNER JOIN 
    exams e
ON 
    sc.course_id = e.course_id
INNER JOIN 
    courses c
ON 
    c.id = sc.course_id
WHERE 
    sc.student_id = $id;

";

$result = mysqli_query($connection, $query);
$exams = mysqli_fetch_all($result, MYSQLI_ASSOC);

$requestResult = array(
    "success" => $result ? true : false,
    "exams" => $exams,
);

echo json_encode($requestResult);
