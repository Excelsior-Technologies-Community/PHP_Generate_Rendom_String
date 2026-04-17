<?php

function generateRandomString1($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $random = '';
    for ($i = 0; $i < $length; $i++) {
        $random .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $random;
}

function generateRandomString2($length = 10) {
    return bin2hex(random_bytes($length));
}

function generateRandomLetters($length = 8) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $random = '';
    for ($i = 0; $i < $length; $i++) {
        $random .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return $random;
}

function generateRandomNumbers($length = 6) {
    $numbers = '0123456789';
    $random = '';
    for ($i = 0; $i < $length; $i++) {
        $random .= $numbers[random_int(0, strlen($numbers) - 1)];
    }
    return $random;
}

//  FIXED PART
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Convert to integer safely
    $length = isset($_POST['length']) ? (int)$_POST['length'] : 0;
    $type   = $_POST['type'] ?? '';

    // Validate input
    if ($length <= 0) {
        echo "Invalid length";
        exit;
    }

    // Generate based on type
    if ($type == 'alphanumeric') {
        echo generateRandomString1($length);
    } elseif ($type == 'letters') {
        echo generateRandomLetters($length);
    } elseif ($type == 'numbers') {
        echo generateRandomNumbers($length);
    } elseif ($type == 'secure') {
        echo generateRandomString2($length);
    } else {
        echo "Invalid type";
    }
}