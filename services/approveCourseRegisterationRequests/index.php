<?php

require "../../config/config.php";

$id = $_POST["id"];

// Fetch the course registration request
$query = "SELECT * FROM course_registeration_requests WHERE id = $id";
$result = mysqli_query($connection, $query);
$request = mysqli_fetch_assoc($result);
$studentId = $request["student_id"];
$courses = json_decode($request["courses"], true); // Parse courses to JSON

// Check if courses is an array
if (is_array($courses)) {
    // Insert each course into the student_courses table
    foreach ($courses as $course) {
        // Ensure courseId is a valid integer
        $courseId = (int) $course['id'];
        $insertQuery = "INSERT INTO student_courses (student_id, course_id) VALUES ($studentId, $courseId)";
        mysqli_query($connection, $insertQuery);
    }

    // Check for errors
    if (mysqli_error($connection)) {
        echo json_encode([
            "success" => false,
            "message" => "Error inserting courses: " . mysqli_error($connection),
        ]);
    } else {
        // Delete the course registration request
        $updateQuery = "UPDATE course_registeration_requests SET status = 1 WHERE id = $id";
        mysqli_query($connection, $updateQuery);

// Check for errors in the update
        if (mysqli_error($connection)) {
            echo json_encode([
                "success" => false,
                "message" => "Error updating request status: " . mysqli_error($connection),
            ]);
        } else {
            echo json_encode([
                "success" => true,
                "message" => "Courses successfully registered and request status updated",
            ]);
        }
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid courses data",
    ]);
}
