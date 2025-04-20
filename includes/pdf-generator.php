<?php
require_once 'vendor/autoload.php';
use TCPDF;

function generateContractPDF($contractData) {
    // Get client and user details
    global $clients, $users;
    $client = $clients->findOne(['_id' => new MongoDB\BSON\ObjectId($contractData['client_id'])]);
    $user = $users->findOne(['_id' => new MongoDB\BSON\ObjectId($contractData['user_id'])]);

    // Create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor($user['name']);
    $pdf->SetTitle($contractData['title']);
    $pdf->SetSubject('Contract Agreement');

    // Set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $contractData['title'], "Contract Agreement\nBetween {$user['name']} and {$client['name']}");

    // Set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // Set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // Set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // Set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // Set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Contract Header
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, $contractData['title'], 0, 1, 'C');
    $pdf->Ln(10);

    // Parties Information
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Parties', 0, 1);
    $pdf->SetFont('helvetica', '', 12);
    
    $pdf->Cell(0, 10, "This Agreement is made and entered into as of " . date('F d, Y', strtotime($contractData['start_date'])) . 
        " (the 'Effective Date') by and between:", 0, 1);
    $pdf->Ln(5);

    // Freelancer Information
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, $user['name'], 0, 1);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10, $user['email'], 0, 1);
    $pdf->Cell(0, 10, $user['phone'] ?? 'N/A', 0, 1);
    $pdf->Ln(5);

    // Client Information
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, $client['name'], 0, 1);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10, $client['email'], 0, 1);
    $pdf->Cell(0, 10, $client['phone'] ?? 'N/A', 0, 1);
    $pdf->Ln(10);

    // Contract Details
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Contract Details', 0, 1);
    $pdf->SetFont('helvetica', '', 12);

    $details = array(
        'Start Date' => date('F d, Y', strtotime($contractData['start_date'])),
        'End Date' => !empty($contractData['end_date']) ? date('F d, Y', strtotime($contractData['end_date'])) : 'Not specified',
        'Contract Amount' => '$' . number_format($contractData['amount'], 2),
        'Payment Terms' => ucfirst($contractData['payment_terms'])
    );

    foreach ($details as $label => $value) {
        $pdf->Cell(50, 10, $label . ':', 0, 0);
        $pdf->Cell(0, 10, $value, 0, 1);
    }
    $pdf->Ln(10);

    // Project Scope
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Project Scope', 0, 1);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->MultiCell(0, 10, $contractData['scope'], 0, 'L');
    $pdf->Ln(10);

    // Deliverables
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Deliverables', 0, 1);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->MultiCell(0, 10, $contractData['deliverables'], 0, 'L');
    $pdf->Ln(10);

    // Additional Terms
    if (!empty($contractData['terms'])) {
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, 'Additional Terms', 0, 1);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->MultiCell(0, 10, $contractData['terms'], 0, 'L');
        $pdf->Ln(10);
    }

    // Signatures
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Signatures', 0, 1);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Ln(20);

    // Freelancer Signature
    $pdf->Cell(90, 10, 'Freelancer:', 0, 0);
    $pdf->Cell(90, 10, 'Client:', 0, 1);
    $pdf->Ln(20);

    $pdf->Cell(90, 10, '___________________________', 0, 0);
    $pdf->Cell(90, 10, '___________________________', 0, 1);
    $pdf->Cell(90, 10, $user['name'], 0, 0);
    $pdf->Cell(90, 10, $client['name'], 0, 1);
    $pdf->Cell(90, 10, 'Date: ___________________', 0, 0);
    $pdf->Cell(90, 10, 'Date: ___________________', 0, 1);

    // Generate unique filename
    $filename = 'contracts/' . uniqid('contract_') . '.pdf';
    $fullPath = __DIR__ . '/../' . $filename;

    // Ensure directory exists
    if (!file_exists(dirname($fullPath))) {
        mkdir(dirname($fullPath), 0777, true);
    }

    // Save PDF
    $pdf->Output($fullPath, 'F');

    return $filename;
} 