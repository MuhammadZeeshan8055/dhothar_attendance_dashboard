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
    $sql = "SELECT * FROM employee_info WHERE email = '$sess_email'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $empid=$row["id"];
        $curr_emp_name = $row["name"];
        $curr_emp_email=$row["email"];
        $curr_emp_company=$row["company"];
        $curr_emp_designation=$row["designation"];
        $curr_emp_date_of_joining=$row["date_of_joining"];
        $curr_emp_salary=$row["salary"];
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
    $officeIP = $settings_data["ip_address"] ?? null;
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
    
?>