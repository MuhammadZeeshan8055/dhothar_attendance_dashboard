<?php
include("session.php");

$obj = new Database();

$msg = "";
$editable = false;

$employee_id = "";
$from_date = "";
$to_date = "";
$total = "";
$half_leave = "";
$short_leave = "";
$leave_time = "";
$description = "";
$status = "";

if (isset($_POST['add_leave'])) {

    $leave_type = $_POST['leave_type'] ?? '';

    if($leave_type == 'half_leave'){
        $leave_time = 4;
    }else{
        $leave_time = 2;
    }

    $data = [
        "emp_id" => $_POST['employee_id'],
        "from_date" => $_POST['from_date'],
        "to_date" => $_POST['to_date'],
        "total" => $_POST['total'],
        "leave_type" => $leave_type,
        "leave_time" => $leave_time,
        "description" => $_POST['description'],
    ];

    $message = $obj->insert("employee_leaves", $data)
        ? "Leave Record Inserted Successfully."
        : "Leave is Not Inserted Successfully.";

    $msg = $message;
}

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $editable = true;

    $colName = "*"; // Select all columns
    $join = null; // No join required
    $limit = 0;
    $where = "id = $id"; // Adjust your condition accordingly


    $obj->select('employee_info', $colName, $join, $where, null, $limit);
    $result = $obj->getResult();

    $employee = $result[0];

    $employee_id = $employee['employee_id'];
    $from_date = $employee['from_date'];
    $to_date = $employee['to_date'];
    $total = $employee['total'];
    $half_leave = $employee['half_leave'];
    $short_leave = $employee['short_leave'];
    $leave_time = $employee['leave_time'];
    $description = $employee['description'];
    $status = $employee['status'];

}

if (isset($_POST['update_leave_info'])) {
    $id = $_POST['employee_id'];
    $data = [
        "employee_id" => $_POST['employee_id'],
        "from_date" => $_POST['from_date'],
        "to_date" => $_POST['to_date'],
        "total" => $_POST['total'],
        "half_leave" => $_POST['half_leave'],
        "short_leave" => $_POST['short_leave'],
        "leave_time" => $_POST['leave_time'],
        "description" => $_POST['description'],
        "status" => $_POST['status']
    ];

    $message = $obj->update('employee_info', $data, 'id=' . $id)
        ? "Leave Data Updated Successfully."
        : "Leave Data is Not Updated Successfully.";

    echo "<h2>$message</h2>";
}

$colName = "*";
$join = null;
$limit = 0;

