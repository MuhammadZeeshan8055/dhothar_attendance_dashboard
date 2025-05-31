<?php

$monthly_salary = 25000;
$hours_per_day = 8;
$worked_hours = 150;
$worked_minutes = 30;
$currency = 'PKR';

// Get current year and month
$year = date('Y');
$month = date('n');

// Function to get working days in a month (excluding Sundays)
function getWorkingDaysInMonth($year, $month) {
    $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $working_days = 0;
    for ($day = 1; $day <= $days_in_month; $day++) {
        $weekday = date('w', strtotime("$year-$month-$day"));
        if ($weekday != 0) { // 0 = Sunday
            $working_days++;
        }
    }
    return $working_days;
}

// Function to get working hours in a month
function getWorkingHoursInMonth($year, $month, $hours_per_day) {
    $working_days = getWorkingDaysInMonth($year, $month);
    return $working_days * $hours_per_day;
}

// Use functions
$working_days = getWorkingDaysInMonth($year, $month);
$total_hours_in_month = getWorkingHoursInMonth($year, $month, $hours_per_day);
$total_minutes_in_month = $total_hours_in_month * 60;

// Rates
$hourly_rate = $monthly_salary / $total_hours_in_month;
$minute_rate = $monthly_salary / $total_minutes_in_month;

// Worked time
$total_worked_minutes = ($worked_hours * 60) + $worked_minutes;

// Calculations
$calculated_salary = $total_worked_minutes * $minute_rate;
$short_minutes = max(0, $total_minutes_in_month - $total_worked_minutes);
$short_hours = floor($short_minutes / 60);
$remaining_minutes = $short_minutes % 60;
$short_days = $short_minutes / ($hours_per_day * 60);
$deducted_salary = max(0, $monthly_salary - $calculated_salary);

// Output
echo "<strong>Monthly Salary (Fixed):</strong> $currency " . $monthly_salary . "<br>";
echo "<strong>Working Days in Month (Excl. Sundays):</strong> $working_days<br>";
echo "<strong>Working Hours per Day:</strong> $hours_per_day<br>";
echo "<strong>Total Expected Hours:</strong> $total_hours_in_month<br>";
echo "<strong>Actual Hours Worked:</strong> {$worked_hours}h {$worked_minutes}m<br>";
echo "<strong>Shortfall in Time:</strong> {$short_hours}h {$remaining_minutes}m<br>";
echo "<strong>Shortfall in Days:</strong> " . round($short_days, 2) . "<br>";
echo "<strong>Hourly Rate:</strong> $currency " . round($hourly_rate, 2) . "<br>";
echo "<strong>Minute Rate:</strong> $currency " . round($minute_rate, 4) . "<br>";
echo "<strong>Calculated Salary:</strong> $currency " . round($calculated_salary) . "<br>";
echo "<strong>Deducted Salary:</strong> $currency " . round($deducted_salary);

?>
