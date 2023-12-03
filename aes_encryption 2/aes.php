<?php

function encryptData($data, $key) {
    
    $iv = random_bytes(16); 
    $cipherText = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);

   
    return base64_encode($iv . $cipherText);
}


function calculateMIC($data) {
   
    return hash('sha256', $data);
}



$originalData = '';
$studentEncryptedData = '';
$staffEncryptedData = '';
$studentMIC = '';
$staffMIC = '';
$micMatch = false;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $originalData = isset($_POST["originalData"]) ? $_POST["originalData"] : '';

   
    if (isset($_POST["encryptStudent"])) {
       
        $studentEncryptedData = encryptData($originalData, $encryptionKey);
        
        $studentMIC = calculateMIC($studentEncryptedData);
    } elseif (isset($_POST["encryptStaff"])) {
       
        $staffEncryptedData = encryptData($originalData, $encryptionKey);
        
        $staffMIC = calculateMIC($staffEncryptedData);
    } elseif (isset($_POST["compareMIC"])) {
        
        $micMatch = ($studentMIC === $staffMIC);
    } elseif (isset($_POST["publishCiphertext"])) {
        
        echo "Ciphertext and MIC value published!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moodle-Like Plugin Interface</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f2f2f2;
            margin: 20px;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        p {
            margin-top: 20px;
        }
    </style>
</head>
</head>
<body>
    <div class="container">
        <h1>Instructor: Ismaila Idris</h1>

      
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="originalData">Original Data:</label>
            <input type="text" name="originalData" value="<?php echo htmlspecialchars($originalData); ?>" required>

            <button type="submit" name="encryptStudent">Encrypt for Student</button>
            <button type="submit" name="encryptStaff">Encrypt for Staff</button>
            <button type="submit" name="compareMIC">Compare MIC</button>
            <button type="submit" name="publishCiphertext" <?php echo ($micMatch) ? '' : 'disabled'; ?>>
                Publish Ciphertext and MIC Value
            </button>

            
            <?php if (!empty($studentEncryptedData) && !empty($studentMIC)) : ?>
                <p><strong>Encrypted Data (Student):</strong> <?php echo htmlspecialchars($studentEncryptedData); ?></p>
                <p><strong>MIC (Student):</strong> <?php echo htmlspecialchars($studentMIC); ?></p>
            <?php endif; ?>

            
            <?php if (!empty($staffEncryptedData) && !empty($staffMIC)) : ?>
                <p><strong>Encrypted Data (Staff):</strong> <?php echo htmlspecialchars($staffEncryptedData); ?></p>
                <p><strong>MIC (Staff):</strong> <?php echo htmlspecialchars($staffMIC); ?></p>
            <?php endif; ?>

            
            <?php if ($micMatch) : ?>
                <p><strong>MIC Match:</strong> The MIC values match.</p>
            <?php elseif ($studentMIC !== '' && $staffMIC !== '') : ?>
                <p><strong>MIC Mismatch:</strong> The MIC values do not match.</p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
