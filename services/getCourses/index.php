<?php
require "../../config/config.php";

$query = "
    SELECT
        courses.*,
        departments.name AS department_name
    FROM
        courses
    JOIN
        departments
    ON
        courses.department_id = departments.id
";
$result = mysqli_query($connection, $query);
$courses = mysqli_fetch_all($result, MYSQLI_ASSOC);

$requestResult = array(
    "success" => $result ? true : false,
    "courses" => $courses,
);

echo json_encode($requestResult);
