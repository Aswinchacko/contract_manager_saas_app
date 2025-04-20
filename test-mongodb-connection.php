<?php
require_once 'vendor/autoload.php';

try {
    // Create a new MongoDB client
    $client = new MongoDB\Client("mongodb://localhost:27017");
    
    // List all databases
    $databases = $client->listDatabases();
    
    echo "<h2>MongoDB Connection Test</h2>";
    echo "<p>Connection successful!</p>";
    echo "<h3>Available Databases:</h3>";
    echo "<ul>";
    foreach ($databases as $database) {
        echo "<li>" . $database->getName() . "</li>";
    }
    echo "</ul>";
} catch (Exception $e) {
    echo "<h2>MongoDB Connection Test</h2>";
    echo "<p style='color: red;'>Connection failed: " . $e->getMessage() . "</p>";
}
?> 