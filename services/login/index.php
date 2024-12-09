<?php

require "../../config/config.php";

$nationalId = $_POST['nationalId'];
$password = $_POST['password'];
$isStudent = $_POST['isStudent'] === "true";

$databaseName = $isStudent === true ? "students" : "academics";

$query = "SELECT * FROM $databaseName WHERE nationalId='$nationalId' AND password='$password'";

$result = mysqli_query($connection, $query);
$user = mysqli_fetch_assoc($result);

if ($user == null) {
    $query = "SELECT * FROM $databaseName WHERE username='$nationalId' AND password='$password'";

    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user == null) {
        $requestResult = array(
            "success" => false,
            "error" => "Invalid credentials inside",
        );
    } else {
        $requestResult = array(
            "success" => true,
            "user" => $user,
        );
    }
} else {
    $requestResult = array(
        "success" => true,
        "user" => $user,
    );
}
echo json_encode($requestResult);
