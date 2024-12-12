<?php
require "../../config/config.php";

// Akademisyenleri ve departman adlarını al
$query = "
SELECT 
    a.*, 
    d.name AS department_name
FROM 
    academics a
JOIN 
    departments d ON a.department_id = d.id";

$result = mysqli_query($connection, $query);
$academicians = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($result) {
    // Akademisyenlerin derslerini al
    $coursesQuery = "
    SELECT
        ac.academic_id,
        c.name AS course_name
    FROM
        academics_courses ac
    JOIN
        courses c ON ac.course_id = c.id";

    $coursesResult = mysqli_query($connection, $coursesQuery);
    $academics_courses = mysqli_fetch_all($coursesResult, MYSQLI_ASSOC);

    // Sonuçları JSON olarak hazırla
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
