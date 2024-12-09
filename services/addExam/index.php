<?php
require "../../config/config.php";

$course_id = $_POST["course_id"];
$date = $_POST["date"];

$query = "INSERT INTO exams (course_id, date) VALUES ($course_id, '$date')";

$result = mysqli_query($connection, $query);

$requestResult = array(
    "success" => $result ? true : false,
);

echo json_encode($requestResult);