$obj->select('company', $colName, $join, null, null, $limit);
$company_names = $obj->getResult();


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
                            <h4 class="fs-6 mb-0"><?= ($editable) ? 'Edit Leave' : 'Add Leave'; ?></h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a class="text-muted text-decoration-none" href="#">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <?= ($editable) ? 'Edit Leave' : 'Add Leave'; ?>
                                    </li>
                                </ol>
                            </nav>
                        </div>

                    </div>
                    <!-- Row -->
                    <div class="row">

                        <div class="col-12">
                            <!-- start Employee Timing -->
                            <div class="card">

                                <p class="text-success text-center text-bold"><strong><?= $msg ?></strong></p>

                                <form class="form-horizontal r-separator" method="post" action="add_leave">
                                    <div class="card-body">
                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="hidden" class="form-control" name="employee_id"
                                                        required value="<?= $empid ?>" id="inputText11" />
                                                    <?php
                                                    if ($editable) {
                                                        ?>
                                                        <input type="hidden" class="form-control" name="employee_id"
                                                            required value="<?= $empid ?>" id="inputText11" />
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="from_date" class="col-3 text-end col-form-label">From Date
                                                    <span style="color:red">*</span></label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="date" class="form-control" name="from_date"
                                                        id="from_date" value="<?= $from_date ?>" required />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="to_date" class="col-3 text-end col-form-label">To Date <span
                                                        style="color:red">*</span></label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="date" class="form-control" name="to_date" id="to_date"
                                                        value="<?= $to_date ?>" required />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="total" class="col-3 text-end col-form-label">Total Days
                                                    <span style="color:red">*</span></label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="text" class="form-control" name="total" id="total"
                                                        value="<?= $total ?>" required readonly />
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            function calculateDays() {
                                                const fromDate = new Date(document.getElementById('from_date').value);
                                                const toDate = new Date(document.getElementById('to_date').value);
                                                const totalField = document.getElementById('total');

                                                if (!isNaN(fromDate) && !isNaN(toDate)) {
                                                    // Calculate difference in time
                                                    const timeDiff = toDate - fromDate;
                                                    const dayDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));

                                                    // Add 1 to include the start day
                                                    totalField.value = (dayDiff >= 0) ? (dayDiff + 1) : 0;
                                                } else {
                                                    totalField.value = '';
                                                }
                                            }

                                            // Attach event listeners
                                            document.getElementById('from_date').addEventListener('change', calculateDays);
                                            document.getElementById('to_date').addEventListener('change', calculateDays);

                                            // Optional: run on page load
                                            window.addEventListener('load', calculateDays);
                                        </script>

                                        <div class="form-group mb-3">
                                            <div class="row align-items-center mb-2">
                                                <label class="col-3 text-end col-form-label">Half Day</label>
                                                <div class="col-3 border-start pb-2 pt-2">
                                                    <input type="radio" name="leave_type" value="half_leave" />
                                                </div>
                                            </div>
                                            <div class="row align-items-center">
                                                <label class="col-3 text-end col-form-label">Short Day</label>
                                                <div class="col-3 border-start pb-2 pt-2">
                                                    <input type="radio" name="leave_type" value="short_leave" />
                                                </div>
                                            </div>
                                        </div>


                                        <!-- <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="inputTime1" class="col-3 text-end  col-form-label">Leave
                                                    Time</label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="text" class="form-control" name="leave_time"
                                                        value="<?= $leave_time ?>" id="inputTime1" readonly />
                                                </div>
                                            </div>
                                        </div> -->

                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="description" class="col-3 text-end col-form-label">
                                                    Description <span style="color:red">*</span>
                                                </label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <textarea class="form-control" name="description" id="description"
                                                        required
                                                        placeholder="Enter Description Here"><?= $description ?></textarea>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="p-3 border-top">
                                        <div class="form-group mb-0 text-end">
                                            <button type="submit"
                                                name="<?= ($editable) ? 'update_leave_info' : 'add_leave'; ?>"
                                                class="btn btn-primary">
                                                <?= ($editable) ? 'Update' : 'Save'; ?>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- end Employee Timing -->
                        </div>

                    </div>
                    <!-- End Row -->
                </div>
            </div>

        </div>

        <!--  Search Bar -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-bottom">
                        <input type="search" class="form-control" placeholder="Search here" id="search" />
                        <a href="javascript:void(0)" data-bs-dismiss="modal" class="lh-1">
                            <i class="ti ti-x fs-5 ms-3"></i>
                        </a>
                    </div>
                    <div class="modal-body message-body" data-simplebar="">
                        <h5 class="mb-0 fs-5 p-1">Quick Page Links</h5>
                        <ul class="list mb-0 py-2">
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">Analytics</span>
                                    <span class="fs-2 d-block text-body-secondary">/dashboards/dashboard1</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">eCommerce</span>
                                    <span class="fs-2 d-block text-body-secondary">/dashboards/dashboard2</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">CRM</span>
                                    <span class="fs-2 d-block text-body-secondary">/dashboards/dashboard3</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">Contacts</span>
                                    <span class="fs-2 d-block text-body-secondary">/apps/contacts</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">Posts</span>
                                    <span class="fs-2 d-block text-body-secondary">/apps/blog/posts</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">Detail</span>
                                    <span
                                        class="fs-2 d-block text-body-secondary">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">Shop</span>
                                    <span class="fs-2 d-block text-body-secondary">/apps/ecommerce/shop</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">Modern</span>
                                    <span class="fs-2 d-block text-body-secondary">/dashboards/dashboard1</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">Dashboard</span>
                                    <span class="fs-2 d-block text-body-secondary">/dashboards/dashboard2</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">Contacts</span>
                                    <span class="fs-2 d-block text-body-secondary">/apps/contacts</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">Posts</span>
                                    <span class="fs-2 d-block text-body-secondary">/apps/blog/posts</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">Detail</span>
                                    <span
                                        class="fs-2 d-block text-body-secondary">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">Shop</span>
                                    <span class="fs-2 d-block text-body-secondary">/apps/ecommerce/shop</span>
                                </a>
                            </li>
                        </ul>
                    </div>
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