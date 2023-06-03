<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Check if the file was uploaded successfully
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["file"])) {
    $file = $_FILES["file"];

    // Check if there was no upload error
    if ($file["error"] === UPLOAD_ERR_OK) {
        $uploadDir = "./new_lists/";
        $uploadPath = $uploadDir . basename($file["name"]);
        $fileType = strtolower(pathinfo($uploadPath, PATHINFO_EXTENSION));
        $uniqueFilename = uniqid() . '_' . time() . '.' . $fileType;
        $uploadPath = $uploadDir . $uniqueFilename;
	
	    // Check if the file is a TXT file
        if ($fileType === "txt") {
            // Move the uploaded file to the destination directory
            if (move_uploaded_file($file["tmp_name"], $uploadPath)) {
	            chmod($uploadPath, 0777); // Set file permission to 777
                // Read the JSON data from the uploaded file
                    //$jsonData = $file["tmp_name"];
                // Parse the JSON data
                    //$parsedData = json_decode($jsonData, true);
                // Convert the decoded data to plain text line by line
                    //$plainTextLines = '';
                    //foreach ($parsedData as $line) {
                    //   $plainTextLines .= $line . "\n";
                    //}
                // Save the plain text content to the upload path
                    //  file_put_contents($uploadPath, $plainTextLines);
		        echo "File uploaded successfully.";
            } else {
                echo "Failed to move the uploaded file.";
            }
        } else {
            echo "Only TXT files are allowed.";
        }
    } else {
        echo "Upload failed with error code: " . $file["error"];
    }
} else {
    echo "No file was uploaded.";
}
?>

