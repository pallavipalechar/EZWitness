<?php
// Your existing code...

// Define the query to fetch attendance data
$sql = "SELECT Employee_ID, Name, Shift, AbsentDays, LateCheckins, TotalWorkSeconds, OvertimeSeconds, Status
        FROM attendance
        WHERE MONTH(Date) = MONTH('$month') AND YEAR(Date) = YEAR('$month')";

// Execute the query
$attendance_result = $conn->query($sql);

// Check if there are results and display them
if ($attendance_result->num_rows > 0) {
    // Initialize variables to count days present
    $days_present = 0;

    // Loop through the attendance records
    while($row = $attendance_result->fetch_assoc()) {
        // Calculate additional absent days for late check-ins
        $additional_absent_days = floor($row["LateCheckins"] / 3);
        $total_absent_days = $row["AbsentDays"] + $additional_absent_days;

        // LOP Days
        $lop_days = max($total_absent_days - 4, 0);

        // Check if the status is 'HD' or 'P', count as present
        if ($row["Status"] == 'HD' || $row["Status"] == 'P') {
            // Increment days present
            $days_present++;
        }

        // Output table row
        // Your existing table row output code...
    }
}
?>
