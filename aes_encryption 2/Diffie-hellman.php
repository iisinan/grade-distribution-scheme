<?php

$primeNumber = '';
$primitiveRoot = '';
$instructorPrivateKey = '';
$instructorPublicKey = '';
$receivedStaffPublicKey = '15'; 
$receivedStudentPublicKey = '18'; 
$sharedKeyStaff = '';
$sharedKeyStudent = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $primeNumber = isset($_POST["primeNumber"]) ? $_POST["primeNumber"] : '';
    $primitiveRoot = isset($_POST["primitiveRoot"]) ? $_POST["primitiveRoot"] : '';

    
    $instructorPrivateKey = isset($_POST["instructorPrivateKey"]) ? $_POST["instructorPrivateKey"] : '';
    $instructorPublicKey = bcpowmod($primitiveRoot, $instructorPrivateKey, $primeNumber);

    
    $sharedKeyStaff = bcpowmod($receivedStaffPublicKey, $instructorPrivateKey, $primeNumber);
    $sharedKeyStudent = bcpowmod($receivedStudentPublicKey, $instructorPrivateKey, $primeNumber);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Moodle-Like Plugin Interface</title> <style> body { font-family: 'Arial', sans-serif; background-color: #f2f2f2; margin: 20px; } .container { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); } label { display: block; margin-bottom: 10px; font-weight: bold; } input { width: 100%; padding: 10px; margin-bottom: 20px; box-sizing: border-box; } button { padding: 10px 20px; background-color: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer; } button:hover { background-color: #0056b3; } p { margin-top: 20px; } </style>
    <style>
       
    </style>
</head>
<body>
    <div class="container">
        <h1>Instructor: Ismaila Idris</h1>

        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="primeNumber">Prime Number:</label>
            <input type="text" name="primeNumber" value="<?php echo htmlspecialchars($primeNumber); ?>" required>

            <label for="primitiveRoot">Primitive Root:</label>
            <input type="text" name="primitiveRoot" value="<?php echo htmlspecialchars($primitiveRoot); ?>" required>

            
            <label for="instructorPrivateKey">Instructor's Private Key:</label>
            <input type="text" name="instructorPrivateKey" value="<?php echo htmlspecialchars($instructorPrivateKey); ?>" required>

            <button type="submit" name="calculatePublicKey">Calculate Public Key</button>
        </form>

       
        <?php if (!empty($instructorPublicKey)) : ?>
            <p><strong>Instructor's Calculated Public Key:</strong> <?php echo $instructorPublicKey; ?></p>
        <?php endif; ?>

       
        <p><strong>Staff's Public Key:</strong> <?php echo $receivedStaffPublicKey; ?></p>
        <p><strong>Student's Public Key:</strong> <?php echo $receivedStudentPublicKey; ?></p>

       
        <?php if (!empty($sharedKeyStaff) || !empty($sharedKeyStudent)) : ?>
            <div class="shared-keys">
                <h2>Shared Secret Keys:</h2>
                <p><strong>Shared Key with Staff:</strong> <?php echo $sharedKeyStaff; ?></p>
                <p><strong>Shared Key with Student:</strong> <?php echo $sharedKeyStudent; ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
