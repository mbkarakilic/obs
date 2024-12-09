<?php

require "../../config/config.php";

$id = (int) $_POST["courseId"];

$query = "DELETE FROM courses WHERE id = $id";

$result = mysqli_query($connection, $query);

$res = array(
    "success" => $result ? true : false,
);

echo json_encode($res);
