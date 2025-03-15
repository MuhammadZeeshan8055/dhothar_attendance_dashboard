<?php
    
    include("session.php");
    
    $obj = new Database();

    
    $obj->select('attendance_record', '*', null, null, null, null);
    $result = $obj->getResult();
    


    $output='                               <thead>
                                                <tr>
                                                    <th class="fs-3 ps-0">Shift Date</th>
                                                    <th class="fs-3">Start Time</th>
                                                    <th class="fs-3">End Time</th>
                                                    <th class="fs-3">Worked Hours
                                                    </th>
                                                    <th class="fs-3">Overtime
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
            ';

            foreach ($result as list(
                "id" => $id, "emp_id" => $emp_id, "shift_date" => $shift_date,
                "start_time" => $start_time, "end_time" => $end_time,
                "worked_hours" => $worked_hours, "overtime" => $overtime
            )) {
                $output .= '
                    <tr>
                        <td class="ps-0 fs-3 text-muted">' . formatDate($shift_date) . '</td>
                        <td class="text-muted fs-3">' . $start_time . '</td>
                        <td class="text-muted fs-3">' . $end_time . '</td>
                        <td class="pe-0">
                            <span class="text-success fw-medium fs-3">' . $worked_hours . '</span>
                        </td>
                        <td>' . $overtime . '</td>
                    </tr>';
            }
            
            $output .= '</tbody>'; // Close tbody
            
            echo $output;
?>