<?php
require_once 'config.php';

// Check if templates collection is empty
$templateCount = $templates->countDocuments();

if ($templateCount === 0) {
    // Basic Contract Template
    $basicTemplate = [
        'name' => 'Basic Contract',
        'description' => 'A simple contract template for basic freelance work',
        'content' => [
            'title' => 'Freelance Service Agreement',
            'parties' => [
                'freelancer' => [
                    'name' => '{{freelancer_name}}',
                    'email' => '{{freelancer_email}}',
                    'phone' => '{{freelancer_phone}}'
                ],
                'client' => [
                    'name' => '{{client_name}}',
                    'email' => '{{client_email}}',
                    'phone' => '{{client_phone}}'
                ]
            ],
            'scope' => '{{scope}}',
            'deliverables' => '{{deliverables}}',
            'payment_terms' => '{{payment_terms}}',
            'amount' => '{{amount}}',
            'start_date' => '{{start_date}}',
            'end_date' => '{{end_date}}',
            'terms' => [
                'confidentiality' => true,
                'intellectual_property' => true,
                'termination' => true
            ]
        ],
        'created_at' => new MongoDB\BSON\UTCDateTime(),
        'updated_at' => new MongoDB\BSON\UTCDateTime()
    ];

    // Premium Contract Template
    $premiumTemplate = [
        'name' => 'Premium Contract',
        'description' => 'A comprehensive contract template with advanced terms and conditions',
        'content' => [
            'title' => 'Professional Service Agreement',
            'parties' => [
                'freelancer' => [
                    'name' => '{{freelancer_name}}',
                    'email' => '{{freelancer_email}}',
                    'phone' => '{{freelancer_phone}}',
                    'address' => '{{freelancer_address}}',
                    'tax_id' => '{{freelancer_tax_id}}'
                ],
                'client' => [
                    'name' => '{{client_name}}',
                    'email' => '{{client_email}}',
                    'phone' => '{{client_phone}}',
                    'address' => '{{client_address}}',
                    'tax_id' => '{{client_tax_id}}'
                ]
            ],
            'scope' => '{{scope}}',
            'deliverables' => '{{deliverables}}',
            'milestones' => '{{milestones}}',
            'payment_terms' => '{{payment_terms}}',
            'amount' => '{{amount}}',
            'start_date' => '{{start_date}}',
            'end_date' => '{{end_date}}',
            'terms' => [
                'confidentiality' => true,
                'intellectual_property' => true,
                'termination' => true,
                'dispute_resolution' => true,
                'governing_law' => true,
                'indemnification' => true
            ]
        ],
        'created_at' => new MongoDB\BSON\UTCDateTime(),
        'updated_at' => new MongoDB\BSON\UTCDateTime()
    ];

    try {
        $templates->insertOne($basicTemplate);
        $templates->insertOne($premiumTemplate);
        echo "Default templates created successfully.\n";
    } catch (Exception $e) {
        echo "Error creating templates: " . $e->getMessage() . "\n";
    }
} else {
    echo "Templates already exist in the database.\n";
} 