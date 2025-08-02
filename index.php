<?php
include("session.php");
$obj = new Database();

$id = $empid;

$colName = "emp_id,shift_date,start_time,end_time,worked_hours,overtime";
$join = "";
$limit = 0;
$where = "attendance_record.emp_id=$id AND attendance_record.shift_date = CURDATE()";


$obj->select('attendance_record', $colName, $join, $where, null, $limit);
$result = $obj->getResult();

if (!empty($result)) {
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

    <title><?= $web_title ?></title>
    <!-- <link href="../../../../cdn.jsdelivr.net/npm/jvectormap%402.0.4/jquery-jvectormap.min.css" rel="stylesheet"> -->

    <style>
        #emp_attendance {
            max-height: 400px;
            overflow: auto;
        }
    </style>
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
                                    <a href="employee">
                                        <h2 class="fw-medium fs-8 text-white">
                                            <?php echo $count = $obj->count('employee_info', 'id', null); ?></h2>
                                        <h6 class="text-white mb-0 fw-medium">Total Employees</h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card bg-box position-relative text-bg-secondary">
                                <div class="card-body text-center">
                                    <a href="company">
                                        <h2 class="fw-medium fs-8 text-white">
                                            <?php echo $count = $obj->count('company', 'id', null); ?></h2>
                                        <h6 class="text-white mb-0 fw-medium">Companies</h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card bg-box position-relative text-bg-success">
                                <div class="card-body text-center">
                                    <a href="applied_leaves">
                                        <h2 class="fw-medium fs-8 text-white">
                                            <?php echo $count = $obj->count('employee_leaves', 'id', where: null); ?>
                                        </h2>
                                        <h6 class="text-white mb-0 fw-medium">Total Leaves Applied</h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card bg-box position-relative text-bg-warning">
                                <div class="card-body text-center">
                                    <a href="approved_leaves">
                                        <h2 class="fw-medium fs-8 text-white">
                                            <?php echo $count = $obj->count('employee_leaves', 'id', where: "status = 'Approved'"); ?>
                                        </h2>
                                        <h6 class="text-white mb-0 fw-medium">Approved Leaves</h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
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
                                                    <td class="ps-0 fs-3 text-muted">Company</td>
                                                    <td class="text-muted fs-3"><?= $curr_emp_company ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">Designation</td>
                                                    <td class="text-muted fs-3"><?= $curr_emp_designation ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">Employee Name</td>
                                                    <td class="text-muted fs-3"><?= $curr_emp_name ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">Date of Joining</td>
                                                    <td class="text-muted fs-3"><?= $curr_emp_date_of_joining ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">Salary</td>
                                                    <td class="text-muted fs-3">
                                                        <p id="show-salary" class="mt-2"
                                                            style="cursor: pointer; color: blue;">Show
                                                            Salary</p>
                                                        <span id="salary"
                                                            style="display: none;"><?= $curr_emp_salary ?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">CNIC Or PASSPORT</td>
                                                    <td class="text-muted fs-3"><?= $curr_emp_cnic_passport ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">Permenant Address</td>
                                                    <td class="text-muted fs-3"><?= $curr_emp_permanent_address ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">Country</td>
                                                    <td class="text-muted fs-3"><?= $curr_emp_country ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">Phone - 1</td>
                                                    <td class="text-muted fs-3"><?= $curr_emp_phone_1 ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">Phone - 2</td>
                                                    <td class="text-muted fs-3"><?= $curr_emp_phone_2 ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">Email</td>
                                                    <td class="text-muted fs-3"><?= $curr_emp_email ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">Bank Name</td>
                                                    <td class="text-muted fs-3"><?= $curr_emp_bank_name ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">Account Title</td>
                                                    <td class="text-muted fs-3"><?= $curr_emp_account_title ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 fs-3 text-muted">IBAN</td>
                                                    <td class="text-muted fs-3"><?= $curr_emp_iban ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
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

                                        <!--<div class="clock">-->
                                        <!--    <div class="outer-clock-face">-->
                                        <!--        <div class="marking marking-one"></div>-->
                                        <!--        <div class="marking marking-two"></div>-->
                                        <!--        <div class="marking marking-three"></div>-->
                                        <!--        <div class="marking marking-four"></div>-->
                                        <!--        <div class="inner-clock-face">-->
                                        <!--            <div class="hand hour-hand"></div>-->
                                        <!--            <div class="hand min-hand"></div>-->
                                        <!--            <div class="hand second-hand"></div>-->
                                        <!--        </div>-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                        <!--<script>-->
                                        <!--const secondHand = document.querySelector('.second-hand');-->
                                        <!--const minsHand = document.querySelector('.min-hand');-->
                                        <!--const hourHand = document.querySelector('.hour-hand');-->

                                        <!--function setDate() {-->
                                        <!--    const now = new Date();-->

                                        <!--    const seconds = now.getSeconds();-->
                                        <!--    const secondsDegrees = ((seconds / 60) * 360) + 90;-->
                                        <!--    secondHand.style.transform = `rotate(${secondsDegrees}deg)`;-->

                                        <!--    const mins = now.getMinutes();-->
                                        <!--    const minsDegrees = ((mins / 60) * 360) + ((seconds / 60) * 6) + 90;-->
                                        <!--    minsHand.style.transform = `rotate(${minsDegrees}deg)`;-->

                                        <!--    const hour = now.getHours();-->
                                        <!--    const hourDegrees = ((hour / 12) * 360) + ((mins / 60) * 30) + 90;-->
                                        <!--    hourHand.style.transform = `rotate(${hourDegrees}deg)`;-->
                                        <!--}-->

                                        <!--setInterval(setDate, 1000);-->

                                        <!--setDate();-->
                                        <!--</script>-->
                                        <script
                                            src="https://cdnjs.cloudflare.com/ajax/libs/snap.svg/0.5.1/snap.svg-min.js">
                                            </script>
                                        <div id="clock">
                                            <svg version="1.1" id="clock-svg" xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="600px"
                                                height="300px" viewBox="50 70 400 370" xml:space="preserve">
                                                <circle id="face" fill="#F4F3ED" cx="243.869" cy="250.796" r="130.8" />
                                                <path id="rim" fill="#383838" d="M243.869,101.184c-82.629,0-149.612,66.984-149.612,149.612c0,82.629,66.983,149.612,149.612,149.612
    S393.48,333.425,393.48,250.796S326.498,101.184,243.869,101.184z M243.869,386.455c-74.922,0-135.659-60.736-135.659-135.659
    c0-74.922,60.737-135.659,135.659-135.659c74.922,0,135.658,60.737,135.658,135.659
    C379.527,325.719,318.791,386.455,243.869,386.455z" />
                                                <g id="inner">
                                                    <g opacity="0.2">
                                                        <path fill="#C4C4C4" d="M243.869,114.648c-75.748,0-137.154,61.406-137.154,137.153c0,75.749,61.406,137.154,137.154,137.154
            c75.748,0,137.153-61.405,137.153-137.154C381.022,176.054,319.617,114.648,243.869,114.648z M243.869,382.56
            c-72.216,0-130.758-58.543-130.758-130.758s58.542-130.758,130.758-130.758c72.216,0,130.758,58.543,130.758,130.758
            S316.085,382.56,243.869,382.56z" />
                                                    </g>
                                                    <g>
                                                        <path fill="#282828" d="M243.869,113.637c-75.748,0-137.154,61.406-137.154,137.153c0,75.749,61.406,137.154,137.154,137.154
            c75.748,0,137.153-61.405,137.153-137.154C381.022,175.043,319.617,113.637,243.869,113.637z M243.869,381.548
            c-72.216,0-130.758-58.542-130.758-130.757c0-72.216,58.542-130.758,130.758-130.758c72.216,0,130.758,58.543,130.758,130.758
            C374.627,323.005,316.085,381.548,243.869,381.548z" />
                                                    </g>
                                                </g>
                                                <g id="markings">
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="243.5"
                                                        y1="139" x2="243.5" y2="133" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="231.817" y1="139.651" x2="231.19" y2="133.684" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="220.266" y1="141.52" x2="219.018" y2="135.65" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="208.973" y1="144.585" x2="207.119" y2="138.879" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="198.063" y1="148.814" x2="195.623" y2="143.333" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="187.655" y1="154.161" x2="184.655" y2="148.965" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="177.862" y1="160.566" x2="174.335" y2="155.712" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="168.792" y1="167.96" x2="164.778" y2="163.501" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="160.545" y1="176.262" x2="156.087" y2="172.246" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="153.211" y1="185.379" x2="148.358" y2="181.852" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="146.871" y1="195.214" x2="141.675" y2="192.213" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="141.593" y1="205.658" x2="136.112" y2="203.216" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="137.436" y1="216.596" x2="131.729" y2="214.741" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="134.445" y1="227.909" x2="128.576" y2="226.66" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="132.653" y1="239.472" x2="126.685" y2="238.843" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="132.079" y1="251.16" x2="126.079" y2="251.158" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="132.73" y1="262.843" x2="126.762" y2="263.468" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="134.598" y1="274.395" x2="128.729" y2="275.64" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="137.664" y1="285.688" x2="131.958" y2="287.539" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="141.893" y1="296.598" x2="136.412" y2="299.035" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="147.24" y1="307.006" x2="142.043" y2="310.004" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="153.645" y1="316.799" x2="148.791" y2="320.323" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="161.04" y1="325.868" x2="156.58" y2="329.881" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="169.341" y1="334.115" x2="165.325" y2="338.572" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="178.459" y1="341.449" x2="174.931" y2="346.302" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="188.294" y1="347.789" x2="185.292" y2="352.984" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="198.738" y1="353.066" x2="196.295" y2="358.548" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="209.676" y1="357.223" x2="207.82" y2="362.93" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="220.989" y1="360.214" x2="219.739" y2="366.084" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="232.552" y1="362.006" x2="231.922" y2="367.975" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="244.239" y1="362.58" x2="244.237" y2="368.582" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="255.921" y1="361.93" x2="256.547" y2="367.898" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="267.472" y1="360.062" x2="268.719" y2="365.932" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="278.765" y1="356.996" x2="280.619" y2="362.703" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="289.675" y1="352.767" x2="292.116" y2="358.248" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="300.083" y1="347.42" x2="303.083" y2="352.616" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="309.876" y1="341.015" x2="313.403" y2="345.869" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="318.946" y1="333.621" x2="322.96" y2="338.08" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="327.193" y1="325.319" x2="331.651" y2="329.334" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="334.527" y1="316.201" x2="339.38" y2="319.728" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="340.868" y1="306.367" x2="346.063" y2="309.367" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="346.146" y1="295.924" x2="351.626" y2="298.364" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="350.303" y1="284.986" x2="356.008" y2="286.84" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="353.294" y1="273.673" x2="359.162" y2="274.92" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="355.087" y1="262.11" x2="361.052" y2="262.737" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="356"
                                                        y1="250.5" x2="362" y2="250.5" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="355.355" y1="238.781" x2="361.323" y2="238.153" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="353.489" y1="227.193" x2="359.359" y2="225.945" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="350.422" y1="215.864" x2="356.129" y2="214.01" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="346.188" y1="204.918" x2="351.669" y2="202.477" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="340.833" y1="194.474" x2="346.029" y2="191.474" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="334.415" y1="184.647" x2="339.269" y2="181.12" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="327.004" y1="175.545" x2="331.463" y2="171.529" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="318.684" y1="167.268" x2="322.699" y2="162.807" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="309.543" y1="159.905" x2="313.07" y2="155.049" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="299.684" y1="153.538" x2="302.683" y2="148.34" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="289.212" y1="148.237" x2="291.652" y2="142.753" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="278.245" y1="144.059" x2="280.097" y2="138.351" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="266.9"
                                                        y1="141.05" x2="268.145" y2="135.179" />
                                                    <line fill="none" stroke="#3F3F3F" stroke-miterlimit="10"
                                                        x1="255.302" y1="139.244" x2="255.927" y2="133.275" />
                                                    <polygon fill="#3F3F3F"
                                                        points="247.391,133 243.5,141.05 239.609,133 	" />
                                                    <polygon fill="#3F3F3F"
                                                        points="188.022,147.021 188.677,155.938 181.283,150.912 	" />
                                                    <polygon fill="#3F3F3F"
                                                        points="143.617,188.848 148.643,196.243 139.726,195.588 	" />
                                                    <polygon fill="#3F3F3F"
                                                        points="126.074,247.273 134.125,251.165 126.076,255.056 	" />
                                                    <polygon fill="#3F3F3F"
                                                        points="140.095,306.644 149.013,305.988 143.988,313.382 	" />
                                                    <polygon fill="#3F3F3F"
                                                        points="181.922,351.049 189.318,346.022 188.663,354.938 	" />
                                                    <polygon fill="#3F3F3F"
                                                        points="240.349,368.591 244.24,360.54 248.13,368.589 	" />
                                                    <polygon fill="#3F3F3F"
                                                        points="299.718,354.569 299.062,345.652 306.457,350.677 	" />
                                                    <polygon fill="#3F3F3F"
                                                        points="344.123,312.742 339.096,305.348 348.012,306.002 	" />
                                                    <polygon fill="#3F3F3F"
                                                        points="362,254.316 353.951,250.426 362,246.534 	" />
                                                    <polygon fill="#3F3F3F"
                                                        points="347.934,194.779 339.018,195.435 344.042,188.04 	" />
                                                    <polygon fill="#3F3F3F"
                                                        points="305.984,150.252 298.59,155.277 299.244,146.361 	" />
                                                    <rect x="282" y="152.98" fill="none" width="17.366"
                                                        height="27.947" />
                                                    <text transform="matrix(1 0 0 1 282 174.4307)" fill="#303030"
                                                        font-family="'Futura-Medium'" font-size="26">1</text>
                                                    <rect x="320.699" y="188.474" fill="none" width="17.202"
                                                        height="26.267" />
                                                    <text transform="matrix(1 0 0 1 320.6987 209.9229)" fill="#303030"
                                                        font-family="'Futura-Medium'" font-size="26">2</text>
                                                    <rect x="335.04" y="238.872" fill="none" width="21.03"
                                                        height="24.585" />
                                                    <text transform="matrix(1 0 0 1 335.0396 260.3213)" fill="#303030"
                                                        font-family="'Futura-Medium'" font-size="26">3</text>
                                                    <rect x="319.699" y="290.242" fill="none" width="17.202"
                                                        height="23.557" />
                                                    <text transform="matrix(1 0 0 1 319.6987 311.6914)" fill="#303030"
                                                        font-family="'Futura-Medium'" font-size="26">4</text>
                                                    <rect x="284.5" y="323.319" fill="none" width="19.212"
                                                        height="22.511" />
                                                    <text transform="matrix(1 0 0 1 284.5 344.7695)" fill="#303030"
                                                        font-family="'Futura-Medium'" font-size="26">5</text>
                                                    <rect x="235.552" y="336.08" fill="none" width="19.938"
                                                        height="24.15" />
                                                    <text transform="matrix(1 0 0 1 235.5522 357.5293)" fill="#303030"
                                                        font-family="'Futura-Medium'" font-size="26">6</text>
                                                    <rect x="189.373" y="322.319" fill="none" width="19.673"
                                                        height="25.003" />
                                                    <text transform="matrix(1 0 0 1 189.3726 343.7695)" fill="#303030"
                                                        font-family="'Futura-Medium'" font-size="26">7</text>
                                                    <rect x="151.066" y="287.539" fill="none" width="17.726"
                                                        height="25.203" />
                                                    <text transform="matrix(1 0 0 1 151.0664 308.9883)" fill="#303030"
                                                        font-family="'Futura-Medium'" font-size="26">8</text>
                                                    <rect x="136.392" y="241.25" fill="none" width="20.696"
                                                        height="22.348" />
                                                    <text transform="matrix(1 0 0 1 136.3916 262.6992)" fill="#303030"
                                                        font-family="'Futura-Medium'" font-size="26">9</text>
                                                    <rect x="149.066" y="191.474" fill="none" width="36.554"
                                                        height="27.122" />
                                                    <text transform="matrix(1 0 0 1 149.0664 212.9229)" fill="#303030"
                                                        font-family="'Futura-Medium'" font-size="26">10</text>
                                                    <rect x="184.967" y="158.518" fill="none" width="36.021"
                                                        height="27.13" />
                                                    <text transform="matrix(1 0 0 1 184.9673 179.9668)" fill="#303030"
                                                        font-family="'Futura-Medium'" font-size="26">11</text>
                                                    <rect x="225.723" y="144.514" fill="none" width="37.029"
                                                        height="29.25" />
                                                    <text transform="matrix(1 0 0 1 225.7227 165.9639)" fill="#303030"
                                                        font-family="'Futura-Medium'" font-size="26">12</text>
                                                </g>
                                                <path id="hours" fill="#3A3A3A" d="M242.515,270.21c-0.44,0-0.856-0.355-0.926-0.79l-3.156-19.811c-0.069-0.435-0.103-1.149-0.074-1.588
    l4.038-62.009c0.03-0.439,0.414-0.798,0.854-0.798h0.5c0.44,0,0.823,0.359,0.852,0.798l4.042,62.205
    c0.028,0.439-0.015,1.152-0.097,1.584l-3.712,19.623c-0.082,0.433-0.508,0.786-0.948,0.786H242.515z" />
                                                <path id="minutes" fill="#3A3A3A" d="M247.862,249.75l-2.866,24.244c-0.099,1.198-0.498,2.18-1.497,2.179c-0.999,0-1.397-0.98-1.498-2.179
            l-2.861-24.508c-0.099-1.199,3.479-93.985,3.479-93.985c0.036-1.201-0.117-2.183,0.881-2.183c0.999,0,0.847,0.982,0.882,2.183
            L247.862,249.75z" />
                                                <g id="seconds">
                                                    <line fill="none" stroke="#BF4116" stroke-miterlimit="10" x1="243.5"
                                                        y1="143" x2="243.5" y2="266" />
                                                    <circle fill="none" stroke="#BF4116" stroke-miterlimit="10"
                                                        cx="243.5" cy="271" r="5" />
                                                    <circle fill="#BF4116" cx="243.5" cy="251" r="3.917" />
                                                </g>
                                            </svg>
                                        </div>
                                        <style>
                                            svg {
                                                display: block;
                                                margin: auto;
                                            }
                                        </style>
                                        <script>
                                            var s = Snap(document.getElementById("clock-svg"));

                                            var seconds = s.select("#seconds"),
                                                minutes = s.select("#minutes"),
                                                hours = s.select("#hours"),
                                                rim = s.select("#rim"),
                                                face = {
                                                    elem: s.select("#face"),
                                                    cx: s.select("#face").getBBox().cx,
                                                    cy: s.select("#face").getBBox().cy,
                                                },
                                                angle = 0,
                                                easing = function (a) {
                                                    return a == !!a ? a : Math.pow(4, -10 * a) * Math.sin((a - .075) * 2 *
                                                        Math.PI / .3) + 1;
                                                };

                                            var sshadow = seconds.clone(),
                                                mshadow = minutes.clone(),
                                                hshadow = hours.clone(),
                                                rshadow = rim.clone(),
                                                shadows = [sshadow, mshadow, hshadow];

                                            //Insert shadows before their respective opaque pals
                                            seconds.before(sshadow);
                                            minutes.before(mshadow);
                                            hours.before(hshadow);
                                            rim.before(rshadow);

                                            //Create a filter to make a blurry black version of a thing
                                            var filter = Snap.filter.blur(0.1) + Snap.filter.brightness(0);

                                            //Add the filter, shift and opacity to each of the shadows
                                            shadows.forEach(function (el) {
                                                el.attr({
                                                    transform: "translate(0, 2)",
                                                    opacity: 0.2,
                                                    filter: s.filter(filter)
                                                });
                                            })

                                            rshadow.attr({
                                                transform: "translate(0, 8) ",
                                                opacity: 0.5,
                                                filter: s.filter(Snap.filter.blur(0, 8) + Snap.filter.brightness(
                                                    0)),
                                            })

                                            function update() {
                                                var time = new Date();
                                                setHours(time);
                                                setMinutes(time);
                                                setSeconds(time);
                                            }

                                            function setHours(t) {
                                                var hour = t.getHours();
                                                hour %= 12;
                                                hour += Math.floor(t.getMinutes() / 10) / 6;
                                                var angle = hour * 360 / 12;
                                                hours.animate({
                                                    transform: "rotate(" + angle + " 244 251)"
                                                },
                                                    100,
                                                    mina.linear,
                                                    function () {
                                                        if (angle === 360) {
                                                            hours.attr({
                                                                transform: "rotate(" + 0 + " " + face.cx + " " +
                                                                    face.cy + ")"
                                                            });
                                                            hshadow.attr({
                                                                transform: "translate(0, 2) rotate(" + 0 + " " +
                                                                    face.cx + " " + face.cy + 2 + ")"
                                                            });
                                                        }
                                                    }
                                                );
                                                hshadow.animate({
                                                    transform: "translate(0, 2) rotate(" + angle + " " + face.cx +
                                                        " " + face.cy + 2 + ")"
                                                },
                                                    100,
                                                    mina.linear
                                                );
                                            }

                                            function setMinutes(t) {
                                                var minute = t.getMinutes();
                                                minute %= 60;
                                                minute += Math.floor(t.getSeconds() / 10) / 6;
                                                var angle = minute * 360 / 60;
                                                minutes.animate({
                                                    transform: "rotate(" + angle + " " + face.cx + " " + face.cy +
                                                        ")"
                                                },
                                                    100,
                                                    mina.linear,
                                                    function () {
                                                        if (angle === 360) {
                                                            minutes.attr({
                                                                transform: "rotate(" + 0 + " " + face.cx + " " +
                                                                    face.cy + ")"
                                                            });
                                                            mshadow.attr({
                                                                transform: "translate(0, 2) rotate(" + 0 + " " +
                                                                    face.cx + " " + face.cy + 2 + ")"
                                                            });
                                                        }
                                                    }
                                                );
                                                mshadow.animate({
                                                    transform: "translate(0, 2) rotate(" + angle + " " + face.cx +
                                                        " " + face.cy + 2 + ")"
                                                },
                                                    100,
                                                    mina.linear
                                                );
                                            }

                                            function setSeconds(t) {
                                                t = t.getSeconds();
                                                t %= 60;
                                                var angle = t * 360 / 60;
                                                //if ticking over to 0 seconds, animate angle to 360 and then switch angle to 0
                                                if (angle === 0) angle = 360;
                                                seconds.animate({
                                                    transform: "rotate(" + angle + " " + face.cx + " " + face.cy +
                                                        ")"
                                                },
                                                    600,
                                                    easing,
                                                    function () {
                                                        if (angle === 360) {
                                                            seconds.attr({
                                                                transform: "rotate(" + 0 + " " + face.cx + " " +
                                                                    face.cy + ")"
                                                            });
                                                            sshadow.attr({
                                                                transform: "translate(0, 2) rotate(" + 0 + " " +
                                                                    face.cx + " " + face.cy + 2 + ")"
                                                            });
                                                        }
                                                    }
                                                );
                                                sshadow.animate({
                                                    transform: "translate(0, 2) rotate(" + angle + " " + face.cx +
                                                        " " + face.cy + 2 + ")"
                                                },
                                                    600,
                                                    easing
                                                );
                                            }
                                            setInterval(update, 1000);
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
                                            <span class="text-success">See you tomorrow !</span>
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
                                            <span class="text-success">See you tomorrow!</span>
                                        </p>
                                    <?php } ?>




                                </div>
                            </div>
                            <div class="card w-100" style="height: 500px;overflow: hidden;overflow-y: auto;">
                                <div class="card-body">
                                    <div class="d-md-flex no-block">
                                        <div>
                                            <h4 class="card-title">Attendance Report <?= $current_year = date("Y"); ?>
                                            </h4>

                                            <table class="table mb-0 align-middle text-nowrap">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <p class="card-subtitle">Total Working Hours
                                                                <span><?= $total_working_hours ?></span>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p class="card-subtitle">Break Timings <span> (
                                                                    <?= $break_timing ?> )</span></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p class="card-subtitle">Total Working Hours (
                                                                <?= $total_working_hours ?> ) - with <?= $break_time ?>
                                                                hour Break Time.
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p class="card-subtitle">Official Working Hours (
                                                                <?= $official_working_hours ?> )
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>


                                        </div>
                                        <div class="ms-auto">
                                            <select class="form-select" id="monthSelect">
                                                <?php
                                                $current_month = date("F"); // Returns full month name (e.g., "March")
                                                ?>
                                                <option selected="<?= $current_month ?>"><?= $current_month ?></option>
                                                <option value="January">January</option>
                                                <option value="February">February</option>
                                                <option value="March">March</option>
                                                <option value="April">April</option>
                                                <option value="May">May</option>
                                                <option value="June">June</option>
                                                <option value="July">July</option>
                                                <option value="August">August</option>
                                                <option value="September">September</option>
                                                <option value="October">October</option>
                                                <option value="November">November</option>
                                                <option value="December">December</option>
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
                                    <div class="table-responsive" id="emp_attendance">
                                        <table class="table mb-0 align-middle text-nowrap" id="attendance_record">

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
        $(document).ready(function () {

            // function loadTable() {
            //     $("#attendance_record").html('<div class="loader">Loading Data...</div>'); // Show loader before AJAX call

            //     $.ajax({
            //         url: "emp_attendance_record",
            //         type: "POST",
            //         success: function (data) {
            //             $("#attendance_record").html(data); // Replace loader with table data
            //         },
            //         error: function () {
            //             $("#attendance_record").html("<p>Error loading data.</p>"); // Handle errors
            //         }
            //     });
            // }

            // // Load Table Records on Page Load
            // loadTable();

            function loadTable(month = null) {
                $("#attendance_record").html(
                    '<div class="loader">Loading Data...</div>'); // Show loader before AJAX call

                // alert(month);
                $.ajax({
                    url: "emp_attendance_record",
                    type: "POST",
                    data: {
                        month: month
                    }, // Send selected month if available
                    success: function (data) {
                        $("#attendance_record").html(data); // Replace loader with table data
                    },
                    error: function () {
                        $("#attendance_record").html("<p>Error loading data.</p>"); // Handle errors
                    }
                });
            }

            // Load Table Records on Page Load with Current Month
            loadTable($("#monthSelect").val());

            // Fetch Data When Month Changes
            $("#monthSelect").change(function () {
                let selectedMonth = $(this).val();
                loadTable(selectedMonth);
            });


            $("#show-salary").on("click", function () {
                $("#salary").show(); // Show the salary
                $(this).hide(); // Hide "Show Salary" after clicking
            });

            $(document).on("click", "#start_shift", function () {
                let $this = $(this);
                $this.html("Please wait...").prop("disabled", true);

                var empid = $("#start_shift").data("id");
                var selectedMonth = $("#monthSelect").val(); // Get the currently selected month

                $.ajax({
                    url: "ajax/shift_started",
                    type: "POST",
                    dataType: "json", // Expect JSON response
                    data: {
                        Empid: empid
                    },
                    success: function (res) {
                        console.log('Response:', res);

                        if (res.status == 1) {
                            $this.html("Shift Started Successfully...");

                            // Update shift start time
                            $("#shift_started_at").html("Shift Start At: " + res.start_time)
                                .show();

                            setTimeout(function () {
                                $this.hide();
                                $("#end_shift").show();
                                $(".show-shift-details").show();
                            }, 1000);

                            // Call loadTable with the selected month to refresh the records
                            loadTable(selectedMonth);
                        } else if (res.status == 2) {
                            alert("A shift must be started from the office.");
                            $this.html("Start Shift").prop("disabled", false);
                        } else {
                            alert("Shift Not Started");
                            $this.html("Start Shift").prop("disabled", false);
                        }
                    },
                    error: function () {
                        alert("Error occurred. Please try again.");
                        $this.html("Start Shift").prop("disabled", false);
                    }
                });
            });


            $(document).on("click", "#end_shift", function () {
                let $this = $(this);
                $this.html("Please wait...").prop("disabled", true);

                var empid = $("#end_shift").data("id");
                var selectedMonth = $("#monthSelect").val(); // Get the currently selected month

                $.ajax({
                    url: "ajax/end_shift",
                    type: "POST",
                    dataType: "json", // Expect JSON response
                    data: {
                        Empid: empid
                    },
                    success: function (res) {
                        console.log('Response:', res);

                        if (res.status == 1) {
                            $this.html("Shift Ended Successfully...");

                            // Update shift start time
                            $("#shift_ended_at").html(
                                "|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shift Ended At: " +
                                res.end_time)
                                .show();

                            setTimeout(function () {
                                $this.hide();
                                $(".show-shift-details").show();
                                $("#show-end-shift-message").show();
                            }, 1000);

                            loadTable(selectedMonth);

                        } else if (res.status == 2) {
                            alert("A shift must be end from the office.");
                            $this.html("Start Shift").prop("disabled", false);
                        } else {
                            alert("Shift Not Ended");
                            $this.html("Start End").prop("disabled", false);
                        }
                    },
                    error: function () {
                        alert("Error occurred. Please try again.");
                        $this.html("End Shift").prop("disabled", false);
                    }
                });
            });


        });
    </script>
</body>



</html>