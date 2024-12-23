<?php
require "../../config/config.php";

$id = $_POST["id"];

$query = "SELECT * from course_registeration_requests WHERE student_id = $id AND status = 1";

$result = mysqli_query($connection, $query);

$request = mysqli_fetch_assoc($result);

echo json_encode(
    array(

        "success" => true,
        "request" => $request,
    )
);
