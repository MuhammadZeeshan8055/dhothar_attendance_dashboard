<?php
  include("session.php");
  $obj = new Database();


   $msg="";

    if(isset($_GET['id']) && isset($_GET['type'])) {
        $id = $_GET['id'];

        $value = ["id"=>$id];

        if($obj->delete("employee_info","id=".$id)){
            $msg="Data Deleted Successfully";
        }else{
            $msg="Data Not Deleted";
        }
    }
    $company = "";
    if (isset($_GET['company'])) {
        $company = trim($_GET['company']); // Optional: trim spaces
    }
    
    $company = !empty($company) ? $company : '';
    
    $colName = "employee_info.id, employee_info.name, employee_info.email, employee_info.company, employee_info.salary, company.company_name";
    $where = !empty($company) ? "company.company_name = '$company'" : "1"; // Default to 1 if empty to avoid WHERE error
    $join = "company ON company.id = employee_info.company";
    $limit = 0;
    
    $obj->select('employee_info', $colName, $join, $where, null, $limit);
    $result = $obj->getResult();
    
    $companyName = "*";
    
    $obj->select('company',$companyName,null,null,null,0);
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
                            <h4 class="fs-6 mb-0">Employee</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a class="text-muted text-decoration-none" href="#">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Employee</li>
                                </ol>
                            </nav>
                        </div>

                    </div>
                    <!-- Row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="company-list">
                                    <form method="GET" id="companyForm">
                                        <div class="form-group">
                                            <select name="company" id="company_list" class="form-control"
                                                onchange="document.getElementById('companyForm').submit()">
                                                <option value="">-- Select Company --</option>
                                                <?php
                                                    for ($i = 0; $i < count($company_names); $i++) {
                                                        $id = $company_names[$i]['id'];
                                                        $company_name = $company_names[$i]['company_name'];
                                                        $selected = (isset($_GET['company']) && $_GET['company'] == $company_name) ? "selected" : "";
                                                        echo "<option value=\"$company_name\" $selected>$company_name</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">

                            <a href="add_employee" class="btn btn-success">Add Employee</a>

                        </div>

                        <?php if (!empty($msg)) : ?>
                        <div id="delete-msg">
                            <p class="text-success text-center"><strong><?=$msg?></strong></p>
                        </div>
                        <script>
                        // Hide the message after 3 seconds
                        setTimeout(function() {
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
                                                <th>Email</th>
                                                <th>Company</th>
                                                <th>Salary</th>
                                                <th>Actions</th>
                                            </thead>
                                        </tr>
                                        <tbody>
                                            <?php
                                                $i=0;
                                                if(!empty($result)){
                                                    foreach ($result as 
                                                        list("id"=>$id,"name"=>$name,"email"=>$email,
                                                        "company"=>$company,"salary"=>$salary,'company_name'=>$company)) {
                                                            $i++;
                                                    ?>
                                                    <tr>
                                                        <td><?=$i?></td>
                                                        <td><?=$name?></td>
                                                        <td><?=$email?></td>
                                                        <td><?=$company?></td>
                                                        <td><?=$salary?></td>
                                                        <td>
                                                            <a href="add_employee?id=<?= $id ?>"
                                                                class="btn btn-primary">Edit</a>
                                                            <a href="employee?id=<?= urlencode($id) ?>&type=Delete"
                                                                class="btn btn-danger"
                                                                onclick="return confirm('Are you sure you want to delete this employee?');">
                                                                Delete
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                        }
                                                }else{
                                                    ?>

                                                    <tr>
                                                        <td class="text-center" colspan="6">No Employee Record Found for this Company</td>
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