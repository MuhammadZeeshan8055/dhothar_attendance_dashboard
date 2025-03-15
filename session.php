<?php
    include('database.php');
    $con=mysqli_connect('localhost','root','','dhothar_attendance');

    session_start();

    $web_title="Dhothar International - Attendance System";

    if(!isset($_SESSION["login"])){
        header("Location: login.php");
        exit();
    }


    $sess_email = $_SESSION["login"];
    $sql = "SELECT * FROM employee_info WHERE email = '$sess_email'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $empid=$row["id"];
        $name = $row["name"];
        $empemail=$row["email"];
    }
    } else {
        $empid="GHX1Y2";
        $username ="Jhon Doe";
        $empemail="mailid@domain.com";
    }

    // Function Helper 

    function currentDate(){
        return date('Y-m-d');
    }
    function currentTime() {
        date_default_timezone_set('Asia/Karachi'); // Set timezone to Pakistan
        return date('h:i A');
    }
    
?>