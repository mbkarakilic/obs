<?php
require "../../config/config.php";

$query = "
    SELECT 
        students.*, 
        departments.name AS department_name 
    FROM 
        students 
    JOIN 
        departments 
    ON 
        students.department_id = departments.id
";

$result = mysqli_query($connection, $query);
$students = mysqli_fetch_all($result, MYSQLI_ASSOC);

$requestResult = array(
    "success" => $result ? true : false,
    "students" => $students,
);

echo json_encode($requestResult);
