<?php
header('Content-Type: application/json; charset=utf-8');
$conn = mysqli_connect('localhost', 'root', '', 'store');

function msg($msg, $code) {
    echo json_encode($msg);
    http_response_code($code);
}