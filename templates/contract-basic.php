<?php
require_once '../includes/config.php';
requireAuth();

// Dummy contract data - replace with MongoDB data
$contract = [
    'id' => '1',
    'title' => 'Website Development Agreement',
    'client_name' => 'Acme Corporation',
    'client_email' => 'contact@acme.com',
    'client_address' => '123 Business St, Suite 100, New York, NY 10001',
    'project_description' => 'Development of a corporate website with e-commerce functionality',
    'project_timeline' => '3 months',
    'payment_terms' => '50% upfront, 50% upon completion',
    'total_amount' => '$5,000',
    'date_created' => date('F j, Y'),
    'signature_date' => date('F j, Y', strtotime('+1 day')),
    'terms' => [
        'The Developer agrees to provide the services outlined in this agreement',
        'The Client agrees to provide all necessary materials and information',
        'Both parties agree to maintain confidentiality of sensitive information',
        'The Client may request up to 3 rounds of revisions',
        'Additional work beyond the scope will be billed separately'
    ]
];
?>

<?php include '../includes/header.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h1>Contract Agreement</h1>
                        <p class="text-muted">Contract ID: <?php echo $contract['id']; ?></p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Developer Information</h5>
                            <p>
                                <?php echo $_SESSION['user_email']; ?><br>
                                Freelance Developer
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5>Client Information</h5>
                            <p>
                                <?php echo $contract['client_name']; ?><br>
                                <?php echo $contract['client_email']; ?><br>
                                <?php echo $contract['client_address']; ?>
                            </p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Project Description</h5>
                        <p><?php echo $contract['project_description']; ?></p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Project Timeline</h5>
                            <p><?php echo $contract['project_timeline']; ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5>Payment Terms</h5>
                            <p>
                                <?php echo $contract['payment_terms']; ?><br>
                                Total Amount: <?php echo $contract['total_amount']; ?>
                            </p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Terms and Conditions</h5>
                        <ol>
                            <?php foreach ($contract['terms'] as $term): ?>
                                <li><?php echo $term; ?></li>
                            <?php endforeach; ?>
                        </ol>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-6">
                            <div class="border-top pt-3">
                                <p>Developer Signature</p>
                                <p>Date: <?php echo $contract['date_created']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border-top pt-3">
                                <p>Client Signature</p>
                                <p>Date: <?php echo $contract['signature_date']; ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button class="btn btn-primary" onclick="window.print()">Print Contract</button>
                        <button class="btn btn-success" onclick="generatePDF()">Download PDF</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function generatePDF() {
    // This would be replaced with actual PDF generation logic
    alert('PDF generation would be implemented here');
}
</script>

<?php include '../includes/footer.php'; ?> 