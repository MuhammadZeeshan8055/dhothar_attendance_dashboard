<?php
  include("session.php");
  $obj = new Database();

    $id=$_GET['id'];

    
    if(isset($_GET['month'])){
        $month_record=$_GET['month'];
    }else{
        $month_record=date('F');
    }

    $where = "emp_id='$id' and month = '$month_record'"; // Match the exact month name
    $limit = 0;

    $obj->select('attendance_record', "*", null, $where, null, null);
    $result = $obj->getResult();


    $employee_colName = "name"; // Select all columns
    $employee_where   = "id = $id"; // Adjust your condition accordingly
    
    
    $obj->select('employee_info',$employee_colName,null,$employee_where,null,0);
    $employee_result = $obj->getResult();
    
    $employee = $employee_result[0];

    $employee_name = $employee['name'];




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
    <style>
    .red-text td {
        color: red !important;
    }

    .green-text td {
        color: green !important;
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
                    <div class="d-md-flex align-items-center justify-content-between mb-7">
                        <div class="mb-4 mb-md-0">
                            <h4 class="fs-6 mb-0">Attendance Report</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a class="text-muted text-decoration-none" href="#">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Attendance Report</li>
                                </ol>
                            </nav>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <form action="" method="GET">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

                                        <select name="month" class="form-select" id="monthSelect"
                                            onchange="this.form.submit()">
                                            <option selected value="<?= $month_record ?>"><?= $month_record ?>
                                            </option>
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
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">

                            <h3><?=$employee_name?> Attendance Record (<?=$month_record?>)</h3>

                        </div>
                    </div>

                    <!-- Row -->
                    <div class="row">

                        <div class="col-12">
                            <div class="card-body pt-8">
                                <div class="table-responsive">
                                    <table class="table mb-0 align-middle text-nowrap" id="attendance_record">
                                        <tr>
                                            <thead>
                                                <th>S.no</th>
                                                <th>Shift Date</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Worked Hours</th>
                                                <th>Overtime</th>
                                            </thead>
                                        </tr>
                                        <tbody>
                                            <?php
                                            if (!empty($result)) {
                                                $i=0;
                                                foreach ($result as 
                                                list("id"=>$id,"shift_date"=>$shift_date,"start_time"=>$start_time,
                                                "end_time"=>$end_time,"worked_hours"=>$worked_hours,'overtime'=>$overtime)) {
                                                    $i++;

                                                    $parts = explode(' ', $worked_hours);
                                                    $hours = (int)$parts[0]; // assumes the first part is the hours number
                                            
                                                    // Set the style if worked hours are below 9
                                                    $rowStyle = ($hours < $official_working_hours) ? 'class="red-text"' : 'class="green-text"';
                                            ?>
                                            <tr <?=$rowStyle?>>
                                                <td><?=$i?></td>
                                                <td><?=formatDate($shift_date)?></td>
                                                <td><?=$start_time?></td>
                                                <td><?=$end_time?></td>
                                                <td><?=$worked_hours?></td>
                                                <td><?=$overtime?></td>
                                            </tr>


                                            <?php
                                                }
                                            }else{
                                                ?>
                                                
                                            <tr>
                                                <td class="text-danger text-center" colspan="6"><strong>No Record Found For This Month</strong></td>
                                            </tr>

                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- End Row -->
                </div>
            </div>

        </div>



    </div>
    <div class="dark-transparent sidebartoggler"></div>
    <!-- Import Js Files -->
    <script
        src="https://bootstrapdemos.wrappixel.com/monster/dist/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js">
    </script>
    <script src="https://bootstrapdemos.wrappixel.com/monster/dist/assets/libs/simplebar/dist/simplebar.min.js">
    </script>
    <!-- solar icons -->
    <script src="assets/js/iconify-icon.min.js"></script>
    <script src="https://bootstrapdemos.wrappixel.com/monster/dist/assets/js/theme/app.init.js"></script>
    <script src="https://bootstrapdemos.wrappixel.com/monster/dist/assets/js/theme/theme.js"></script>
    <script src="https://bootstrapdemos.wrappixel.com/monster/dist/assets/js/theme/app.min.js"></script>
    <script src="https://bootstrapdemos.wrappixel.com/monster/dist/assets/js/theme/sidebarmenu.js"></script>

    <!-- solar icons -->
    <script src="../../../../cdn.jsdelivr.net/npm/iconify-icon%401.0.8/dist/iconify-icon.min.js"></script>
</body>



</html>