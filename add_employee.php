<?php
include("session.php");

$obj = new Database();

$msg="";
$editable=false;

$employee_id = "";
$employee_name = "";
$employee_email = "";
$employee_password = "";
$employee_company = "";
$employee_designation = "";
$employee_date_of_joining = "";
$employee_salary = "";
$currency = "";
$employee_cnic_passport = "";
$employee_permanent_address = "";
$employee_country = "";
$employee_phone_1 = "";
$employee_phone_2 = "";
$employee_bank_name = "";
$employee_account_title = "";
$employee_iban = "";

if(isset($_POST['save_employee_info'])){

    $data = [
        "name"               => $_POST['employee_name'],  // Changed key to match form field name
        "email"              => $_POST['email'],
        "password"           => md5($_POST['password']),
        "company"            => $_POST['company'],
        "designation"        => $_POST['designation'],
        "date_of_joining"    => $_POST['date_of_joining'],
        "salary"             => $_POST['salary'],
        "currency"             => $_POST['currency'],
        "cnic_passport"      => $_POST['cnic_passport'],
        "permanent_address"  => $_POST['permanent_address'],
        "country"            => $_POST['country'],
        "phone_1"            => $_POST['phone_1'],
        "phone_2"            => $_POST['phone_2'],
        "bank_name"          => $_POST['bank_name'],
        "account_title"      => $_POST['account_title'],
        "IBAN"               => $_POST['IBAN']
    ];

    $message = $obj->insert("employee_info", $data)
        ? "Employee Record Inserted Successfully."
        : "Data is Not Inserted Successfully.";

    $msg=$message;
}

if(isset($_GET['id'])){
    
    $id=$_GET['id'];
    $editable=true;

    $colName = "*"; // Select all columns
    $join    = null; // No join required
    $limit   = 0;
    $where   = "id = $id"; // Adjust your condition accordingly
    
    
    $obj->select('employee_info',$colName,$join,$where,null,$limit);
    $result = $obj->getResult();
    
    $employee = $result[0];
    
    $employee_id = $employee['id'];
    $employee_name = $employee['name'];
    $employee_email = $employee['email'];
    $employee_password = $employee['password'];
    $employee_company = $employee['company'];
    $employee_designation = $employee['designation'];
    $employee_date_of_joining = $employee['date_of_joining'];
    $employee_salary = $employee['salary'];
    $currency = $employee['currency'];
    $employee_cnic_passport = $employee['cnic_passport'];
    $employee_permanent_address = $employee['permanent_address'];
    $employee_country = $employee['country'];
    $employee_phone_1 = $employee['phone_1'];
    $employee_phone_2 = $employee['phone_2'];
    $employee_bank_name = $employee['bank_name'];
    $employee_account_title = $employee['account_title'];
    $employee_iban = $employee['iban'];
    
}

