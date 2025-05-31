<?php
include("session.php");
$obj = new Database();

// Get current year and month
$year = date('Y');
// $month = date('n');

$month_name = $_POST['month'];
$month = date('n', strtotime($month_name));

$hours_per_day = $total_working_hours;
$working_days = getWorkingDaysInMonth($year, $month);
$total_hours_in_month = getWorkingHoursInMonth($year, $month, $hours_per_day);


$id=$empid;

$month_record = $_POST['month'] ?? date('F');

$total_worked_hours_in_month= calculateEmployeeWorkedHours($id, $month_record, $obj);

$where = "emp_id='$id' and month = '$month_name'"; // Match the exact month name

$obj->select('attendance_record', '*', null, $where, null, null);
$result = $obj->getResult();

$output = '<thead>
                <tr>
                    <th class="fs-3 ps-0">Shift Date</th>
                    <th class="fs-3">Start Time</th>
                    <th class="fs-3">End Time</th>
                    <th class="fs-3">Worked Hours</th>
                    <th class="fs-3">Overtime</th>
                </tr>
            </thead>
            <tbody>';

$count_days=0;

if (!empty($result)) {
    foreach ($result as list(
        "id" => $id, "emp_id" => $emp_id, "shift_date" => $shift_date,
        "start_time" => $start_time, "end_time" => $end_time,
        "worked_hours" => $worked_hours, "overtime" => $overtime
    )) {


        if(!empty($worked_hours)) {
            $count_days++;
        }

        // Extract the numeric hours from the worked_hours string
        $parts = explode(' ', $worked_hours);
        $hours = (int)$parts[0]; // assumes the first part is the hours number

        // Set the style if worked hours are below 9
        $rowStyle = ($hours < $official_working_hours) ? 'style="color: red;"' : '';

        $output .= '<tr ' . $rowStyle . '>
                        <td ' . $rowStyle . ' class="ps-0 fs-3">' . formatDate($shift_date) . '</td>
                        <td ' . $rowStyle . ' class="fs-3">' . $start_time . '</td>
                        <td ' . $rowStyle . ' class="fs-3">' . $end_time . '</td>
                        <td ' . $rowStyle . ' class="pe-0">
                            <span ' . $rowStyle . ' class="' . (!empty($rowStyle) ? 'text-danger' : 'text-success') . ' fw-medium fs-3">' . $worked_hours . '</span>
                        </td>
                        <td ' . $rowStyle . '>' . $overtime . '</td>
                    </tr>';
    }
} else {
    // Display message if no data is found
    $output .= '<tr>
                    <td colspan="5" class="text-center fs-3 text-danger">No data found</td>
                </tr>';
}

    $output .= '<tr>
                    <td colspan="3" style="text-align: right;">
                        You have Worked ( '.$count_days.' ) Days.
                    </td>
                    <td>You have Worked <br> ( '.$total_worked_hours_in_month.' ) <br> Hours, Minutes.</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;">
                        You need to have at-least
                    </td>
                    <td>( '.$total_hours_in_month.' ) <br> Working Hours.</td>
                </tr>
                <tr>
                    <td colspan="2">
                        Official Working Days :
                    </td>
                    <td>'.$working_days.'</td>
                    <td>Official Working Hours <br> : '.$total_hours_in_month.' H</td>
                </tr>';

$output .= '</tbody>'; // Close tbody

echo $output;
?>
