<?php
include("session.php");
$obj = new Database();

$colName = "employee_leaves.*,employee_info.name";
$join = "employee_info on employee_leaves.emp_id=employee_info.id";
$where = "employee_leaves.status='Declined'";
$limit = 0;

$obj->select('employee_leaves', $colName, $join, $where, null, $limit);
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

    <title><?= $web_title ?></title>
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
                            <h4 class="fs-6 mb-0">Leaves</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a class="text-muted text-decoration-none" href="#">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Declined Leave</li>
                                </ol>
                            </nav>
                        </div>

                    </div>
                    <!-- Row -->


                    <div class="row">

                        <?php if (!empty($msg)): ?>
                            <div id="delete-msg">
                                <p class="text-success text-center"><strong><?= $msg ?></strong></p>
                            </div>
                            <script>
                                // Hide the message after 3 seconds
                                setTimeout(function () {
                                    document.getElementById('delete-msg').style.display = 'none';
                                }, 3000);
                            </script>
                        <?php endif; ?>


                        <div class="col-12 pt-3">
                            <div class="card-body pt-8">
                                <div class="table-responsive">
                                    <table class="table mb-0 align-middle text-nowrap" id="attendance_record">
                                        <tr>
                                            <thead>
                                                <th>S.no</th>
                                                <th>Name</th>
                                                <th>From Date</th>
                                                <th>To Date</th>
                                                <th>Total</th>
                                                <th>Leave Type</th>
                                                <th>Leave Time</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                            </thead>
                                        </tr>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            if (!empty($result)) {
                                                foreach ($result as $record) {
                                                    $i++;
                                                    ?>
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td><?= $record['name']; ?></td>
                                                        <td><?= $record['from_date']; ?></td>
                                                        <td><?= $record['to_date']; ?></td>
                                                        <td><?= $record['total']; ?></td>
                                                        <td><?= $record['leave_type']; ?></td>
                                                        <td><?= $record['leave_time']; ?></td>
                                                        <td><?= $record['description']; ?></td>
                                                        <td><?= $record['status']; ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="9" class="text-center">No Record Found</td>
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