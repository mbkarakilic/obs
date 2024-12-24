<?php
require "../../config/config.php";

$id = $_POST["id"];

$query = "SELECT * from student_internships WHERE student_id = $id";
$result = mysqli_query($connection, $query);
$request = mysqli_fetch_all($result, MYSQLI_ASSOC);

$requests = [];
foreach ($request as $key => $value) {
    $internship_id = $value["internship_id"];
    $query = "SELECT req.*, interns.* FROM internship_registeration_requests AS req JOIN internships AS interns ON req.internship_id = interns.id WHERE req.internship_id = $internship_id";
    $result = mysqli_query($connection, $query);
    $request[$key] = mysqli_fetch_assoc($result);

    array_push($requests, $request[$key]);
}

echo json_encode(
    array(
        "success" => true,
        "requests" => $requests,
    )
);
