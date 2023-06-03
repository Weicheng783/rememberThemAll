<?php
// Get the argument passed from JavaScript
$argument = $_GET['arg'];

// Execute the Python script with the argument
$command = "python3 fast_track.py " . escapeshellarg($argument);
$output = shell_exec($command);

// Print the output of the Python script
echo $output;
?>
