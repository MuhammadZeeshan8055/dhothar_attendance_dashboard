<?php
include("session.php");
$obj = new Database();

if(isset($_POST['generate_salary_slip'])){

    
    $month_record = $_POST['month'] ?? date('F');
    $currency = 'PKR';
    $total_working_hours = $total_working_hours; // Customize as needed

    $year = date('Y');
    $month_name = $_GET['month'] ?? '';
    $timestamp = strtotime($month_name);

    if ($timestamp) {
        $month = date('n', $timestamp);
    } else {
        $month = date('n'); // fallback to current month
    }

    
    $colName = "*";
    $join    = null;
    $limit   = 0;
    $where   = "month = '$month_record' and year='$year'";

    $obj->select('attendance_record', $colName, $join, $where, null, $limit);
    $check_attendance_result = $obj->getResult();

    if(!empty($check_attendance_result)){

        $colName = "*";
        $join    = null;
        $limit   = 0;
        $where   = "month = '$month_record' and year='$year'";

        $obj->select('attendance_summary', $colName, $join, $where, null, $limit);
        $check_result = $obj->getResult();

        if (empty($check_result)) {

            $working_days = getWorkingDaysInMonth($year, $month);
            $total_expected_hours = $working_days * $total_working_hours;
            $total_expected_minutes = $total_expected_hours * 60;

            // Fetch all employees
            $obj->select('employee_info', '*');
            $employees = $obj->getResult();

            if (empty($employees)) {
                exit("No employees found.");
            }

            echo "<h3>Salary Calculation Summary for All Employees</h3>";
            echo "<table border='1' cellpadding='6' cellspacing='0'>";
            echo "<tr>
                    <th>Name</th>
                    <th>Salary</th>
                    <th>Working Days in Month (Excl. Sundays)</th>
                    <th>Working Hours per Day</th>
                    <th>Total Expected Hours</th>
                    <th>Actual Worked Hours</th>
                    <th>Shortfall</th>
                    <th>Hourly Rate</th>
                    <th>Minute Rate</th>
                    <th>Calculated Salary</th>
                    <th>Deducted Amount</th>
                </tr>";

            foreach ($employees as $employee) {
                $employee_id = $employee['id'];
                $monthly_salary = (float) $employee['salary'];
                $total_official_working_hours = $total_working_hours;

                // You need to define this function to calculate actual worked hours
                $actual_worked_hours_in_month = calculateEmployeeWorkedHours($employee_id, $month_record, $obj);

                // Parse worked hours
                preg_match_all('/(\d+)\s*[Hms]/', $actual_worked_hours_in_month, $matches);
                $worked_hours = isset($matches[1][0]) ? (int)$matches[1][0] : 0;
                $worked_minutes = isset($matches[1][1]) ? (int)$matches[1][1] : 0;

                $hourly_rate = $monthly_salary / $total_expected_hours;
                $minute_rate = $monthly_salary / $total_expected_minutes;

                $total_worked_minutes = ($worked_hours * 60) + $worked_minutes;
                $shortfall_minutes = max(0, $total_expected_minutes - $total_worked_minutes);
                $shortfall_hours = floor($shortfall_minutes / 60);
                $shortfall_rem_minutes = $shortfall_minutes % 60;
                $short_days = $shortfall_minutes / ($total_working_hours * 60);
                $calculated_salary = $total_worked_minutes * $minute_rate;
                $deducted_salary = max(0, $monthly_salary - $calculated_salary);

                $attendance_summary = [
                    "emp_id"         => $employee_id,
                    "working_days"   => $working_days,
                    "shortfall_in_days"   => $short_days,
                    "expected_hours"  => $total_expected_hours.' h ',
                    "actual_hours"      => $worked_hours.' h '.$worked_minutes.' m',
                    "month"          => $month_record,
                    "year"          => $year
                ];

                $message = $obj->insert("attendance_summary", $attendance_summary)
                ? "Attendance Record Inserted Successfully."
                : "Attendance Data Not Inserted Successfully.";

                $salarysheet = [
                    "emp_id"         => $employee_id,
                    "shortfall_mins"     => $shortfall_hours.' h '.$shortfall_rem_minutes.' m', // e.g., '2025-05'
                    "hourly_rate"   => round($hourly_rate, 2).' '.$employee['currency'],
                    "minute_rate"  => round($minute_rate, 2).' '.$employee['currency'],
                    "calculated_salary"      => round($calculated_salary).' '.$employee['currency'],
                    "deducted_salary"      => round($deducted_salary).' '.$employee['currency'],
                    "month"          => $month_record,
                    "year"          => $year
                ];

                $message = $obj->insert("salary_sheet", $salarysheet)
                ? "Salary Record Inserted Successfully."
                : "Salary Data Not Inserted Successfully.";

                echo "<tr>
                        <td>{$employee['name']}</td>
                        <td>$currency " . number_format($monthly_salary) . "</td>
                        <td>{$working_days} Days</td>
                        <td>{$total_official_working_hours}h</td>
                        <td>{$total_expected_hours}h 00m 00s</td>
                        <td>{$worked_hours}h {$worked_minutes}m</td>
                        <td>{$shortfall_hours}h {$shortfall_rem_minutes}m</td>
                        <td>$currency " . round($hourly_rate, 2) . "</td>
                        <td>$currency " . round($minute_rate, 2) . "</td>
                        <td>$currency " . round($calculated_salary) . "</td>
                        <td>$currency " . round($deducted_salary) . "</td>
                    </tr>";
            }

            echo "</table>";

            header("location:salary_report");
        }else{
            echo 'Salary Record already Exist';
            die();
        }

    }else{
        echo '<script>
            alert("Can\'t generate salary slip because no attendance record found for this month.");
            window.location.href = "salary_report";
        </script>';
        exit;
        
    }


    

    
}


?>
