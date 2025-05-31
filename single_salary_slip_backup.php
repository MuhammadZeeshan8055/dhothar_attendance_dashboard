<?php
include("session.php");
$obj = new Database();

// Get employee ID
$employee_id = $_GET['id'] ?? null;
if (!$employee_id) {
    exit("Employee ID is required.");
}

// Fetch employee data
$obj->select('employee_info', '*', null, "id = $employee_id", null, 0);
$result = $obj->getResult();
if (empty($result)) {
    exit("Employee not found.");
}
$employee = $result[0];

// Setup variables
$month_record = $_POST['month'] ?? date('F');
$currency = 'PKR';
$actual_worked_hours_in_month= calculateEmployeeWorkedHours($employee_id, $month_record, $obj);

// Parse hours and minutes
preg_match_all('/(\d+)\s*[Hms]/', $actual_worked_hours_in_month, $matches);
$worked_hours = isset($matches[1][0]) ? (int)$matches[1][0] : 0;
$worked_minutes = isset($matches[1][1]) ? (int)$matches[1][1] : 0;

// Monthly salary and daily hours
$monthly_salary = (float) $employee['salary'];
$total_official_working_hours = $total_working_hours; // Customize this value if needed

// Date info
$year = date('Y');
$month = date('n');

// Helper calculations
$working_days = getWorkingDaysInMonth($year, $month);
$total_expected_hours = $working_days * $total_official_working_hours;
$total_expected_minutes = $total_expected_hours * 60;

$hourly_rate = $monthly_salary / $total_expected_hours;
$minute_rate = $monthly_salary / $total_expected_minutes;

$total_worked_minutes = ($worked_hours * 60) + $worked_minutes;
$shortfall_minutes = max(0, $total_expected_minutes - $total_worked_minutes);
$shortfall_hours = floor($shortfall_minutes / 60);
$shortfall_rem_minutes = $shortfall_minutes % 60;
$shortfall_days = $shortfall_minutes / ($total_official_working_hours * 60);

$calculated_salary = $total_worked_minutes * $minute_rate;
$deducted_salary = max(0, $monthly_salary - $calculated_salary);

// Output summary
echo "<h4>Salary Calculation Summary</h4>";
echo "<ul>";
echo "<li><strong>Monthly Salary (Fixed):</strong> $currency " . number_format($monthly_salary) . "</li>";
echo "<li><strong>Working Days in Month (Excl. Sundays):</strong> $working_days</li>";
echo "<li><strong>Working Hours per Day:</strong> $total_official_working_hours</li>";
echo "<li><strong>Total Expected Hours:</strong> $total_expected_hours</li>";
echo "<li><strong>Actual Hours Worked:</strong> {$worked_hours}h {$worked_minutes}m</li>";
echo "<li><strong>Shortfall in Time:</strong> {$shortfall_hours}h {$shortfall_rem_minutes}m</li>";
echo "<li><strong>Shortfall in Days:</strong> " . round($shortfall_days, 2) . "</li>";
echo "<li><strong>Hourly Rate:</strong> $currency " . round($hourly_rate, 2) . "</li>";
echo "<li><strong>Minute Rate:</strong> $currency " . round($minute_rate, 4) . "</li>";
echo "<li><strong>Calculated Salary:</strong> $currency " . round($calculated_salary) . "</li>";
echo "<li><strong>Deducted Salary:</strong> $currency " . round($deducted_salary) . "</li>";
echo "</ul>";
?>
