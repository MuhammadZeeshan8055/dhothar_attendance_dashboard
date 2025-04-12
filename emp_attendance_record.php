<?php
include("session.php");
$obj = new Database();


$id=$empid;

$month = $_POST['month']; // e.g., "March"
$where = "emp_id='$id' and month = '$month'"; // Match the exact month name

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

if (!empty($result)) {
    foreach ($result as list(
        "id" => $id, "emp_id" => $emp_id, "shift_date" => $shift_date,
        "start_time" => $start_time, "end_time" => $end_time,
        "worked_hours" => $worked_hours, "overtime" => $overtime
    )) {
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

$output .= '</tbody>'; // Close tbody

echo $output;
?>
