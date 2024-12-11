<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = '127.0.0.1';
$user = 'root';
$password = "";
$dbname = 'bingo_game';

// Establish database connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Extract and validate input data
    $participant_name = $conn->real_escape_string($_POST['participant_name'] ?? '');
    $time_taken = (int)($_POST['time_taken'] ?? 0);
    $score = (int)($_POST['score'] ?? 0);
    $bingo_word = $conn->real_escape_string($_POST['bingo_word'] ?? '');

    if ($participant_name && $time_taken && $score && $bingo_word) {
        // Insert into database
        $sql = "INSERT INTO bingo_results (participant_name, time_taken, score, bingo_word) 
                VALUES ('$participant_name', $time_taken, $score, '$bingo_word')";

        if ($conn->query($sql) === TRUE) {
            echo "Record saved successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Invalid input data";
    }
}

$conn->close();
?>
