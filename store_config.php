<?php
    // Get the JSON data from the request
    $jsonData = $_POST['wordData'];

    // Create the configs folder if it doesn't exist
    $folderPath = './configs/';
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true);
    }

    // Generate a unique filename for the config file
    $fileName = uniqid('config_') . '.json';

    // Path to the config file
    $filePath = $folderPath . $fileName;

    // Write the wordData to the config file
    file_put_contents($filePath, json_encode($jsonData, JSON_PRETTY_PRINT));

    // Clear the wordData contents
    $wordData = [];

    // Send a success response
    echo json_encode(array('success' => true));
?>
