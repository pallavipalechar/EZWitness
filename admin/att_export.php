<?php
// Include the PhpSpreadsheet autoload file
require 'vendor/autoload.php';

// Create a new PhpSpreadsheet object
//$spreadsheet = new phpoffice/phpspreadsheet/Spreadsheet();
//$sheet = $spreadsheet->getActiveSheet();

// Assuming you have received parameters via GET or POST
// For example, if you're passing parameters via GET:
$sel_month = $_GET['sel_month'];
$year = $_GET['sel_year'];
$shift_name = $_GET['shift_name'];

// You can adjust this part to fetch the data from your database based on the parameters received
// For demonstration, let's assume you have an array of data
$data = array(
    array('Employee_ID', 'Name', 'Department', 'Date', 'Shift', 'In_time', 'Out_time', 'Work_Hours', 'OT', 'Status'),
    array('001', 'John Doe', 'Sales', '2024-05-01', 'Morning', '08:00:00', '17:00:00', '09:00:00', '01:00:00', 'Present'),
    array('002', 'Jane Smith', 'Finance', '2024-05-01', 'Morning', '08:30:00', '16:30:00', '08:00:00', '00:00:00', 'Absent')
);

// Add data to the Excel sheet
foreach ($data as $rowIndex => $row) {
    foreach ($row as $columnIndex => $value) {
        $sheet->setCellValueByColumnAndRow($columnIndex + 1, $rowIndex + 1, $value);
    }
}

// Set headers for XLS download
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="attendance_export.xls"');
header('Cache-Control: max-age=0');

// Write the Excel file to output
//$writer = new PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
$writer->save('php://output');
