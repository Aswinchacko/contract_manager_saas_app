<?php
require_once 'includes/config.php';
requireAuth();

// Initialize variables
$step = isset($_GET['step']) ? (int)$_GET['step'] : 1;
$contractData = $_SESSION['contract_data'] ?? [];
$errors = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($step) {
        case 1:
            // Basic Information
            $contractData['title'] = trim($_POST['title'] ?? '');
            $contractData['client_id'] = trim($_POST['client_id'] ?? '');
            $contractData['template_id'] = trim($_POST['template_id'] ?? '');
            
            if (empty($contractData['title'])) {
                $errors[] = 'Contract title is required';
            }
            if (empty($contractData['client_id'])) {
                $errors[] = 'Please select a client';
            }
            if (empty($contractData['template_id'])) {
                $errors[] = 'Please select a template';
            }
            
            if (empty($errors)) {
                $_SESSION['contract_data'] = $contractData;
                header('Location: new-contract.php?step=2');
                exit;
            }
            break;
            
        case 2:
            // Contract Details
            $contractData['start_date'] = trim($_POST['start_date'] ?? '');
            $contractData['end_date'] = trim($_POST['end_date'] ?? '');
            $contractData['amount'] = trim($_POST['amount'] ?? '');
            $contractData['payment_terms'] = trim($_POST['payment_terms'] ?? '');
            
            if (empty($contractData['start_date'])) {
                $errors[] = 'Start date is required';
            }
            if (empty($contractData['amount'])) {
                $errors[] = 'Contract amount is required';
            }
            
            if (empty($errors)) {
                $_SESSION['contract_data'] = $contractData;
                header('Location: new-contract.php?step=3');
                exit;
            }
            break;
            
        case 3:
            // Terms and Conditions
            $contractData['scope'] = trim($_POST['scope'] ?? '');
            $contractData['deliverables'] = trim($_POST['deliverables'] ?? '');
            $contractData['terms'] = trim($_POST['terms'] ?? '');
            
            if (empty($contractData['scope'])) {
                $errors[] = 'Project scope is required';
            }
            if (empty($contractData['deliverables'])) {
                $errors[] = 'Deliverables are required';
            }
            
            if (empty($errors)) {
                // Save contract to database
                $contractData['user_id'] = $_SESSION['user_id'];
                $contractData['status'] = 'draft';
                $contractData['created_at'] = new MongoDB\BSON\UTCDateTime();
                
                $result = $contracts->insertOne($contractData);
                
                if ($result->getInsertedId()) {
                    // Generate PDF
                    require_once 'includes/pdf-generator.php';
                    $pdfPath = generateContractPDF($contractData);
                    
                    // Update contract with PDF path
                    $contracts->updateOne(
                        ['_id' => $result->getInsertedId()],
                        ['$set' => ['pdf_path' => $pdfPath]]
                    );
                    
                    // Clear session data
                    unset($_SESSION['contract_data']);
                    
                    // Redirect to success page
                    header('Location: contract.php?id=' . $result->getInsertedId());
                    exit;
                }
            }
            break;
    }
}

// Get clients and templates for dropdowns
$clients = $clients->find(['user_id' => $_SESSION['user_id']])->toArray();
$templates = $templates->find()->toArray();

$page_title = 'New Contract';
?>

<?php include 'includes/header.php'; ?>

