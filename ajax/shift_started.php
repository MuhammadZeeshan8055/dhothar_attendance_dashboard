<?php
include "../session.php";
$obj = new Database();

if (isset($_POST['Empid'])) {
    $start_time = currentTime(); // Get current time

    $data = [
        "emp_id" => $_POST['Empid'],
        "shift_date" => currentDate(),
        "start_time" => $start_time
    ];

    if ($obj->insert("attendance_record", $data)) {
        echo json_encode(["status" => 1, "start_time" => $start_time]);
    } else {
        echo json_encode(["status" => 0]);
    }
}
?>
