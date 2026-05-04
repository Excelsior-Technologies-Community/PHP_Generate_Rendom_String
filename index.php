<?php

// 1. Secure Random Generator Function (Updated with random_int)
function generateAdvancedString($length = 10, $type = 'alphanumeric', $includeSpecial = false)
{
    if ($type === 'secure') {
        return bin2hex(random_bytes($length / 2));
    }

    $chars = '';
    if ($type === 'letters') {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    } elseif ($type === 'numbers') {
        $chars = '0123456789';
    } else {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }

    if ($includeSpecial) {
        $chars .= '!@#$%^&*()-_=+[]{}<>?';
    }

    $str = '';
    $max = strlen($chars) - 1;
    for ($i = 0; $i < $length; $i++) {
        $str .= $chars[random_int(0, $max)];
    }
    return $str;
}

// 2. Logic to handle POST requests (Regular and AJAX)
$customStrings = [];
$lengthValue = $_POST['length'] ?? 10;
$typeValue   = $_POST['type'] ?? 'alphanumeric';
$countValue  = $_POST['count'] ?? 1;
$specialChecked = isset($_POST['special']) ? 'checked' : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $len = (int)$lengthValue;
    $cnt = (int)$countValue;
    $special = isset($_POST['special']);

    for ($i = 0; $i < $cnt; $i++) {
        $customStrings[] = generateAdvancedString($len, $typeValue, $special);
    }

    // If it's an AJAX request (Regenerate button)
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
        echo implode("\n", $customStrings);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="gu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Advanced Random Generator</title>
    <style>
        body {
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
        }

        .card {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            text-align: center;
            width: 100%;
            max-width: 550px;
            box-sizing: border-box;
        }

        h2 { color: #333; margin-top: 0; }
        
        .form-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            margin-bottom: 20px;
        }

        input, select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            outline: none;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
            margin-bottom: 15px;
            cursor: pointer;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-generate { background: #667eea; width: 100%; font-size: 16px; }
        .btn-generate:hover { background: #5a67d8; }
        
        .result-container {
            margin-top: 25px;
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            border: 1px solid #eee;
            max-height: 300px;
            overflow-y: auto;
        }

        .result-item {
            display: block;
            word-break: break-all; /* આ પ્રોપર્ટી લેઆઉટ બચાવશે */
            font-family: 'Courier New', monospace;
            background: #fff;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border-left: 4px solid #667eea;
            text-align: left;
            font-size: 15px;
        }

        .action-btns {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-copy { background: #28a745; flex: 1; }
        .btn-regen { background: #ff9800; flex: 1; }
        
        #msg { margin-top: 10px; font-size: 14px; font-weight: bold; }

        hr { border: 0; border-top: 1px solid #eee; margin: 25px 0; }
    </style>
</head>
<body>

<div class="card">
    <h2>PHP Random Generator</h2>

    <form method="POST" id="genForm">
        <div class="form-group">
            <input type="number" name="length" placeholder="Length" value="<?php echo $lengthValue; ?>" min="1" style="width: 80px;" required>
            <input type="number" name="count" placeholder="Bulk" value="<?php echo $countValue; ?>" min="1" style="width: 80px;" title="How many strings?">
            
            <select name="type">
                <option value="alphanumeric" <?php echo $typeValue=='alphanumeric'?'selected':''; ?>>Mixed (A-z, 0-9)</option>
                <option value="letters" <?php echo $typeValue=='letters'?'selected':''; ?>>Letters Only</option>
                <option value="numbers" <?php echo $typeValue=='numbers'?'selected':''; ?>>Numbers Only</option>
                <option value="secure" <?php echo $typeValue=='secure'?'selected':''; ?>>Secure Hex</option>
            </select>
        </div>

        <label class="checkbox-container">
            <input type="checkbox" name="special" <?php echo $specialChecked; ?>> Include Special Characters (!@#$...)
        </label>

        <button type="submit" class="btn-generate">Generate Strings</button>
    </form>

    <?php if (!empty($customStrings)): ?>
        <div class="result-container" id="resultBox">
            <?php foreach ($customStrings as $str): ?>
                <div class="result-item"><?php echo htmlspecialchars($str); ?></div>
            <?php endforeach; ?>
        </div>

        <div class="action-btns">
            <button onclick="copyAll()" class="btn-copy">Copy All</button>
            <button onclick="regenerate()" class="btn-regen">Regenerate</button>
        </div>
        <div id="msg"></div>
    <?php endif; ?>
</div>

<script>
function copyAll() {
    const items = document.querySelectorAll('.result-item');
    const textToCopy = Array.from(items).map(div => div.innerText).join('\n');
    
    navigator.clipboard.writeText(textToCopy).then(() => {
        const msg = document.getElementById("msg");
        msg.innerText = "Copied to Clipboard!";
        msg.style.color = "#28a745";
        setTimeout(() => msg.innerText = "", 2000);
    });
}

function regenerate() {
    const form = document.getElementById('genForm');
    const formData = new FormData(form);
    
    // AJAX call
    fetch(window.location.href, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.text())
    .then(data => {
        const resultBox = document.getElementById("resultBox");
        resultBox.innerHTML = "";
        
        data.split('\n').forEach(str => {
            if(str.trim()) {
                const div = document.createElement('div');
                div.className = 'result-item';
                div.innerText = str;
                resultBox.appendChild(div);
            }
        });

        const msg = document.getElementById("msg");
        msg.innerText = "New batch generated!";
        msg.style.color = "#ff9800";
        setTimeout(() => msg.innerText = "", 2000);
    });
}
</script>

</body>
</html>