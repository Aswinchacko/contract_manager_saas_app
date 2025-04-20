<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// MongoDB Connection Settings
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->contract_manager;

// Collections
$users = $database->users;
$contracts = $database->contracts;
$clients = $database->clients;
$templates = $database->templates;

// Application Settings
define('APP_NAME', 'Contract Manager');
define('APP_URL', 'http://localhost/sample');
define('SUBSCRIPTION_PRICE', 99); // Monthly subscription price in USD
define('TRIAL_DAYS', 10); // Free trial period in days

// Helper Functions
function isAuthenticated() {
    return isset($_SESSION['user_id']);
}

function requireAuth() {
    if (!isAuthenticated()) {
        header('Location: login.php');
        exit();
    }
}

function redirect($path) {
    header('Location: ' . $path);
    exit();
}

// Error Handling
function handleError($error) {
    error_log($error);
    // You might want to implement more sophisticated error handling
    return false;
}

// Security Functions
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function generateToken() {
    return bin2hex(random_bytes(32));
}

// MongoDB Helper Functions
function findUser($email) {
    global $users;
    return $users->findOne(['email' => $email]);
}

function createUser($userData) {
    global $users;
    try {
        $result = $users->insertOne($userData);
        return $result->getInsertedId();
    } catch (Exception $e) {
        return handleError($e->getMessage());
    }
}

function updateUser($userId, $updateData) {
    global $users;
    try {
        $result = $users->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($userId)],
            ['$set' => $updateData]
        );
        return $result->getModifiedCount() > 0;
    } catch (Exception $e) {
        return handleError($e->getMessage());
    }
}

// Contract Functions
function createContract($contractData) {
    global $contracts;
    try {
        $result = $contracts->insertOne($contractData);
        return $result->getInsertedId();
    } catch (Exception $e) {
        return handleError($e->getMessage());
    }
}

function getContract($contractId) {
    global $contracts;
    try {
        return $contracts->findOne(['_id' => new MongoDB\BSON\ObjectId($contractId)]);
    } catch (Exception $e) {
        return handleError($e->getMessage());
    }
}

function updateContract($contractId, $updateData) {
    global $contracts;
    try {
        $result = $contracts->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($contractId)],
            ['$set' => $updateData]
        );
        return $result->getModifiedCount() > 0;
    } catch (Exception $e) {
        return handleError($e->getMessage());
    }
}

function deleteContract($contractId) {
    global $contracts;
    try {
        $result = $contracts->deleteOne(['_id' => new MongoDB\BSON\ObjectId($contractId)]);
        return $result->getDeletedCount() > 0;
    } catch (Exception $e) {
        return handleError($e->getMessage());
    }
}

// Client Functions
function createClient($clientData) {
    global $clients;
    try {
        $result = $clients->insertOne($clientData);
        return $result->getInsertedId();
    } catch (Exception $e) {
        return handleError($e->getMessage());
    }
}

function getClient($clientId) {
    global $clients;
    try {
        return $clients->findOne(['_id' => new MongoDB\BSON\ObjectId($clientId)]);
    } catch (Exception $e) {
        return handleError($e->getMessage());
    }
}

function updateClient($clientId, $updateData) {
    global $clients;
    try {
        $result = $clients->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($clientId)],
            ['$set' => $updateData]
        );
        return $result->getModifiedCount() > 0;
    } catch (Exception $e) {
        return handleError($e->getMessage());
    }
}

function deleteClient($clientId) {
    global $clients;
    try {
        $result = $clients->deleteOne(['_id' => new MongoDB\BSON\ObjectId($clientId)]);
        return $result->getDeletedCount() > 0;
    } catch (Exception $e) {
        return handleError($e->getMessage());
    }
}

// Template Functions
function getTemplates() {
    global $templates;
    try {
        return $templates->find()->toArray();
    } catch (Exception $e) {
        return handleError($e->getMessage());
    }
}

function getTemplate($templateId) {
    global $templates;
    try {
        return $templates->findOne(['_id' => new MongoDB\BSON\ObjectId($templateId)]);
    } catch (Exception $e) {
        return handleError($e->getMessage());
    }
}

function createTemplate($templateData) {
    global $templates;
    try {
        $result = $templates->insertOne($templateData);
        return $result->getInsertedId();
    } catch (Exception $e) {
        return handleError($e->getMessage());
    }
}

function updateTemplate($templateId, $updateData) {
    global $templates;
    try {
        $result = $templates->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($templateId)],
            ['$set' => $updateData]
        );
        return $result->getModifiedCount() > 0;
    } catch (Exception $e) {
        return handleError($e->getMessage());
    }
}

function deleteTemplate($templateId) {
    global $templates;
    try {
        $result = $templates->deleteOne(['_id' => new MongoDB\BSON\ObjectId($templateId)]);
        return $result->getDeletedCount() > 0;
    } catch (Exception $e) {
        return handleError($e->getMessage());
    }
}
?> 