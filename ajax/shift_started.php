<?php
    include "../session.php";
    $obj = new Database();


    if(isset($_POST['Empid'])){
        
        $data = [
            "emp_id" => $_POST['Empid'],
            "shift_date" => currentDate(),
            "start_time" => currentTime()
        ];

        $message = $obj->insert("attendance_record", $data) 
            ? "Data Inserted Successfully." 
            : "Data is Not Inserted Successfully.";

        
        if($message){
            echo 1;
        }else{
            echo 0;
        }
    }
    
?>