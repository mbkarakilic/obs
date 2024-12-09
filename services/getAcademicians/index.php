<?php
require "../../config/config.php";

$query = "SELECT * FROM academics";
$result = mysqli_query($connection, $query);
$academicians = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($result) {
    $coursesQuery = "
    SELECT
    ac.academic_id,
    c.name as course_name
    FROM
    academics_courses ac
    JOIN
    courses c ON ac.course_id = c.id";
    $coursesResult = mysqli_query($connection, $coursesQuery);
    $academics_courses = mysqli_fetch_all($coursesResult, MYSQLI_ASSOC);

    $requestResult = array(
        "success" => $coursesResult ? true : false,
        "academicians" => $academicians,
        "courses" => $academics_courses,
    );

} else {
    $requestResult = array(
        "success" => false,
    );
}

echo json_encode($requestResult);
