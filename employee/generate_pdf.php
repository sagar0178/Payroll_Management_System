<?php
require('fpdf186/fpdf.php');
require('config.php'); // Include your database connection

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Employee Income Statement', 0, 1, 'C');
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Get the logged-in employee_id (You'll need to replace 'employee_id' with the actual session variable)
session_start();
$employee_id = $_SESSION['employee_id'];

// Fetch income data for the logged-in employee
$query = "SELECT i.*, e.name FROM income i
          INNER JOIN employees e ON i.employee_id = e.id
          WHERE i.employee_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();
$incomeData = $result->fetch_assoc();
$stmt->close();

// Create PDF instance
$pdf = new PDF();
$pdf->AddPage();

// Add content
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Employee ID: ' . $incomeData['employee_id'], 0, 1);
$pdf->Cell(0, 10, 'Employee Name: ' . $incomeData['name'], 0, 1);
$pdf->Cell(0, 10, 'Basic Pay: ' . $incomeData['basic_pay'], 0, 1);
$pdf->Cell(0, 10, 'Deductions: ' . $incomeData['deductions'], 0, 1);
$pdf->Cell(0, 10, 'Overtime: ' . $incomeData['overtime'], 0, 1);
$pdf->Cell(0, 10, 'Bonus: ' . $incomeData['bonus'], 0, 1);
$pdf->Cell(0, 10, 'Total: ' . $incomeData['total'], 0, 1);
$pdf->Cell(0, 10, 'Net Pay: ' . $incomeData['net_pay'], 0, 1);

// Output PDF for download
$pdf->Output('employee_income.pdf', 'D');