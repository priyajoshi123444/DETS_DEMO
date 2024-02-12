<?php
// Include TCPDF library
require_once('TCPDF-main/tcpdf.php');

// Start session to access session variables
session_start();

// Include database connection
include 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page or display an error message
    header("Location: login.php");
    exit();
}

// Get the logged-in user's email from the session
$email = $_SESSION['email'];

// Fetch combined expenses and income for the logged-in user
$sql = "SELECT id, expenseName AS Name, expenseAmount AS Amount, expenseCategory AS Category, expenseDescription AS Description, expenseDate AS Date, billImage AS Image, 'Expense' AS Type FROM expense WHERE user_id = (SELECT user_id FROM user WHERE email = '$email') UNION ALL SELECT id, incomeName AS Name, incomeAmount AS Amount, incomeCategory AS Category, incomeDescription AS Description, incomeDate AS Date, NULL AS Image, 'Income' AS Type FROM income WHERE user_id = (SELECT user_id FROM user WHERE email = '$email') ORDER BY Date DESC";
$result = $conn->query($sql);

// Create new TCPDF instance
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Combined Expenses and Income Report');
$pdf->SetHeaderData('', '', 'Combined Expenses and Income Report', '');
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->SetFont('helvetica', '', 10);

// Start PDF content
$pdf->AddPage();

// Add combined expenses and income table to PDF
$html = '<h2>Combined Expenses and Income Report</h2>';
$html .= '<table border="1">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Amount</th>
                <th>Category</th>
                <th>Description</th>
                <th>Date</th>
                <th>Image</th>
                <th>Type</th>
            </tr>';
while ($row = $result->fetch_assoc()) {
    $html .= '<tr>
                <td>'.$row['id'].'</td>
                <td>'.$row['Name'].'</td>
                <td>'.$row['Amount'].'</td>
                <td>'.$row['Category'].'</td>
                <td>'.$row['Description'].'</td>
                <td>'.$row['Date'].'</td>
                <td>'.$row['Image'].'</td>
                <td>'.$row['Type'].'</td>
            </tr>';
}
$html .= '</table>';

// Write HTML content to PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF as download
$pdf->Output('combined_report.pdf', 'D');

// Close database connection
$conn->close();
?>
