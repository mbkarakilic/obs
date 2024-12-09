<?php
require "../../config/config.php";

$query = "SELECT * FROM departments";
$result = mysqli_query($connection, $query);
$departments = mysqli_fetch_all($result, MYSQLI_ASSOC);

$requestResult = array(
    "success" => $result ? true : false,
    "departments" => $departments,
);

echo json_encode($requestResult);