if(isset($_POST['update_employee_info'])){
    $id = $_POST['employee_id'];
	$data = [
        "name"               => $_POST['employee_name'],  // Changed key to match form field name
        "email"              => $_POST['email'],
        "password"           => md5($_POST['password']),
        "company"            => $_POST['company'],
        "designation"        => $_POST['designation'],
        "date_of_joining"    => $_POST['date_of_joining'],
        "salary"             => $_POST['salary'],
        "currency"             => $_POST['currency'],
        "cnic_passport"      => $_POST['cnic_passport'],
        "permanent_address"  => $_POST['permanent_address'],
        "country"            => $_POST['country'],
        "phone_1"            => $_POST['phone_1'],
        "phone_2"            => $_POST['phone_2'],
        "bank_name"          => $_POST['bank_name'],
        "account_title"      => $_POST['account_title'],
        "IBAN"               => $_POST['IBAN']
    ];

	$message = $obj->update('employee_info', $data, 'id=' . $id) 
		? "Data Updated Successfully." 
		: "Data is Not Updated Successfully.";

	echo "<h2>$message</h2>";
}

  $colName = "*";
  $join = null;
  $limit = 0;
  
  $obj->select('company',$colName,$join,null,null,$limit);
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
                            <h4 class="fs-6 mb-0"><?= ($editable) ? 'Edit Employee' : 'Add Employee'; ?></h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a class="text-muted text-decoration-none" href="#">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <?= ($editable) ? 'Edit Employee' : 'Add Employee'; ?></li>
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
                                    <h4 class="card-title"><?= ($editable) ? 'Edit Employee' : 'Add Employee'; ?></h4>
                                </div>

                                <p class="text-success text-center text-bold"><strong><?=$msg?></strong></p>

                                <form class="form-horizontal r-separator" method="post" action="add_employee">
                                    <div class="card-body">
                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="inputText11" class="col-3 text-end  col-form-label">Employee
                                                    Name <span style="color:red">*</span></label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="text" class="form-control" name="employee_name"
                                                        required value="<?=$employee_name?>" id="inputText11"
                                                        placeholder="Employee Name Here" />
                                                    <?php
                                                        if($editable){
                                                            ?>
                                                    <input type="hidden" class="form-control" name="employee_id" required
                                                        value="<?=$employee_id?>" id="inputText11" />
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="inputText12" class="col-3 text-end  col-form-label">Email
                                                    <span style="color:red">*</span></label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="text" class="form-control" name="email"
                                                        value="<?=$employee_email?>" required id="inputText12"
                                                        placeholder="Enter Email Here" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="inputDate1" class="col-3 text-end  col-form-label">Password
                                                    <span style="color:red">*</span></label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="text" class="form-control" name="password"
                                                        value="<?=$employee_password?>" required id="inputDate1"
                                                        placeholder="Enter Password Here" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="inputDate1" class="col-3 text-end  col-form-label">Company
                                                    <span style="color:red">*</span></label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <select name="company" id="" class="form-control">
                                                        <?php
                                                            if(!empty($employee_company)){
                                                                ?>
                                                        <option value="<?=$employee_company?>"><?=$employee_company?>
                                                        </option>
                                                        <?php
                                                            }
                                                        
                                                            foreach ($company_names as list("id"=>$company_id,"company_name"=>$company_name)) {
                                                               
                                                        ?>
                                                        
                                                                <option value="<?=$company_id?>"><?=$company_name?></option>
                                                                
                                                        <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="inputTime1"
                                                    class="col-3 text-end  col-form-label">Designation</label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="text" class="form-control" name="designation"
                                                        value="<?=$employee_designation?>" id="inputTime1"
                                                        placeholder="Enter Designation Here" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="inputTime1" class="col-3 text-end  col-form-label">Date Of
                                                    Joining</label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="date" class="form-control" name="date_of_joining"
                                                        value="<?=$employee_date_of_joining?>" id="inputTime1"
                                                        placeholder="Enter Date Of Joining Here" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="inputTime1" class="col-3 text-end  col-form-label">Salary
                                                    <span style="color:red">*</span></label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="text" class="form-control" name="salary"
                                                        value="<?=$employee_salary?>" required id="inputTime1"
                                                        placeholder="Enter Salary Here" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="inputTime1" class="col-3 text-end  col-form-label">Currency
                                                    <span style="color:red">*</span></label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="text" class="form-control" name="currency"
                                                        value="<?=$currency?>" required id="inputTime1"
                                                        placeholder="Enter Currency Here" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="inputTime1" class="col-3 text-end  col-form-label">CNIC Or
                                                    Passport <span style="color:red">*</span></label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="text" class="form-control" name="cnic_passport"
                                                        value="<?=$employee_cnic_passport?>" required id="inputTime1"
                                                        placeholder="Enter CNIC Or Passport Here" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="inputTime1" class="col-3 text-end  col-form-label">Permanent
                                                    Address</label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="text" class="form-control" name="permanent_address"
                                                        value="<?=$employee_permanent_address?>" id="inputTime1"
                                                        placeholder="Enter Permanent Address Here" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="inputTime1" class="col-3 text-end  col-form-label">Country
                                                    <span style="color:red">*</span></label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="text" class="form-control" name="country"
                                                        value="<?=$employee_country?>" required id="inputTime1"
                                                        placeholder="Enter Country Here" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="inputTime1" class="col-3 text-end  col-form-label">Phone 1
                                                    <span style="color:red">*</span></label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="text" class="form-control" name="phone_1"
                                                        value="<?=$employee_phone_1?>" required id="inputTime1"
                                                        placeholder="Enter Phone 1 Here" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="inputTime1" class="col-3 text-end  col-form-label">Phone
                                                    2</label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="text" class="form-control" name="phone_2"
                                                        value="<?=$employee_phone_2?>" id="inputTime1"
                                                        placeholder="Enter Phone 2 Here" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="inputTime1" class="col-3 text-end  col-form-label">Bank
                                                    Name</label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="text" class="form-control" name="bank_name"
                                                        value="<?=$employee_bank_name?>" id="inputTime1"
                                                        placeholder="Enter Bank Name Here" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="inputTime1" class="col-3 text-end  col-form-label">Account
                                                    Title</label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="text" class="form-control" name="account_title"
                                                        value="<?=$employee_account_title?>" id="inputTime1"
                                                        placeholder="Enter Account Title Here" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="row align-items-center">
                                                <label for="inputTime1"
                                                    class="col-3 text-end  col-form-label">IBAN</label>
                                                <div class="col-9 border-start pb-2 pt-2">
                                                    <input type="text" class="form-control" name="IBAN"
                                                        value="<?=$employee_iban?>" id="inputTime1"
                                                        placeholder="Enter IBAN Here" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3 border-top">
                                        <div class="form-group mb-0 text-end">
                                            <button type="submit" name="<?= ($editable) ? 'update_employee_info' : 'save_employee_info'; ?>" class="btn btn-primary">
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