<?php
  include("session.php");
  $obj = new Database();
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $meta_key => $meta_value) {
        $meta_key = $con->real_escape_string($meta_key);
        $meta_value = $con->real_escape_string($meta_value);

        // Check if the meta_key exists
        $result = $con->query("SELECT * FROM settings WHERE meta_key = '$meta_key'");

        if ($result->num_rows > 0) {
            // Update existing record
            $con->query("UPDATE settings SET meta_value = '$meta_value' WHERE meta_key = '$meta_key'");
        } else {
            // Insert new record
            $con->query("INSERT INTO settings (meta_key, meta_value) VALUES ('$meta_key', '$meta_value')");
        }
    }

     // Redirect back to settings page
     header('Location: settings.php');
     exit;
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
    <link rel="stylesheet" href="https://bootstrapdemos.wrappixel.com/monster/dist/assets/css/styles.css" />

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
                    <div class="d-md-flex align-items-center justify-content-between mb-7">
                        <div class="mb-4 mb-md-0">
                            <h4 class="fs-6 mb-0">System Settings</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a class="text-muted text-decoration-none" href="#">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">System Settings</li>
                                </ol>
                            </nav>
                        </div>

                    </div>
                    <!-- Row -->
                    <div class="row">

                        <div class="col-12">
                            <!-- start Employee Timing -->
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">System Settings</h4>
                                </div>
                                <form class="form-horizontal r-separator" method="post" action="settings">
                                    <div class="card-body">
                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="inputText11" class="col-3 text-end  col-form-label">Pakistan Office IP Address</label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="text" class="form-control" name="pak_ip_address" value="<?=$pak_office?>" id="inputText11"
                                                        placeholder="Enter Pakistan Ip Address Here" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="inputText11" class="col-3 text-end  col-form-label">UAE Office IP Address</label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="text" class="form-control" name="uae_ip_address" value="<?=$uae_office?>" id="inputText11"
                                                        placeholder="Enter UAE Ip Address Here" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="inputText11" class="col-3 text-end  col-form-label">Romania Office IP Address</label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="text" class="form-control" name="rom_ip_address" value="<?=$rom_office?>" id="inputText11"
                                                        placeholder="Enter ROMANIA Ip Address Here" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="inputText12" class="col-3 text-end  col-form-label">Total Working Hours</label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="text" class="form-control" name="total_working_hours" value="<?=$total_working_hours?>" id="inputText12"
                                                        placeholder="Project Name Here" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="inputDate1"
                                                    class="col-3 text-end  col-form-label">Break Time</label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="text" class="form-control" name="break_time" value="<?=$break_time?>" id="inputDate1"
                                                        placeholder="Date Here" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="inputDate1"
                                                    class="col-3 text-end  col-form-label">Break Timings</label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="text" class="form-control" name="break_timing" value="<?=$break_timing?>" id="inputDate1"
                                                        placeholder="Date Here" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="inputTime1" class="col-3 text-end  col-form-label">Official Working Hours</label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="text" class="form-control" name="official_working_hours" value="<?=$official_working_hours?>" id="inputTime1"
                                                        placeholder="Start Time Here" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3 border-top">
                                        <div class="form-group mb-0 text-end">
                                            <button type="submit" class="btn btn-primary">
                                                Save
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