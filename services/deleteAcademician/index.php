<?php

require "../../config/config.php";

$id = (int) $_POST["academicianId"];

$query = "DELETE FROM academics WHERE id = $id";

$result = mysqli_query($connection, $query);

$res = array(
    "success" => $result ? true : false,
);

echo json_encode($res);
