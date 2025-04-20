<?php
require_once '../includes/config.php';
requireAuth();

header('Content-Type: application/json');

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

// Validate required fields
if (empty($data['name']) || empty($data['email'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Name and email are required fields'
    ]);
    exit;
}

// Prepare client data
$clientData = [
    'user_id' => $_SESSION['user_id'],
    'name' => sanitizeInput($data['name']),
    'company' => sanitizeInput($data['company'] ?? ''),
    'email' => sanitizeInput($data['email']),
    'phone' => sanitizeInput($data['phone'] ?? ''),
    'address' => sanitizeInput($data['address'] ?? ''),
    'tax_id' => sanitizeInput($data['tax_id'] ?? ''),
    'created_at' => new MongoDB\BSON\UTCDateTime(),
    'updated_at' => new MongoDB\BSON\UTCDateTime()
];

try {
    // Insert client into database
    $result = $clients->insertOne($clientData);
    
    if ($result->getInsertedId()) {
        echo json_encode([
            'success' => true,
            'message' => 'Client created successfully',
            'client_id' => (string)$result->getInsertedId()
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to create client'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error creating client: ' . $e->getMessage()
    ]);
} 