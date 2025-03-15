<?php
    include("session.php");
    $obj = new Database();

    $obj->select('attendance_record');

    $result = $obj->getResult();

    foreach ($result as list("emp_id"=>$emp_id,"shift_date"=>$shift_date,
    "start_time"=>$start_time,"end_time"=>$end_time,"worked_hours"=>$worked_hours,"overtime"=>$overtime)) {

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

                                    <p class="mt-2 show-shift-details" style="font-weight: 800;display:none"><span
                                            id="shift_started_at" class="text-success" style="display:none">Shift Start
                                            At
                                            : 09:00 am </span>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span class="text-danger" id="shift_ended_at" style="display:none">|
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shift End At : 09:00 am</span>
                                    </p>

                                    <div class="clock-design">

                                        <!-- <div class="clock">
                                            <div class="hand hour" id="hour"></div>
                                            <div class="hand minute" id="minute"></div>
                                            <div class="hand second" id="second"></div>
                                            <div class="center"></div>
                                        </div>

                                        <script>
                                        function updateClock() {
                                            const now = new Date();
                                            const options = {
                                                timeZone: "Asia/Karachi"
                                            };
                                            const time = new Intl.DateTimeFormat('en-US', {
                                                hour12: false,
                                                ...options
                                            }).format(now);

                                            // Get hours, minutes, and seconds from the Date object
                                            const hours = now.getHours();
                                            const minutes = now.getMinutes();
                                            const seconds = now.getSeconds();

                                            // Calculate degrees for clock hands
                                            const hourDeg = (hours % 12) * 30 + minutes *
                                                0.5; // 30 degrees per hour and 0.5 per minute
                                            const minuteDeg = minutes * 6; // 6 degrees per minute
                                            const secondDeg = seconds * 6; // 6 degrees per second

                                            // Apply rotation to clock hands
                                            document.getElementById("hour").style.transform = `rotate(${hourDeg}deg)`;
                                            document.getElementById("minute").style.transform =
                                                `rotate(${minuteDeg}deg)`;
                                            document.getElementById("second").style.transform =
                                                `rotate(${secondDeg}deg)`;
                                        }

                                        setInterval(updateClock, 1000); // Update every second
                                        updateClock(); // Initialize the clock immediately
                                        </script> -->

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

                                    <button id="start_shift" data-id='<?=$empid?>'
                                        class="btn btn-success mt-2 btn-large">
                                        Start Shift
                                    </button>

                                    <button id="end_shift" data-id='<?=$empid?>' class="btn btn-danger mt-2 btn-large"
                                        style="display:none">
                                        End Shift
                                    </button>

                                    <p id="show-end-shift-message" class="mt-2" style="display:none"><span
                                            class="text-success">See you tomorrow! 👋</span></p>

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
                                        <table class="table mb-0 align-middle text-nowrap">
                                            <thead>
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
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">03-03-2025 </td>
                                                    <td class="text-muted fs-3">08:53 am</td>
                                                    <td class="text-muted fs-3">04:01 pm</td>
                                                    <td class="pe-0">
                                                        <span class="text-success fw-medium fs-3">
                                                            9 H, 07 m, 50 s</span>
                                                    </td>
                                                    <td>07 m, 50 s</td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">03-03-2025</td>
                                                    <td class="text-muted fs-3">08:53 am</td>
                                                    <td class="text-muted fs-3">04:01 pm</td>
                                                    <td class="pe-0">
                                                        <span class="text-success fw-medium fs-3">
                                                            9 H, 00 </span>
                                                    </td>
                                                    <td>00</td>

                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted"><span
                                                            class="text-danger">04-03-2025</span></td>
                                                    <td class="text-muted fs-3 "><span class="text-danger">--</span>
                                                    </td>
                                                    <td class="text-muted fs-3 text-danger"><span
                                                            class="text-danger">--</span></td>
                                                    <td class="pe-0">
                                                        <span class="text-danger fw-medium fs-3">
                                                            --</span>
                                                    </td>
                                                    <td><span class="text-danger">--</span></td>

                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">03-03-2025 </td>
                                                    <td class="text-muted fs-3">08:53 am</td>
                                                    <td class="text-muted fs-3">04:01 pm</td>
                                                    <td class="pe-0">
                                                        <span class="text-danger fw-medium fs-3">
                                                            8 H, 00 </span>
                                                    </td>
                                                    <td>00</td>

                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">03-03-2025 </td>
                                                    <td class="text-muted fs-3">08:53 am</td>
                                                    <td class="text-muted fs-3">04:01 pm</td>
                                                    <td class="pe-0">
                                                        <span class="text-success fw-medium fs-3">
                                                            9 H, 07 m, 50 s</span>
                                                    </td>
                                                    <td>07 m, 50 s</td>

                                                </tr>
                                            </tbody>
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
                data: {
                    Empid: empid
                },
                success: function(res) {
                    console.log('Employee Id: ', res);
                    if (res == 1) {
                        $this.html("Shift Started Successfully...");

                        // Wait for 5 seconds before hiding the button and showing end_shift
                        setTimeout(function() {
                            $this.hide();
                            $("#end_shift").show();
                            $("#shift_started_at").show();
                            $(".show-shift-details").show();
                        }, 1000);
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
            if (!confirm("Are you sure want to end the shift?")) {
                return; // Stop execution if the user cancels
            }

            let $this = $(this);
            $this.html("Please wait...").prop("disabled", true);

            $.ajax({
                url: "ajax/shift_started",
                type: "GET",
                success: function(res) {
                    if (res == 1) {
                        $this.html("Shift Ended Successfully...");

                        // Wait for 1 second before hiding the button and showing the message
                        setTimeout(function() {
                            $this.hide();
                            $("#shift_ended_at").show();
                            $("#show-end-shift-message").show();
                        }, 1000);
                    } else {
                        alert("Shift Not Ended");
                        $this.html("End Shift").prop("disabled", false);
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