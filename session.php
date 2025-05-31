<?php
    include('database.php');
    $con=mysqli_connect('localhost','root','','dhothar_attendance');

    session_start();

    $web_title="Dhothar International - Attendance System";

    if(!isset($_SESSION["login"])){
        header("Location: login");
        exit();
    }


    $sess_email = $_SESSION["login"];
    $sql = "SELECT employee_info.*, company.* 
        FROM employee_info 
        LEFT JOIN company ON employee_info.company = company.id 
        WHERE employee_info.email = '$sess_email'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $empid=$row["id"];
        $curr_emp_name = $row["name"];
        $curr_emp_email=$row["email"];
        $curr_emp_company=$row["company_name"];
        $curr_emp_designation=$row["designation"];
        $curr_emp_date_of_joining=$row["date_of_joining"];
        $curr_emp_salary=$row["salary"];
        $curr_emp_currency=$row["currency"];
        $curr_emp_cnic_passport=$row["cnic_passport"];
        $curr_emp_permanent_address=$row["permanent_address"];
        $curr_emp_country=$row["country"];
        $curr_emp_phone_1=$row["phone_1"];
        $curr_emp_phone_2=$row["phone_2"];
        $curr_emp_bank_name=$row["bank_name"];
        $curr_emp_account_title=$row["account_title"];
        $curr_emp_iban=$row["iban"];
    }
    } else {
        $empid="GHX1Y2";
        $username ="Jhon Doe";
        $emp_email="mailid@domain.com";
    }

    $sql2 = "SELECT * FROM settings";
    $result2 = $con->query($sql2);

    $settings_data = [];

    if ($result2->num_rows > 0) {
        while ($row2 = $result2->fetch_assoc()) {
            $settings_data[$row2["meta_key"]] = $row2["meta_value"];
        }
    }

    $total_working_hours = $settings_data["total_working_hours"] ?? null;
    $break_timing = $settings_data["break_timing"] ?? null;
    $break_time = $settings_data["break_time"] ?? null;
    $pak_office = $settings_data["pak_ip_address"] ?? null;
    $uae_office = $settings_data["uae_ip_address"] ?? null;
    $rom_office = $settings_data["rom_ip_address"] ?? null;
    $official_working_hours = $settings_data["official_working_hours"] ?? null;

    // Function Helper 
    function currentDate(){
        return date('Y-m-d');
    }
    function currentTime() {
        date_default_timezone_set('Asia/Karachi'); // Set timezone to Pakistan
        return date('h:i A');
    }

    function formatDate($date) {
        return date("d-m-Y", strtotime($date));
    }
    

    function getUserIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

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
    
    function calculateEmployeeWorkedHours($emp_id, $month_name, $db) {
        $where = "emp_id = '$emp_id' AND month = '$month_name'";
        
        $db->select('attendance_record', '*', null, $where, null, null);
        $records = $db->getResult();
    
        $total_seconds = 0;
    
        foreach ($records as $row) {
            $worked_hours = $row['worked_hours'];
    
            // Parse "1 H, 30 m, 15 s"
            preg_match('/(\d+)\s*H/', $worked_hours, $h);
            preg_match('/(\d+)\s*m/', $worked_hours, $m);
            preg_match('/(\d+)\s*s/', $worked_hours, $s);
    
            $hours = isset($h[1]) ? (int)$h[1] : 0;
            $minutes = isset($m[1]) ? (int)$m[1] : 0;
            $seconds = isset($s[1]) ? (int)$s[1] : 0;
    
            $total_seconds += $hours * 3600 + $minutes * 60 + $seconds;
        }
    
        // Format total time
        $total_hours = floor($total_seconds / 3600);
        $total_minutes = floor(($total_seconds % 3600) / 60);
        $total_secs = $total_seconds % 60;
    
        return sprintf('%d H, %02d m, %02d s', $total_hours, $total_minutes, $total_secs);
    }
    
?>