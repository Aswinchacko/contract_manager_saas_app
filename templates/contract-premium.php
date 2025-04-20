<?php
require_once '../includes/config.php';
requireAuth();

// Dummy contract data - replace with MongoDB data
$contract = [
    'id' => '2',
    'title' => 'Premium Development Agreement',
    'client_name' => 'Tech Solutions Inc.',
    'client_email' => 'contact@techsolutions.com',
    'client_address' => '456 Innovation Ave, Suite 200, San Francisco, CA 94105',
    'project_description' => 'Development of a premium e-commerce platform with advanced features',
    'project_timeline' => '6 months',
    'payment_terms' => '30% upfront, 40% mid-project, 30% upon completion',
    'total_amount' => '$15,000',
    'date_created' => date('F j, Y'),
    'signature_date' => date('F j, Y', strtotime('+1 day')),
    'terms' => [
        'The Developer agrees to provide premium development services',
        'The Client agrees to provide all necessary resources and access',
        'Both parties agree to maintain strict confidentiality',
        'The Client may request up to 5 rounds of revisions',
        'Additional features beyond scope will be billed separately',
        'Regular progress meetings will be scheduled bi-weekly',
        'The Developer will provide ongoing support for 3 months post-launch',
        'Intellectual property rights will be transferred upon final payment'
    ],
    'milestones' => [
        ['name' => 'Project Kickoff', 'date' => date('F j, Y', strtotime('+1 week'))],
        ['name' => 'Design Approval', 'date' => date('F j, Y', strtotime('+1 month'))],
        ['name' => 'Development Phase 1', 'date' => date('F j, Y', strtotime('+2 months'))],
        ['name' => 'Development Phase 2', 'date' => date('F j, Y', strtotime('+4 months'))],
        ['name' => 'Testing & QA', 'date' => date('F j, Y', strtotime('+5 months'))],
        ['name' => 'Final Delivery', 'date' => date('F j, Y', strtotime('+6 months'))]
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
                        <h1>Premium Contract Agreement</h1>
                        <p class="text-muted">Contract ID: <?php echo $contract['id']; ?></p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Developer Information</h5>
                            <p>
                                <?php echo $_SESSION['user_email']; ?><br>
                                Premium Freelance Developer
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
                        <h5>Project Milestones</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Milestone</th>
                                        <th>Target Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($contract['milestones'] as $milestone): ?>
                                        <tr>
                                            <td><?php echo $milestone['name']; ?></td>
                                            <td><?php echo $milestone['date']; ?></td>
                                            <td>
                                                <span class="badge bg-warning">Pending</span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
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
                        <button class="btn btn-info" onclick="shareContract()">Share Contract</button>
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

function shareContract() {
    // This would be replaced with actual sharing logic
    alert('Contract sharing would be implemented here');
}
</script>

<?php include '../includes/footer.php'; ?> 