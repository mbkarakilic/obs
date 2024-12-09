<?php
require "../../config/config.php";

$id = $_POST["id"];

$query = "
    SELECT
        *
    FROM
        academics
    WHERE
        department_id = $id
";

$result = mysqli_query($connection, $query);
$academicians = mysqli_fetch_all($result, MYSQLI_ASSOC);

$requestResult = array(
    "success" => $result ? true : false,
    "academicians" => $academicians,
);

echo json_encode($requestResult);
