<?php
    include("session.php");
    $obj = new Database();

    $id=$empid;
    
    $colName = "emp_id,shift_date,start_time,end_time,worked_hours,overtime";
	$join = "";
	$limit = 0;
    $where = "attendance_record.emp_id=$id AND attendance_record.shift_date = CURDATE()";
    

	$obj->select('attendance_record',$colName,$join,$where,null,$limit);
    $result = $obj->getResult();

    if(!empty($result)){
        $attendance_record = $result[0];
    
        // Extracting the values
        $shift_date = $attendance_record['shift_date'];
        $start_time = $attendance_record['start_time'];
        $end_time = $attendance_record['end_time'];
        $worked_hours = $attendance_record['worked_hours'];
        $overtime = $attendance_record['overtime'];
    }
    
?>
<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">



<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="assets/images/favicon.png" />

    <!-- Core Css -->
    <link rel="stylesheet" href="assets/css/styles.css" />
    <link rel="stylesheet" href="assets/css/custom.css" />

    <title><?=$web_title?></title>
    <!-- <link href="../../../../cdn.jsdelivr.net/npm/jvectormap%402.0.4/jquery-jvectormap.min.css" rel="stylesheet"> -->

</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <img src="assets/images/favicon.png" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <div id="main-wrapper">

        <div class="page-wrapper">

            <?php
                include('components/header.php');
            ?>

            <?php
                include('components/sidebar.php');
            ?>

            <div class="body-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <div class="card bg-box position-relative text-bg-info">
                                <div class="card-body text-center">
                                    <h2 class="fw-medium fs-8 text-white">10</h2>
                                    <h6 class="text-white mb-0 fw-medium">Total Employees</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card bg-box position-relative text-bg-secondary">
                                <div class="card-body text-center">
                                    <h2 class="fw-medium fs-8 text-white">5</h2>
                                    <h6 class="text-white mb-0 fw-medium">Total Departments</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card bg-box position-relative text-bg-success">
                                <div class="card-body text-center">
                                    <h2 class="fw-medium fs-8 text-white">4</h2>
                                    <h6 class="text-white mb-0 fw-medium">Total Leaves Remaining</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card bg-box position-relative text-bg-warning">
                                <div class="card-body text-center">
                                    <h2 class="fw-medium fs-8 text-white">3</h2>
                                    <h6 class="text-white mb-0 fw-medium">Approved Leaves</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card w-100">
                                <div class="card-body">
                                    <div class="d-md-flex no-block">
                                        <div>
                                            <h4 class="card-title">Employee Details</h4>
                                        </div>

                                    </div>
                                </div>
                                <!-- <div class="card-body bg-primary-subtle">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3 class="mb-1 fw-medium">March 2025</h3>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="card-body pt-8">
                                    <div class="table-responsive">
                                        <table class="table mb-0 align-middle text-nowrap">

                                            <tbody>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">Department</td>
                                                    <td class="text-muted fs-3">Development</td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">Designation</td>
                                                    <td class="text-muted fs-3">Web Developer</td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">Employee Name</td>
                                                    <td class="text-muted fs-3">Muhammad Zeeshan</td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">Date of Joining</td>
                                                    <td class="text-muted fs-3">03/02/2025</td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">Employee Timings</td>
                                                    <td class="text-muted fs-3">Full Time</td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">Salary</td>
                                                    <td class="text-muted fs-3">
                                                        <p id="show-salary" class="mt-2"
                                                            style="cursor: pointer; color: blue;">Show
                                                            Salary</p>
                                                        <span id="salary" style="display: none;">25000</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">CNIC</td>
                                                    <td class="text-muted fs-3">342423141412314</td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">Permenant Address</td>
                                                    <td class="text-muted fs-3">Isb</td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">Country</td>
                                                    <td class="text-muted fs-3">Pakistan</td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">Phone -1</td>
                                                    <td class="text-muted fs-3">0432143242</td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">Phone -2</td>
                                                    <td class="text-muted fs-3">0432143242</td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">Email</td>
                                                    <td class="text-muted fs-3">zeeshan@gmail.com</td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">Bank Name</td>
                                                    <td class="text-muted fs-3">Meezan Bank</td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">Account Title</td>
                                                    <td class="text-muted fs-3">Muhamamd Zeeshan</td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">IBAN</td>
                                                    <td class="text-muted fs-3">P#######</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card w-100">
                                <div class="card-body"
                                    style="display: flex;flex-direction: column;align-items: center;">
                                    <h4 class="card-title">Check In / Out Timings</h4>

                                    <?php if (!empty($start_time) || !empty($end_time)) { ?>
                                    <p class="mt-2 show-shift-details" style="font-weight: 800;">
                                        <?php if (!empty($start_time)) { ?>
                                        <span id="shift_started_at" class="text-success">Shift Start At:
                                            <?= $start_time ?></span>
                                        <?php } ?>

                                        <?php if (!empty($end_time)) { ?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span class="text-danger" id="shift_ended_at">|
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shift Ended At: <?= $end_time ?></span>
                                        <?php } ?>
                                    </p>
                                    <?php } else { ?>
                                    <p class="mt-2 show-shift-details" style="font-weight: 800; display:none;">
                                        <span id="shift_started_at" class="text-success" style="display:none">Shift
                                            Start At: 09:00 am</span>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span class="text-danger" id="shift_ended_at" style="display:none">|
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shift End At: 09:00 am</span>
                                    </p>
                                    <?php } ?>


                                    <div class="clock-design">

                                        <div class="clock">
                                            <div class="outer-clock-face">
                                                <div class="marking marking-one"></div>
                                                <div class="marking marking-two"></div>
                                                <div class="marking marking-three"></div>
                                                <div class="marking marking-four"></div>
                                                <div class="inner-clock-face">
                                                    <div class="hand hour-hand"></div>
                                                    <div class="hand min-hand"></div>
                                                    <div class="hand second-hand"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                        const secondHand = document.querySelector('.second-hand');
                                        const minsHand = document.querySelector('.min-hand');
                                        const hourHand = document.querySelector('.hour-hand');

                                        function setDate() {
                                            const now = new Date();

                                            const seconds = now.getSeconds();
                                            const secondsDegrees = ((seconds / 60) * 360) + 90;
                                            secondHand.style.transform = `rotate(${secondsDegrees}deg)`;

                                            const mins = now.getMinutes();
                                            const minsDegrees = ((mins / 60) * 360) + ((seconds / 60) * 6) + 90;
                                            minsHand.style.transform = `rotate(${minsDegrees}deg)`;

                                            const hour = now.getHours();
                                            const hourDegrees = ((hour / 12) * 360) + ((mins / 60) * 30) + 90;
                                            hourHand.style.transform = `rotate(${hourDegrees}deg)`;
                                        }

                                        setInterval(setDate, 1000);

                                        setDate();
                                        </script>

                                    </div>


                                    <?php if (!empty($start_time) && empty($end_time)) { ?>
                                    <button id="end_shift" data-id='<?= $empid ?>'
                                        class="btn btn-danger mt-2 btn-large">
                                        End Shift
                                    </button>
                                    <?php } ?>

                                    <?php if (!empty($end_time)) { ?>
                                    <p id="show-end-shift-message" class="mt-2">
                                        <span class="text-success">See you tomorrow! 👋</span>
                                    </p>
                                    <?php } ?>

                                    <?php if (empty($start_time) && empty($end_time)) { ?>
                                    <button id="start_shift" data-id='<?= $empid ?>'
                                        class="btn btn-success mt-2 btn-large">
                                        Start Shift
                                    </button>
                                    <button id="end_shift" data-id='<?= $empid ?>' class="btn btn-danger mt-2 btn-large"
                                        style="display:none">
                                        End Shift
                                    </button>
                                    <p id="show-end-shift-message" class="mt-2" style="display:none">
                                        <span class="text-success">See you tomorrow! 👋</span>
                                    </p>
                                    <?php } ?>




                                </div>
                            </div>
                            <div class="card w-100" style="height: 500px;overflow: hidden;overflow-y: auto;">
                                <div class="card-body">
                                    <div class="d-md-flex no-block">
                                        <div>
                                            <h4 class="card-title">Attendance Report</h4>

                                            <!-- <p class="card-subtitle">Total Working Hours <span>09</span></p>
                                            <br>
                                            <p class="card-subtitle">Break Time <span>( 1:30PM - 2:30PM )</span></p>
                                            <br>
                                            <p class="card-subtitle">Total Working Hours ( 09 ) - with 1 hour.</p> -->

                                            <table class="table mb-0 align-middle text-nowrap">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <p class="card-subtitle">Total Working Hours <span>09</span>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p class="card-subtitle">Break Time <span>( 1:30PM - 2:30PM
                                                                    )</span></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p class="card-subtitle">Total Working Hours ( 09 ) - with 1
                                                                hour Break Time.</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>


                                        </div>
                                        <div class="ms-auto">
                                            <select class="form-select">
                                                <option selected="">November</option>
                                                <option value="1">February</option>
                                                <option value="2">May</option>
                                                <option value="3">April</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="card-body bg-primary-subtle">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3 class="mb-1 fw-medium">March 2025</h3>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="card-body pt-8">
                                    <div class="table-responsive">
                                        <table class="table mb-0 align-middle text-nowrap"  id="attendance_record">
                                            
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">

                        </div>
                    </div>
                </div>
            </div>



        </div>



    </div>
    <div class="dark-transparent sidebartoggler"></div>
    <!-- Import Js Files -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/simplebar.min.js"></script>
    <script src="assets/js/app.minisidebar.init.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/js/sidebarmenu.js"></script>

    <!-- solar icons -->
    <script src="assets/js/iconify-icon.min.js"></script>
    <script src="assets/js/apexcharts.min.js"></script>
    <script src="assets/js/dashboard2.js"></script>
    <script src="assets/js/jquery.js"></script>

    <script>
    $(document).ready(function() {

        function loadTable() {
            $("#attendance_record").html('<div class="loader">Loading Data...</div>'); // Show loader before AJAX call
        
            $.ajax({
                url: "emp_attendance_record",
                type: "POST",
                success: function (data) {
                    $("#attendance_record").html(data); // Replace loader with table data
                },
                error: function () {
                    $("#attendance_record").html("<p>Error loading data.</p>"); // Handle errors
                }
            });
        }
        
        // Load Table Records on Page Load
        loadTable();

        $("#show-salary").on("click", function() {
            $("#salary").show(); // Show the salary
            $(this).hide(); // Hide "Show Salary" after clicking
        });

        $(document).on("click", "#start_shift", function() {
            let $this = $(this);
            $this.html("Please wait...").prop("disabled", true);

            var empid = $("#start_shift").data("id");

            $.ajax({
                url: "ajax/shift_started",
                type: "POST",
                dataType: "json", // Expect JSON response
                data: {
                    Empid: empid
                },
                success: function(res) {
                    console.log('Response:', res);

                    if (res.status == 1) {
                        $this.html("Shift Started Successfully...");

                        // Update shift start time
                        $("#shift_started_at").html("Shift Start At: " + res.start_time)
                            .show();

                        setTimeout(function() {
                            $this.hide();
                            $("#end_shift").show();
                            $(".show-shift-details").show();
                        }, 1000);

                        loadTable();
                    } else {
                        alert("Shift Not Started");
                        $this.html("Start Shift").prop("disabled", false);
                    }
                },
                error: function() {
                    alert("Error occurred. Please try again.");
                    $this.html("Start Shift").prop("disabled", false);
                }
            });
        });

        $(document).on("click", "#end_shift", function() {
            let $this = $(this);
            $this.html("Please wait...").prop("disabled", true);

            var empid = $("#end_shift").data("id");

            $.ajax({
                url: "ajax/end_shift",
                type: "POST",
                dataType: "json", // Expect JSON response
                data: {
                    Empid: empid
                },
                success: function(res) {
                    console.log('Response:', res);

                    if (res.status == 1) {
                        $this.html("Shift Ended Successfully...");

                        // Update shift start time
                        $("#shift_ended_at").html("|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shift Ended At: " + res.end_time)
                            .show();

                        setTimeout(function() {
                            $this.hide();
                            $(".show-shift-details").show();
                            $("#show-end-shift-message").show();
                        }, 1000);

                        loadTable();
                        
                    } else {
                        alert("Shift Not Ended");
                        $this.html("Start End").prop("disabled", false);
                    }
                },
                error: function() {
                    alert("Error occurred. Please try again.");
                    $this.html("End Shift").prop("disabled", false);
                }
            });
        });


    });
    </script>
</body>



</html>