<?php

// ------------------------------------------
// Functions
// ------------------------------------------
function generateRandomString1($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function generateRandomString2($length = 10)
{
    return bin2hex(random_bytes($length));
}

function generateRandomLetters($length = 8)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $random = '';
    for ($i = 0; $i < $length; $i++) {
        $random .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return $random;
}

function generateRandomNumbers($length = 6)
{
    $numbers = '0123456789';
    $random = '';
    for ($i = 0; $i < $length; $i++) {
        $random .= $numbers[random_int(0, strlen($numbers) - 1)];
    }
    return $random;
}

// ------------------------------------------
// Custom Generator Logic
// ------------------------------------------
$customString = '';

$lengthValue = $_POST['length'] ?? '';
$typeValue   = $_POST['type'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $length = $_POST['length'];
    $type   = $_POST['type'];

    if ($type == 'alphanumeric') {
        $customString = generateRandomString1($length);
    } elseif ($type == 'letters') {
        $customString = generateRandomLetters($length);
    } elseif ($type == 'numbers') {
        $customString = generateRandomNumbers($length);
    } elseif ($type == 'secure') {
        $customString = generateRandomString2($length);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Generate Random String in PHP</title>
    <style>
        body {
            margin: 0;
            padding: 40px 0;
            display: flex;
            justify-content: center;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .card {
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 500px;
            width: 90%;
        }

        h2 { margin-bottom: 20px; color: #333; }
        p { font-size: 16px; margin: 10px 0; }

        strong {
            color: #667eea;
            font-family: monospace;
        }

        input, select {
            padding: 8px;
            margin: 5px;
        }

        button {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="card">
    <h2>PHP Random String Generator</h2>

    <!-- Default Examples -->
    <p>1. Simple: <strong><?php echo generateRandomString1(10); ?></strong></p>
    <p>2. Secure Hex: <strong><?php echo generateRandomString2(20); ?></strong></p>
    <p>3. Letters: <strong><?php echo generateRandomLetters(8); ?></strong></p>
    <p>4. Numbers: <strong><?php echo generateRandomNumbers(6); ?></strong></p>

    <hr>

    <h3>Custom Generator</h3>

    <!-- FORM -->
    <form method="POST">
        <input type="number" name="length" placeholder="Length"
               value="<?php echo $lengthValue; ?>" required>

        <select name="type">
            <option value="alphanumeric" <?php if($typeValue=='alphanumeric') echo 'selected'; ?>>Alphanumeric</option>
            <option value="letters" <?php if($typeValue=='letters') echo 'selected'; ?>>Letters</option>
            <option value="numbers" <?php if($typeValue=='numbers') echo 'selected'; ?>>Numbers</option>
            <option value="secure" <?php if($typeValue=='secure') echo 'selected'; ?>>Secure</option>
        </select>

        <button type="submit" style="background:#667eea;">Generate</button>
    </form>

    <!-- RESULT -->
    <?php if($customString): ?>
        <p>
            Result:
            <strong id="result"><?php echo $customString; ?></strong>
        </p>

        <button onclick="copyText()" style="background:#28a745;">Copy</button>
        <button onclick="regenerate()" style="background:#ff9800;">Regenerate</button>

        <p id="msg" style="color:green;"></p>
    <?php endif; ?>
</div>

<script>
function copyText() {
    let text = document.getElementById("result").innerText;
    navigator.clipboard.writeText(text);
    document.getElementById("msg").innerText = "Copied!";
}

function regenerate() {
    let length = document.querySelector('input[name="length"]').value;
    let type = document.querySelector('select[name="type"]').value;

    fetch('generate.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `length=${length}&type=${type}`
    })
    .then(res => res.text())
    .then(data => {
        document.getElementById("result").innerText = data;
        document.getElementById("msg").innerText = "New string generated!";
    });
}
</script>

</body>
</html>