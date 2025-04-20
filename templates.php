<?php
require_once 'includes/config.php';
requireAuth();

// Get available templates
$templates = [
    [
        'id' => 'basic',
        'name' => 'Basic Contract',
        'description' => 'A simple contract template for standard freelance projects',
        'features' => ['Project scope', 'Payment terms', 'Timeline', 'Basic terms'],
        'icon' => 'file-alt',
        'color' => 'indigo'
    ],
    [
        'id' => 'premium',
        'name' => 'Premium Contract',
        'description' => 'A comprehensive contract template with advanced features',
        'features' => ['All basic features', 'Milestones', 'NDA', 'Intellectual property', 'Termination clauses'],
        'icon' => 'file-contract',
        'color' => 'emerald'
    ],
    [
        'id' => 'nda',
        'name' => 'NDA Agreement',
        'description' => 'Non-disclosure agreement template for confidential projects',
        'features' => ['Confidentiality terms', 'Duration', 'Scope', 'Remedies'],
        'icon' => 'lock',
        'color' => 'blue'
    ],
    [
        'id' => 'retainer',
        'name' => 'Retainer Agreement',
        'description' => 'Template for ongoing client relationships and retainer services',
        'features' => ['Service scope', 'Monthly terms', 'Billing schedule', 'Termination'],
        'icon' => 'calendar-check',
        'color' => 'amber'
    ]
];

$page_title = 'Templates';
?>

<?php include 'includes/header.php'; ?>

<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Contract Templates</h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Choose from our collection of professional contract templates
                    </p>
                </div>
                <a href="custom-template.php" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                    <i class="fas fa-plus mr-2"></i> Create Custom Template
                </a>
            </div>
        </div>
    </div>

    <!-- Templates Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-2">
        <?php foreach ($templates as $template): ?>
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-150">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-full bg-<?php echo $template['color']; ?>-100 flex items-center justify-center">
                                <i class="fas fa-<?php echo $template['icon']; ?> text-<?php echo $template['color']; ?>-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                <?php echo htmlspecialchars($template['name']); ?>
                            </h3>
                            <p class="text-sm text-gray-500">
                                <?php echo htmlspecialchars($template['description']); ?>
                            </p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Features:</h4>
                        <ul class="space-y-2">
                            <?php foreach ($template['features'] as $feature): ?>
                                <li class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check text-<?php echo $template['color']; ?>-500 mr-2"></i>
                                    <?php echo htmlspecialchars($feature); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <span class="text-sm text-gray-500 mr-2">Last updated:</span>
                                <span class="text-sm font-medium text-gray-900"><?php echo date('M d, Y'); ?></span>
                            </div>
                            <div class="flex space-x-2">
                                <a href="preview-template.php?id=<?php echo $template['id']; ?>" 
                                   class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-<?php echo $template['color']; ?>-700 bg-<?php echo $template['color']; ?>-100 hover:bg-<?php echo $template['color']; ?>-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-<?php echo $template['color']; ?>-500 transition-colors duration-150"
                                   title="Preview Template">
                                    <i class="fas fa-eye mr-2"></i> Preview
                                </a>
                                <a href="use-template.php?id=<?php echo $template['id']; ?>" 
                                   class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-<?php echo $template['color']; ?>-600 hover:bg-<?php echo $template['color']; ?>-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-<?php echo $template['color']; ?>-500 transition-colors duration-150"
                                   title="Use Template">
                                    <i class="fas fa-file-signature mr-2"></i> Use Template
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Custom Template Section -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-magic text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Need a Custom Template?</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Create your own custom contract template with our easy-to-use template builder
                    </p>
                </div>
                <div class="ml-auto">
                    <a href="custom-template.php" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-150">
                        <i class="fas fa-magic mr-2"></i> Create Custom Template
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?> 