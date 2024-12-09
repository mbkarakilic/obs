<?php

require "../../config/config.php";

$id = $_POST["course_id"];

$query = "
SELECT
    sc.student_id,
    s.name AS student_name,
    s.surname AS student_surname,
    s.username AS student_username,
    c.name AS course_name
FROM
    student_courses sc
JOIN
    students s ON sc.student_id = s.id
JOIN
    courses c ON sc.course_id = c.id
WHERE
    sc.course_id = $id;
";

$result = mysqli_query($connection, $query);

if ($result) {
    $students = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(array(
        "success" => true,
        "students" => $students,
    )
    );
} else {
    echo json_encode(array(
        "success" => true,
    )
    );
}
