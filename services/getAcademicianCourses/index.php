<?php
require "../../config/config.php";

$id = $_POST["id"];

$query = "
    SELECT
        c.id AS course_id,
        c.name AS course_name,
        c.semester AS course_semester,
        c.isFinished as course_isFinished,
        d.name AS department_name
    FROM
        academics_courses ac
    JOIN
        courses c ON ac.course_id = c.id
    JOIN
        departments d ON c.department_id = d.id
    WHERE
        ac.academic_id = $id
";

$result = mysqli_query($connection, $query);
$courses = mysqli_fetch_all($result, MYSQLI_ASSOC);

$requestResult = array(
    "success" => $result ? true : false,
    "courses" => $courses,
);

echo json_encode($requestResult);
