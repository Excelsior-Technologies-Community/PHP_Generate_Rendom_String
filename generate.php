<?php
function generateRandomAlphanumeric($length = 10, $special = false) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if ($special) {
        $characters .= '!@#$%^&*()-_=+[]{}<>?';
    }
    $random = '';
    for ($i = 0; $i < $length; $i++) {
        $random .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return $random;
}

function generateRandomSecure($length = 10) {
    return bin2hex(random_bytes($length / 2));
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $length = isset($_POST['length']) ? (int)$_POST['length'] : 10;
    $type = $_POST['type'] ?? 'alphanumeric';
    $count = isset($_POST['count']) ? (int)$_POST['count'] : 1;
    $special = isset($_POST['special']) && $_POST['special'] === 'true';

    if ($length <= 0 || $count <= 0) {
        echo "Invalid input";
        exit;
    }

    $results = [];
    for ($i = 0; $i < $count; $i++) {
        if ($type == 'alphanumeric') {
            $results[] = generateRandomAlphanumeric($length, $special);
        } elseif ($type == 'letters') {
            $results[] = generateRandomLetters($length);
        } elseif ($type == 'numbers') {
            $results[] = generateRandomNumbers($length);
        } elseif ($type == 'secure') {
            $results[] = generateRandomSecure($length);
        }
    }
    echo implode("\n", $results);
}