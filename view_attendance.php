<?php
  include("session.php");
  $obj = new Database();

  // Get employee ID from URL parameter
  $id = $_GET['id'];
  
  // Determine month (default to current month if not specified)
  if(isset($_GET['month'])){
      $month_name = $_GET['month'];
  } else {
      $month_name = date('F');
  }
  
  // Convert month name to number
  $month_num = date('n', strtotime($month_name));
  $year = date('Y');
  
  // Compute how many days to loop
  $firstOfMonth = "$year-$month_num-01";
  $totalInMonth = date('t', strtotime($firstOfMonth));
  $isCurrent = ($year == date('Y') && $month_num == date('n'));
  $lastDayToShow = $isCurrent ? date('j') : $totalInMonth;
  
  // Fetch employee name
  $employee_colName = "name";
  $employee_where = "id = $id";
  $obj->select('employee_info', $employee_colName, null, $employee_where, null, 0);
  $employee_result = $obj->getResult();
  $employee_name = $employee_result[0]['name'];
  
  // Fetch all records for this employee and month
  $where = "
      emp_id = '{$id}'
      AND YEAR(shift_date) = {$year}
      AND MONTH(shift_date) = {$month_num}
  ";
  $obj->select('attendance_record', '*', null, $where);
  $rows = $obj->getResult();
  
  // Index rows by normalized date string
  $byDate = [];
  foreach ($rows as $r) {
      $key = date('Y-m-d', strtotime($r['shift_date']));
      $byDate[$key] = $r;
  }
  
  // Prepare totals logic
  $hoursPerDay = $total_working_hours;
  $workingDays = getWorkingDaysInMonth($year, $month_num);
  $totalHoursNeeded = getWorkingHoursInMonth($year, $month_num, $hoursPerDay);
  $totalWorked = calculateEmployeeWorkedHours($id, $month_name, $obj);
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
                                            <option selected value="<?= $month_name ?>"><?= $month_name ?>
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
                            <h3><?=$employee_name?> Attendance Record (<?=$month_name?>)</h3>
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
                                        $countDays = 0;
                                        $countLeaves = 0;
                                        $total_seconds = 0;

                                        // Loop through each day
                                        $i = 0;
                                        for ($d = 1; $d <= $lastDayToShow; $d++) {
                                            // normalize to YYYY-MM-DD
                                            $current = date('Y-m-d', strtotime("$year-$month_num-$d"));
                                            $weekday = date('w', strtotime($current)); // 0 = Sunday

                                            // Sunday holiday
                                            if ($weekday === '0') {
                                                $i++;
                                                echo '<tr style="background:#f9f9f9;">
                                                        <td>' . $i . '</td>
                                                        <td>'. formatDate($current) .'</td>
                                                        <td colspan="4" class="text-center">Holiday</td>
                                                      </tr>';
                                                continue;
                                            }

                                            // If we have a record for this date
                                            if (isset($byDate[$current])) {
                                                extract($byDate[$current]);
                                                $i++;
                                                
                                                                                                
                                                // Check against official hours for styling
                                                $parts = explode(' ', $worked_hours);
                                                $hrs = (int)$parts[0]; // Assumes first part is hours
                                                $rowStyle = ($hrs < $official_working_hours) ? 'class="red-text"' : 'class="green-text"';
                                                $countDays ++;
                                                echo "<tr {$rowStyle}>
                                                        <td>{$i}</td>
                                                        <td>" . formatDate($shift_date) . "</td>
                                                        <td>{$start_time}</td>
                                                        <td>{$end_time}</td>
                                                        <td>{$worked_hours}</td>
                                                        <td>{$overtime}</td>
                                                      </tr>";
                                            } else {
                                                // No record: empty row
                                                $countLeaves++;
                                                $i++;

                                                echo "<tr class=\"red-text\">
                                                        <td>{$i}</td>
                                                        <td>" . formatDate($current) . "</td>
                                                        <td>--</td>
                                                        <td>--</td>
                                                        <td>--</td>
                                                        <td>--</td>
                                                      </tr>";
                                            }
                                        }

                                        ?>
                                            
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>Total Worked Hours:</strong></td>
                                                <td colspan="2"><strong><?=$totalWorked?></strong></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                Total Leaves <span class="text-danger"> ( <?=$countLeaves?> )  </span> Days.
                                                </td>
                                                <td colspan="2" class="text-end">
                                                <?=$employee_name?> has Worked ( <?=$countDays?> ) Days.
                                                </td>
                                                <td colspan="3">
                                                <?=$employee_name?> has Worked <br> ( <?=$totalWorked?> ) <br> Hours, Minutes.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end">
                                                <?=$employee_name?> need to have at-least
                                                </td>
                                                <td colspan="3">
                                                ( <?=$totalHoursNeeded?> ) <br> Working Hours.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                Official Working Days :
                                                </td>
                                                <td><?=$workingDays?></td>
                                                <td colspan="3">
                                                Official Working Hours <br> : <?=$totalHoursNeeded?> H
                                                </td>
                                            </tr>
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