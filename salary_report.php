<?php
  include("session.php");
  $obj = new Database();

  if(isset($_GET['search_month'])){
    $month = $_GET['search_month'];
  }else{
    $month = date('F', strtotime('first day of last month'));;
  }

  $colName = "attendance_summary.*,salary_sheet.*,employee_info.id,employee_info.name,employee_info.salary";
  $where = "attendance_summary.month='$month' and salary_sheet.month='$month'";
  $join = 'salary_sheet ON salary_sheet.emp_id = attendance_summary.emp_id JOIN employee_info ON employee_info.id = attendance_summary.emp_id';
  $limit = 0;
  
  $obj->select('attendance_summary',$colName,$join,$where,null,$limit);
      $result = $obj->getResult();

    
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
                        <div class="col-md-6">
                            <label for="">Search Salary Record</label>
                            <hr>
                            <form action="">
                                <div class="form-group">
                                    <div class="d-flex align-items-center justify-content-between gap-6">
                                        <select name="search_month" onchange="this.form.submit()" class="form-select border fs-3" aria-label="Default select example">
                                            <?php
                                                if(isset($_GET['search_month'])){
                                                    ?>

                                                    <option value="<?=$_GET['search_month']?>"><?=$_GET['search_month']?></option>

                                                    <?php
                                                }else{
                                                    ?>
                                                    <option value="">Search Month</option>

                                                    <?php
                                                }
                                            ?>
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
                            </form>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                                <div class="company-list">
                                    <form method="POST" action="generate_salary_slip" id="companyForm">
                                        <label for="">Generate Salary</label>
                                        <hr>
                                        <div class="form-group">
                                            <div class="d-flex align-items-center justify-content-between gap-6">
                                                <select name="month" class="form-select border fs-3" aria-label="Default select example">
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
                                        <br>
                                        <div class="form-group">
                                            <input type="submit" name="generate_salary_slip" class="btn btn-primary" value="Generate Salary Details">
                                        </div>
                                    </form>
                                </div>
                        

                        </div>
                    </div>

                    <div class="row">

                        <!-- <div class="col-md-6">

                            <a href="generate_salary_slip?month=April" target="_blank" class="btn btn-success">Generate Salary Details</a>

                        </div> -->

                        <div class="col-12 pt-3">
                            <div class="card-body pt-8">
                                <div class="table-responsive">
                                <table class="table mb-5 align-middle text-nowrap" id="attendance_record">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Salary</th>
                                                <th>Wording Days</th>
                                                <th>Shortfall in Days</th>
                                                <th>Expected Working Hours</th>
                                                <th>Actual Working Hours</th>
                                                <th>Shortfall Mins</th>
                                                <th>Hourly Rate</th>
                                                <th>Minute Rate</th>
                                                <th>Calculated Salary</th>
                                                <th>Deducted Salary</th>
                                                <th>Month</th>
                                                <th>Year</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($result as $row): ?>
                                                <tr>
                                                    <td><?=$row['name']?></td>
                                                    <td><?=$row['salary']?></td>
                                                    <td><?=$row['working_days']?></td>
                                                    <td><?=$row['shortfall_in_days']?></td>
                                                    <td><?=$row['expected_hours']?></td>
                                                    <td><?=$row['actual_hours']?></td>
                                                    <td><?=$row['shortfall_mins']?></td>
                                                    <td><?=$row['hourly_rate']?></td>
                                                    <td><?=$row['minute_rate']?></td>
                                                    <td><?=$row['calculated_salary']?></td>
                                                    <td><?=$row['deducted_salary']?></td>
                                                    <td><?=$row['month']?></td>
                                                    <td><?=$row['year']?></td>
                                                </tr>
                                            <?php endforeach; ?>
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