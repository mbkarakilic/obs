<?php
function cors()
{
    // Handle preflight requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, token, origin, accept');
        header('Access-Control-Allow-Credentials: true');
        exit(0);
    }

    // Set CORS headers for actual requests
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, token, origin, accept');
    header('Access-Control-Allow-Credentials: true');

    // Handle the actual request here
}

cors();