<div class="max-w-3xl mx-auto">
    <!-- Progress Steps -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="flex items-center relative">
                    <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 <?php echo $step >= 1 ? 'bg-indigo-600 border-indigo-600' : 'border-gray-300'; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text w-6 h-6 text-white">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                    </div>
                    <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium text-indigo-600">Basic Info</div>
                </div>
                <div class="flex-auto border-t-2 transition duration-500 ease-in-out <?php echo $step >= 2 ? 'border-indigo-600' : 'border-gray-300'; ?>"></div>
                <div class="flex items-center relative">
                    <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 <?php echo $step >= 2 ? 'bg-indigo-600 border-indigo-600' : 'border-gray-300'; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign w-6 h-6 text-white">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                    <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium text-indigo-600">Details</div>
                </div>
                <div class="flex-auto border-t-2 transition duration-500 ease-in-out <?php echo $step >= 3 ? 'border-indigo-600' : 'border-gray-300'; ?>"></div>
                <div class="flex items-center relative">
                    <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 <?php echo $step >= 3 ? 'bg-indigo-600 border-indigo-600' : 'border-gray-300'; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle w-6 h-6 text-white">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium text-indigo-600">Terms</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Content -->
    <div class="bg-white shadow rounded-lg p-6">
        <?php if (!empty($errors)): ?>
            <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            <?php echo implode('<br>', $errors); ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <?php if ($step === 1): ?>
                <!-- Step 1: Basic Information -->
                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Contract Title</label>
                        <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($contractData['title'] ?? ''); ?>" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    
                    <div>
                        <label for="client_id" class="block text-sm font-medium text-gray-700">Client</label>
                        <select name="client_id" id="client_id" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select a client</option>
                            <?php foreach ($clients as $client): ?>
                                <option value="<?php echo $client['_id']; ?>" <?php echo ($contractData['client_id'] ?? '') == $client['_id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($client['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div>
                        <label for="template_id" class="block text-sm font-medium text-gray-700">Template</label>
                        <select name="template_id" id="template_id" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select a template</option>
                            <?php foreach ($templates as $template): ?>
                                <option value="<?php echo $template['_id']; ?>" <?php echo ($contractData['template_id'] ?? '') == $template['_id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($template['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
            <?php elseif ($step === 2): ?>
                <!-- Step 2: Contract Details -->
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" name="start_date" id="start_date" value="<?php echo htmlspecialchars($contractData['start_date'] ?? ''); ?>" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date (Optional)</label>
                            <input type="date" name="end_date" id="end_date" value="<?php echo htmlspecialchars($contractData['end_date'] ?? ''); ?>" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                    
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">Contract Amount</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" name="amount" id="amount" value="<?php echo htmlspecialchars($contractData['amount'] ?? ''); ?>" 
                                   class="block w-full pl-7 pr-12 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                    
                    <div>
                        <label for="payment_terms" class="block text-sm font-medium text-gray-700">Payment Terms</label>
                        <select name="payment_terms" id="payment_terms" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select payment terms</option>
                            <option value="upfront" <?php echo ($contractData['payment_terms'] ?? '') == 'upfront' ? 'selected' : ''; ?>>Upfront Payment</option>
                            <option value="milestone" <?php echo ($contractData['payment_terms'] ?? '') == 'milestone' ? 'selected' : ''; ?>>Milestone Payments</option>
                            <option value="end" <?php echo ($contractData['payment_terms'] ?? '') == 'end' ? 'selected' : ''; ?>>Payment Upon Completion</option>
                        </select>
                    </div>
                </div>
                
            <?php elseif ($step === 3): ?>
                <!-- Step 3: Terms and Conditions -->
                <div class="space-y-4">
                    <div>
                        <label for="scope" class="block text-sm font-medium text-gray-700">Project Scope</label>
                        <textarea name="scope" id="scope" rows="4" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"><?php echo htmlspecialchars($contractData['scope'] ?? ''); ?></textarea>
                    </div>
                    
                    <div>
                        <label for="deliverables" class="block text-sm font-medium text-gray-700">Deliverables</label>
                        <textarea name="deliverables" id="deliverables" rows="4" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"><?php echo htmlspecialchars($contractData['deliverables'] ?? ''); ?></textarea>
                    </div>
                    
                    <div>
                        <label for="terms" class="block text-sm font-medium text-gray-700">Additional Terms</label>
                        <textarea name="terms" id="terms" rows="4" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"><?php echo htmlspecialchars($contractData['terms'] ?? ''); ?></textarea>
                    </div>
                </div>
            <?php endif; ?>

            <div class="flex justify-between pt-5">
                <?php if ($step > 1): ?>
                    <a href="?step=<?php echo $step - 1; ?>" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-arrow-left mr-2"></i> Previous
                    </a>
                <?php else: ?>
                    <div></div>
                <?php endif; ?>
                
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <?php echo $step === 3 ? 'Create Contract' : 'Next'; ?>
                    <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?> 