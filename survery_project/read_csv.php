<?php
header("Content-Type: application/json");

// Allow only POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => false,
        "message" => "Only POST method allowed"
    ]);
    exit;
}

// Check file upload
if (!isset($_FILES['file'])) {
    echo json_encode([
        "status" => false,
        "message" => "No file uploaded"
    ]);
    exit;
}

$file = $_FILES['file'];

// Validate file type (basic check)
$fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if ($fileExtension !== 'csv') {
    echo json_encode([
        "status" => false,
        "message" => "Only CSV files are allowed"
    ]);
    exit;
}

// Open CSV file
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

// Read CSV
while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {

    $rowNumber++;

    // Skip empty rows
    if (count($row) < 3) {
        continue;
    }
    
    $wrong_answers = [];
    for ($i = 2; $i < count($row); $i++) {
        if (!empty(trim($row[$i]))) {
            $wrong_answers[] = trim($row[$i]);
        }
    }

    $data[] = [
        "question" => trim($row[0]),
        "correct answer" => trim($row[1]),
        "wrong answer"=> $wrong_answers
    ];
}

fclose($handle);

// Output JSON
echo json_encode([
    "status" => true,
    "message" => "CSV processed successfully",
    "total_records" => count($data),
    "data" => $data
]);