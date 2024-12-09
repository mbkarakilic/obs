<?php
//Connection to Database
$connection = mysqli_connect("localhost", "admin", "12345", "obs");

mysqli_set_charset($connection, "utf8mb4");

if (!$connection) {
    echo "Connection Error" . mysqli_connect_error();
}