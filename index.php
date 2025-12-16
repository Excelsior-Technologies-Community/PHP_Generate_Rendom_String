<?php
/*
|--------------------------------------------------------------------------
| Random String Generator Example
|--------------------------------------------------------------------------
| This script shows how to generate random strings using different methods
| in PHP similar to the reference.
| https://www.itsolutionstuff.com/post/how-to-generate-random-string-in-phpexample.html
*/

// ------------------------------------------
// 1. Method: Simple random string using range
// ------------------------------------------
function generateRandomString1($length = 10)
{
    // Characters we want to include
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    // Loop to generate random characters
    for ($i = 0; $i < $length; $i++) {
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    }

    return $randomString;
}

// ----------------------------------------------------
// 2. Method: Stronger Random (Using PHP built‑in function)
// ----------------------------------------------------
function generateRandomString2($length = 10)
{
    // PHP function random_bytes generates secure bytes
    $bytes = random_bytes($length);

    // Convert bytes to hex
    return bin2hex($bytes);
}

// -------------------------------------------------------------
// 3. Method: Random String (Only Letters)
// -------------------------------------------------------------
function generateRandomLetters($length = 8)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $random = '';
    for ($i = 0; $i < $length; $i++) {
        $random .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return $random;
}

// -------------------------------------------------------------
// 4. Method: Random Numeric String
// -------------------------------------------------------------
function generateRandomNumbers($length = 6)
{
    $numbers = '0123456789';
    $random = '';
    for ($i = 0; $i < $length; $i++) {
        $random .= $numbers[random_int(0, strlen($numbers) - 1)];
    }
    return $random;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Generate Random String in PHP</title>
    <style>
        /* Full width body with top-aligned content */
        body {
            margin: 0;
            padding: 40px 0;
            display: flex;
            justify-content: center; /* Horizontal center */
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        /* Card style */
        .card {
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 500px;
            width: 90%;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        p {
            font-size: 16px;
            margin: 10px 0;
        }

        strong {
            color: #667eea;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>PHP Random String Generator</h2>

        <!-- Show random strings using functions -->
        <p>1. Simple Random String (10 chars): <strong><?php echo generateRandomString1(10); ?></strong></p>
        <p>2. Strong Random Hex String (20 bytes → 40 hex chars): <strong><?php echo generateRandomString2(20); ?></strong></p>
        <p>3. Random Letters Only (8 chars): <strong><?php echo generateRandomLetters(8); ?></strong></p>
        <p>4. Random Numbers Only (6 digits): <strong><?php echo generateRandomNumbers(6); ?></strong></p>
    </div>
</body>
</html>
