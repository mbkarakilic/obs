<?php
require "../../config/config.php";

$id = $_POST["id"];

$query = "
    SELECT
        c.id AS course_id,
        c.name AS course_name,
        c.semester AS course_semester,
        d.name AS department_name
    FROM
        student_courses sc
    JOIN
        courses c ON sc.course_id = c.id
    JOIN
        departments d ON c.department_id = d.id
    WHERE
        sc.student_id = $id
";

$result = mysqli_query($connection, $query);
$courses = mysqli_fetch_all($result, MYSQLI_ASSOC);

$requestResult = array(
    "success" => $result ? true : false,
    "courses" => $courses,
);

echo json_encode($requestResult);
