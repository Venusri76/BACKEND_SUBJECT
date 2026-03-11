<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv'])) {

    $file = $_FILES['csv'];
    $handle = fopen($file['tmp_name'], "r");

    if (!$handle) {
        echo "Unable to read file";
        exit;
    }

    $data = [];
    $rowNumber = 0;

    // Read CSV
    while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {

        $rowNumber++;

        if (count($row) < 3) {
            continue;
        }

        $data[] = [
            "question" => trim($row[0]),
            "correct"  => trim($row[1]),
            "wrong"    => trim($row[2])
        ];
    }

    fclose($handle);

    // OUTPUT HTML
    echo "<form>";

    foreach ($data as $index => $q) {

        echo "<div style='margin-bottom:20px;'>";

        echo "<p><strong>Q" . ($index+1) . ". " . htmlspecialchars($q['question']) . "</strong></p>";

        // Radio buttons
        echo "<label>
                <input type='radio' name='q$index' value='".$q['correct']."'>
                ".$q['correct']."
              </label><br>";

        echo "<label>
                <input type='radio' name='q$index' value='".$q['wrong']."'>
                ".$q['wrong']."
              </label>";

        echo "</div>";
    }

    echo "<button type='submit'>Submit</button>";
    echo "</form>";
}
?>