<?php

require "../../config/config.php";

$id = $_POST["id"];

// Fetch the course registration request
$query = "SELECT * FROM internship_registeration_requests WHERE id = $id";
$result = mysqli_query($connection, $query);
$request = mysqli_fetch_assoc($result);
$studentId = $request["student_id"];
$internship_id = $request['internship_id'];

$updateQuery = "UPDATE internship_registeration_requests SET status = 1 WHERE id = $id";
mysqli_query($connection, $updateQuery);

$insertQuery = "INSERT INTO student_internships (student_id, internship_id) VALUES ($studentId, $internship_id)";
mysqli_query($connection, $insertQuery);

echo json_encode([
    "success" => true,
]);
