<?php
// Set the target directory
$uploadDir = './uploads/';

// Create the directory if it doesn't exist
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Check if a file was submitted
if (isset($_FILES['file'])) {
    $file = $_FILES['file'];

    // Check if there are no errors during file upload
    if ($file['error'] === UPLOAD_ERR_OK) {
        $tempName = $file['tmp_name'];
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

        // Generate a random name for the file
        $randomName = generateRandomName(12) . '.' . $extension;

        // Move the uploaded file to the target directory
        $targetPath = $uploadDir . $randomName;
        move_uploaded_file($tempName, $targetPath);

        echo 'File uploaded successfully as: ' . $randomName;
    } else {
        echo 'File upload failed with error code: ' . $file['error'];
    }
}

// Function to generate a random name
function generateRandomName($length) {
    $characters = '0123456789';
    $name = '';
    for ($i = 0; $i < $length; $i++) {
        $name .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $name;
}
?>
