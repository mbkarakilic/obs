<?php
require "../../config/config.php";

$id = $_POST["id"];

$q1 = "SELECT department_id, semester FROM STUDENTS WHERE id = $id";
$r1 = mysqli_query($connection, $q1);
$user = mysqli_fetch_assoc($r1);
$department = $user["department_id"];
$semester = $user["semester"];

$q2 = "SELECT course_id FROM student_courses WHERE student_id = $id";
$r2 = mysqli_query($connection, $q2);
$registeredCourses = mysqli_fetch_all($r2, MYSQLI_ASSOC);

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
    WHERE
        courses.department_id = $department
";
# AND (courses.semester = $semester OR courses.semester = $semester + 2 OR courses.semester = $semester + 4 OR courses.semester = $semester + 6)
$result = mysqli_query($connection, $query);
$courses = mysqli_fetch_all($result, MYSQLI_ASSOC);

$registeredCourseIds = array_column($registeredCourses, 'course_id');
$unregisteredCourses = array_values(array_filter($courses, function ($course) use ($registeredCourseIds) {
    return !in_array($course['id'], $registeredCourseIds);
}));

$requestResult = array(
    "success" => $result ? true : false,
    "courses" => $unregisteredCourses,
    "department" => $department,
);

echo json_encode($requestResult);
