<?php
header("Content-Type: application/json");

/* Database Connection */
$dsn = 'mysql:host=localhost;dbname=csci6040_study';
$username = 'root';
$password = '';

$options = [
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
PDO::ATTR_EMULATE_PREPARES => false,
];

try {
$pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
http_response_code(500);
echo json_encode([
"status" => false,
"message" => "Database connection failed"
]);
exit;
}

/* Allow only POST */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => false,
        "message" => "Only POST method allowed"
    ]);
    exit;
}

/* Check file upload */
if (!isset($_FILES['file'])) {
    echo json_encode([
        "status" => false,
        "message" => "No file uploaded"
    ]);
    exit;
}

$file = $_FILES['file'];

/* Validate CSV */
$fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if ($fileExtension !== 'csv') {
    echo json_encode([
        "status" => false,
        "message" => "Only CSV files are allowed"
    ]);
    exit;
}

/* Open CSV file */
$handle = fopen($file['tmp_name'], "r");

if (!$handle) {
    echo json_encode([
        "status" => false,
        "message" => "Unable to read file"
    ]);
    exit;
}

$data = [];
$rowNumber = 0;
$inserted = 0;

/* Read CSV */
while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {

    $rowNumber++;

    // Skip empty rows
    if (count($row) < 3) {
        continue;
    }

    // Skip header row
    if ($rowNumber == 1 && strtolower($row[0]) == 'name') {
        continue;
    }

    $name = trim($row[0]);
    $email = trim($row[1]);
    $password = trim($row[2]);

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert into database
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $hashedPassword]);

    $inserted++;

    $data[] = [
        "name" => $name,
        "email" => $email,
        "password" => $hashedPassword
    ];
}

fclose($handle);

/* Response */
echo json_encode([
    "status" => true,
    "message" => "CSV processed successfully",
    "total_records" => count($data),
    "total_inserted" => $data
]);
?>