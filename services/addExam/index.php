<?php
require "../../config/config.php";

$course_id = $_POST["course_id"];
$date = $_POST["date"];
$type = $_POST["type"];
$academic_id = (int) $_POST["academic_id"];
$percent = (int) $_POST["percent"];

$query = "INSERT INTO exams (course_id, date, academic_id, type, percent) VALUES ($course_id, '$date', $academic_id, $type, $percent)";

$result = mysqli_query($connection, $query);

$requestResult = array(
    "success" => $result ? true : false,
);

echo json_encode($requestResult);
