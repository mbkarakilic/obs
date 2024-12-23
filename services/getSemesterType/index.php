<?php

require "../../config/config.php";

// Veritabanında sorgulama yap
$query = "SELECT value FROM settings WHERE `key` = 'semester_type'";
$result = mysqli_query($connection, $query);
$semesterType = mysqli_fetch_assoc($result)["value"];

// Sonuçları kontrol et
if ($result && mysqli_num_rows($result) > 0) {
    echo json_encode([
        "success" => true,
        "semester_type" => $semesterType,
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "hata",
    ]);
}