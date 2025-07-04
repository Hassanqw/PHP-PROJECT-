<?php
include("php/dbcon.php");
session_start();


$productNameErr = $productImageNameErr = $createdAtErr = $categoryNameErr = $categoryImageNameErr = $categoryDesErr = "";

$message = "";
if (isset($_POST["addproductType"])) {
    $type_name = trim($_POST['type_name']);

    if (!empty($type_name)) {
        // Prepare and bind to prevent SQL injection
        $stmt = $pdo->prepare("INSERT INTO product_types (type_name) VALUES (:t)");
        $stmt->bindParam("t", $type_name);

        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>Product type added successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error adding product type " .  "</div>";
        }

        // $stmt->close();
    } else {
        $message = "<div class='alert alert-warning'>Please enter a product type name.</div>";
    }
}
//TESTING TYPES:

// your PDO connection
// $testName = $departmentId = "";
// $testNameErr = $departmentIdErr = "";

// if (isset($_POST['addTestingType'])) {
//     $testName = $_POST['test_name'];
//     $departmentId = $_POST['department_id'];

//     if (empty($testName)) {
//         $testNameErr = "Testing Name is required";
//     }

//     if (empty($departmentId)) {
//         $departmentIdErr = "Department ID is required";
//     }

//     if (empty($testNameErr) && empty($departmentIdErr)) {
//         $stmt = $pdo->prepare("INSERT INTO testing_types (test_name, department_id) VALUES (:test_name, :department_id)");
//         $stmt->bindParam(":test_name", $testName);
//         $stmt->bindParam(":department_id", $departmentId);
//         $stmt->execute();

//         echo "<script>alert('Testing Type Added Successfully'); location.assign('testing_type.php');</script>";
//     }
// }


//Add Lab Test:



// if (isset($_POST['labTest'])) {


//         $stmt = $pdo->prepare("
//             INSERT INTO lab_test (
//                 product_id, testing_type_id, department_id, tester_id, test_date, 
//                 test_start_time, test_end_time, criteria_tested, observed_output, expected_output, 
//                 result, remarks, status, is_sent_to_CPRI, test_roll_number, created_at, updated_at
//             ) VALUES (
//                 :product_id, :testing_type_id, :department_id, :tester_id, :test_date, 
//                 :test_start_time, :test_end_time, :criteria_tested, :observed_output, :expected_output, 
//                 :result, :remarks, :status, :is_sent_to_CPRI, :test_roll_number, :created_at, :updated_at
//             )
//         ");

//         $stmt->execute([
//             ':product_id'        => $_POST['product_id'],
//             ':testing_type_id'   => $_POST['testing_type_id'],
//             ':department_id'     => $_POST['department_id'],
//             ':tester_id'         => $_POST['tester_id'],
//             ':test_date'         => $_POST['test_date'],
//             ':test_start_time'   => $_POST['test_start_time'],
//             ':test_end_time'     => $_POST['test_end_time'],
//             ':criteria_tested'   => $_POST['criteria_tested'],
//             ':observed_output'   => $_POST['observed_output'],
//             ':expected_output'   => $_POST['expected_output'],
//             ':result'            => $_POST['result'],
//             ':remarks'           => $_POST['remarks'],
//             ':status'            => $_POST['status'],
//             ':is_sent_to_CPRI'   => $_POST['is_sent_to_CPRI'],
//             ':test_roll_number'  => $_POST['test_roll_number'],
//             ':created_at'        => $_POST['created_at'],
//             ':updated_at'        => $_POST['updated_at']
//         ]);

//         echo "<script>alert('Lab Test added successfully'); window.location.href='add_cpri_test.php';</script>";



// } 

//                                              //ADD TESTER:



if (isset($_POST['addTester'])) {
    $name = $_POST['tester_name'];
    $email = $_POST['email'];
    $department_id = $_POST['department_id'];
    $password = $_POST['password']; // This will be stored as-is

    if (!empty($name) && !empty($email) && !empty($department_id) && !empty($password)) {
        // No hashing here
        $stmt = $pdo->prepare("INSERT INTO testers (name, email, password, department_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password, $department_id]);

        echo "<script>alert('Tester added successfully'); window.location.href='add_tester.php';</script>";
    } else {
        echo "<div class='alert alert-danger mt-3'>All fields are required!</div>";
    }
}



//ADD DEPARTMENT:

if (isset($_POST['addDepartment'])) {
    $departmentName = $_POST['department_name'];
    $location = $_POST['location'];

    if (!empty($departmentName) && !empty($location)) {
        $stmt = $pdo->prepare("INSERT INTO departments (dept_name, location) VALUES (:dept_name, :location)");
        $stmt->execute([
            ':dept_name' => $departmentName,
            ':location' => $location
        ]);
        echo "<script>alert('Department added successfully'); location.href='add_department.php';</script>";
    } else {
        echo "<script>alert('Please fill all fields');</script>";
    }
}

//resigter form
$userName = $userEmail = $userPassword = $userConfirmPassword = "";
$userNameErr = $userEmailErr = $userPasswordErr = $userConfirmPasswordErr = "";
// if(isset($_POST['userRegister'])){
//     $userName= $_POST['userName'];
//     $userEmail= $_POST['userEmail'];
//     $userPassword= $_POST['userPassword'];
//     $userConfirmPassword= $_POST['userConfirmPassword'];
//     if(empty($userName)){
//         $userNameErr = "Name is Required";
//     }
//      if(empty($userEmail)){
//         $userEmailErr = "Email is Required";
//     }
//     else{
//         $query = $pdo->prepare("select * from admin where email = :email");
//         $query->bindParam('email',$userEmail);
//         $query->execute();
//         $user = $query->fetch(PDO::FETCH_ASSOC);
//         // print_r($user);
//         // die();
//             if($user){
//                 $userEmailErr = "Email is already exist";
//             }
//     }
//      if(empty($userPassword)){
//         $userPasswordErr = "Password is Required";
//     }
//      if(empty($userConfirmPassword)){
//         $userConfirmPasswordErr = "Confirm Password is Required";
//     }
//     else{
//         if($userPassword != $userConfirmPassword){
//               $userConfirmPasswordErr = "Confirm Password does not Matched";
//         }
//     }
//     if(empty($userNameErr) && empty($userEmailErr) && empty($userPasswordErr) && empty($userConfirmPasswordErr)){
//         $query = $pdo->prepare("insert into  (name , email , password) values (:name , :email , :password)");
//         $query->bindParam('name',$userName);
//         $query->bindParam('email',$userEmail);
//         $query->bindParam('password',$userPassword);
//         $query->execute();
//         echo "<script>alert('user register');location.assign('pages-login.php')</script>";      
//     }
// }
// login Work

$userEmail = $userPassword = "";
$userEmailErr = $userPasswordErr = "";
if (isset($_POST['userLogin'])) {
    $userEmail = $_POST['userEmail'];
    $userPassword = $_POST['userPassword'];

    if (empty($userEmail)) {
        $userEmailErr = "Email is Required";
    } elseif (empty($userPassword)) {
        $userPasswordErr = "Password is Required";
    } else {
        // Try to find user in admin table first
        $query = $pdo->prepare("SELECT * FROM admin WHERE email = :email");
        $query->bindParam(':email', $userEmail);
        $query->execute();
        $admin = $query->fetch(PDO::FETCH_ASSOC);

        // Try to find user in tester table if not found in admin
        if (!$admin) {
            $query = $pdo->prepare("SELECT * FROM testers WHERE email = :email");
            $query->bindParam(':email', $userEmail);
            $query->execute();
            $tester = $query->fetch(PDO::FETCH_ASSOC);
        }

        // Handle login
        if ($admin) {
            if ($userPassword == $admin['password']) {
                // Login as Admin
                $_SESSION['adminRole'] = $admin['role_id'];
                $_SESSION['adminName'] = $admin['name'];
                $_SESSION['adminEmail'] = $admin['email'];
                $_SESSION['adminId'] = $admin['id'];
                echo "<script>alert('Admin Login');location.assign('dashboards-commerce.php')</script>";
            } else {
                $userPasswordErr = "Incorrect Password for Admin";
            }
        } elseif ($tester) {
            if ($userPassword == $tester['password']) {
                // Login as Tester/User

                $_SESSION['userName'] = $tester['name'];
                $_SESSION['userEmail'] = $tester['email'];

                echo "<script>alert('User Login');location.assign('addProduct.php')</script>";
            } else {
                $userPasswordErr = "Incorrect Password for User";
            }
        } else {
            $userEmailErr = "User Not Found";
        }
    }
}


//ADD CPRI

$errors = [];
$uploaded_report_path = null;

// Auto-generate IDs
function generateRelatedTestId($pdo) {
    $datePrefix = date("Ymd");
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM cpri_tests WHERE DATE(created_at) = CURDATE()");
    $stmt->execute();
    $countToday = $stmt->fetchColumn() + 1;
    return 'RT-' . $datePrefix . '-' . str_pad($countToday, 3, '0', STR_PAD_LEFT);
}

function generateTestReportNo($pdo) {
    $year = date("Y");
    $stmt = $pdo->query("SELECT COUNT(*) FROM cpri_tests WHERE YEAR(created_at) = $year");
    $countThisYear = $stmt->fetchColumn() + 1;
    return 'TRN-' . $year . '-' . str_pad($countThisYear, 4, '0', STR_PAD_LEFT);
}

// ✅ CPRI Dropdown: Products that passed lab test or re-manufacture and not yet tested in CPRI
$passedProducts = $pdo->query("
    SELECT p.product_id, p.product_name
    FROM products p
    WHERE 
        (
            p.product_id IN (SELECT product_id FROM lab_test WHERE LOWER(result) = 'pass')
            OR
            p.product_id IN (
                SELECT re_product_id FROM `re-manufacture`
                WHERE Tested_by IS NOT NULL AND Department IS NOT NULL
            )
        )
        AND p.product_id NOT IN (SELECT product_id FROM cpri_tests)
")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_cpri_test'])) {
    $product_id           = trim($_POST['product_id'] ?? '');
    $submission_date      = trim($_POST['submission_date'] ?? '');
    $received_by          = trim($_POST['received_by'] ?? '');
    $test_date            = trim($_POST['test_date'] ?? '');
    $parameters_tested    = trim($_POST['parameters_tested'] ?? '');
    $observed_output      = trim($_POST['observed_output'] ?? '');
    $result_val           = trim($_POST['result'] ?? '');
    $certification_status = trim($_POST['certification_status'] ?? '');
    $remarks              = trim($_POST['remarks'] ?? '');
    $tested_by_cpri       = trim($_POST['tested_by_cpri'] ?? '');
    $decision_date        = trim($_POST['decision_date'] ?? '');

    $related_test_id = generateRelatedTestId($pdo);
    $test_report_no  = generateTestReportNo($pdo);

    if (empty($product_id))           $errors[] = "Product is required.";
    if (empty($result_val))           $errors[] = "Result is required.";
    if (empty($certification_status)) $errors[] = "Certification status is required.";

    // ✅ File Upload
    if (isset($_FILES['uploaded_report']) && $_FILES['uploaded_report']['error'] !== UPLOAD_ERR_NO_FILE) {
        $file = $_FILES['uploaded_report'];
        if ($file['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['application/pdf', 'image/png', 'image/jpeg'];
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($file['tmp_name']);

            if (!in_array($mime, $allowed_types)) {
                $errors[] = "File must be PDF, PNG, or JPG.";
            } else {
                $upload_dir = __DIR__ . '/uploads/reports/';
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
                $safeName = preg_replace("/[^a-zA-Z0-9_\.-]/", '_', basename($file['name']));
                $filename = uniqid('report_') . '_' . $safeName;
                $target_path = $upload_dir . $filename;

                if (move_uploaded_file($file['tmp_name'], $target_path)) {
                    $uploaded_report_path = 'uploads/reports/' . $filename;
                } else {
                    $errors[] = "Failed to upload the file.";
                }
            }
        } else {
            $errors[] = "File upload error.";
        }
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO cpri_tests (
                product_id, related_test_id, submission_date, received_by, test_date, test_report_no,
                parameters_tested, observed_output, result, certification_status, remarks,
                uploaded_report_path, tested_by_cpri, decision_date, created_at, updated_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");

            $stmt->execute([
                $product_id,
                $related_test_id,
                $submission_date ?: null,
                $received_by ?: null,
                $test_date ?: null,
                $test_report_no,
                $parameters_tested ?: null,
                $observed_output ?: null,
                $result_val,
                $certification_status,
                $remarks ?: null,
                $uploaded_report_path ?: null,
                $tested_by_cpri ?: null,
                $decision_date ?: null
            ]);

            // ✅ Add to re-manufacture if failed
            if (strtolower($result_val) === 'fail') {
                $check = $pdo->prepare("SELECT COUNT(*) FROM `re-manufacture` WHERE re_product_id = ?");
                $check->execute([$product_id]);
                if ($check->fetchColumn() == 0) {
                    $stmt2 = $pdo->prepare("INSERT INTO `re-manufacture` 
                        (re_product_id, remarks, created_at, updated_at)
                        VALUES (?, ?, NOW(), NOW())");
                    $stmt2->execute([$product_id, 'CPRI test failed. Sent for re-manufacture.']);
                }
                echo "<script>alert('✅ Sent To Re-Manufacturing'); window.location.href='add_cpri_test.php';</script>";
            } else {
                echo "<script>alert('✅ CPRI Test Complete'); window.location.href='add_cpri_test.php';</script>";
            }
            exit;

        } catch (PDOException $e) {
            echo "<script>alert('Database Error: " . addslashes($e->getMessage()) . "');</script>";
        }
    } else {
        foreach ($errors as $err) {
            echo "<script>alert('Error: " . addslashes($err) . "');</script>";
        }
    }
}




//ADD LAB TEST


// Enable error reporting
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Step 1: Saare products uthao
$allProducts = $pdo->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);

// Step 2: Jo products par lab_test ho chuka hai (Pass ya Fail)
$alreadyTestedProductIds = $pdo->query("
    SELECT DISTINCT product_id 
    FROM lab_test
")->fetchAll(PDO::FETCH_COLUMN);

// Step 3: Sirf un products ko dropdown ke liye chhodo jinka abhi tak test nahi hua
$availableProducts = array_filter($allProducts, function ($p) use ($alreadyTestedProductIds) {
    return !in_array($p['product_id'], $alreadyTestedProductIds);
});

// Step 4: Baaki dropdowns
$testingTypes = $pdo->query("SELECT * FROM testing_types")->fetchAll(PDO::FETCH_ASSOC);
$departments = $pdo->query("SELECT * FROM departments")->fetchAll(PDO::FETCH_ASSOC);
$testers = $pdo->query("SELECT * FROM testers")->fetchAll(PDO::FETCH_ASSOC);


// Step 5: Form submit hone pe insert karo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['labTest'])) {
    try {
        $now = date('Y-m-d H:i:s');

        $stmt = $pdo->prepare("
            INSERT INTO lab_test (
                product_id, testing_type_id, department_id, tester_id, test_date, 
                test_start_time, test_end_time, criteria_tested, observed_output, expected_output, 
                result, remarks, created_at, updated_at
            ) VALUES (
                :product_id, :testing_type_id, :department_id, :tester_id, :test_date, 
                :test_start_time, :test_end_time, :criteria_tested, :observed_output, :expected_output, 
                :result, :remarks, :created_at, :updated_at
            )
        ");

        $stmt->execute([
            ':product_id'        => $_POST['product_id'],
            ':testing_type_id'   => $_POST['testing_type_id'],
            ':department_id'     => $_POST['department_id'],
            ':tester_id'         => $_POST['tester_id'],
            ':test_date'         => $_POST['test_date'],
            ':test_start_time'   => $_POST['test_start_time'],
            ':test_end_time'     => $_POST['test_end_time'],
            ':criteria_tested'   => $_POST['criteria_tested'],
            ':observed_output'   => $_POST['observed_output'],
            ':expected_output'   => $_POST['expected_output'],
            ':result'            => $_POST['result'],
            ':remarks'           => $_POST['remarks'],
            ':created_at'        => $now,
            ':updated_at'        => $now
        ]);

        echo "<script>alert('Test successfully added!'); window.location.href='add_lab_test.php';</script>";
        exit;
    } catch (PDOException $e) {
        echo "<script>alert('Database Error: " . $e->getMessage() . "');</script>";
    }
}




//ADD PRODUCT

// Generate Random Codes Only On First Load
function generateRandomReviseCode()
{
    return 'R' . rand(1, 99);
}

function generateRandomManufactureNo()
{
    return 'MF' . str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
}

// Initialize variables
$product_name = '';
$product_type_id = '';
$manufacture_date = '';
$productNameErr = $productTypeIdErr = $manufactureDateErr = '';

if (!isset($_POST['addproduct'])) {
    // Codes generate only once on page load
    $revise_code = generateRandomReviseCode();
    $manufacture_no = generateRandomManufactureNo();
}

if (isset($_POST['addproduct'])) {
    // Form values
    $product_name = $_POST['product_name'] ?? '';
    $product_type_id = $_POST['product_type_id'] ?? null;
    $manufacture_date = $_POST['manufacture_date'] ?? '';
    $revise_code = $_POST['revise_code'] ?? '';
    $manufacture_no = $_POST['manufacture_no'] ?? '';

    // Validation
    $errors = [];
    if (empty($product_name)) {
        $errors['productNameErr'] = "Product Name is required";
    }
    if (empty($product_type_id)) {
        $errors['productTypeIdErr'] = "Product Type is required";
    }

    if (empty($errors)) {
        // Insert into DB (product_id is auto-generated by trigger)
        $stmt = $pdo->prepare("INSERT INTO products 
            (product_name, product_type_id, revise_code, manufacture_no, manufacture_date) 
            VALUES (?, ?, ?, ?, ?)");
        $result = $stmt->execute([
            $product_name,
            $product_type_id,
            $revise_code,
            $manufacture_no,
            $manufacture_date
        ]);

        if ($result) {
            echo "<script>alert('Product added successfully!'); location.assign('addProduct.php');</script>";
            exit;
        } else {
            echo "<div class='alert alert-danger'>Failed to add product.</div>";
        }
    } else {
        // Populate error variables for form
        foreach ($errors as $key => $msg) {
            $$key = $msg;
        }
    }
}

//TESTING TYPE


// Initialize variables & error messages
$test_name = '';
$department_id = '';
$testNameErr = '';
$departmentIdErr = '';

if (isset($_POST['addTestingType'])) {
    $test_name = trim($_POST['test_name'] ?? '');
    $department_id = trim($_POST['department_id'] ?? '');

    // Validation
    if (empty($test_name)) {
        $testNameErr = "Test Name is required";
    }

    if (empty($department_id)) {
        $departmentIdErr = "Department is required";
    } elseif (!ctype_digit($department_id)) {
        $departmentIdErr = "Department ID must be a number";
    } else {
        // Check if department_id exists in departments table
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM departments WHERE department_id = ?");
        $stmt->execute([$department_id]);
        if ($stmt->fetchColumn() == 0) {
            $departmentIdErr = "Invalid department selected.";
        }
    }

    // If no errors, insert into database
    if (empty($testNameErr) && empty($departmentIdErr)) {
        $stmt = $pdo->prepare("INSERT INTO testing_types (test_name, department_id) VALUES (?, ?)");
        $result = $stmt->execute([$test_name, $department_id]);

        if ($result) {
            echo "<script>alert('Testing type added successfully!'); location.assign('testing_types.php');</script>";
            exit;
        } else {
            echo "<div class='alert alert-danger'>Failed to add testing type.</div>";
        }
    }
} else {
    // If form not submitted, initialize for empty form
    $test_name = '';
    $department_id = '';
}

// Fetch departments from database for dropdown
$deptStmt = $pdo->query("SELECT department_id, dept_name FROM departments ORDER BY dept_name ASC");
$departments = $deptStmt->fetchAll(PDO::FETCH_ASSOC);


//ADVANCE SEARCH OPTION


// query.php

// For view_records.php
if (isset($_GET['search']) && $_GET['search'] !== '') {
    $search = '%' . $_GET['search'] . '%';
    $stmt = $pdo->prepare("
        SELECT p.*, pt.type_name
        FROM products p
        LEFT JOIN product_types pt ON p.product_type_id = pt.product_type_id
        WHERE p.product_id LIKE ? OR p.product_name LIKE ?
        ORDER BY p.created_at DESC
    ");
    $stmt->execute([$search, $search]);
} else {
    $stmt = $pdo->prepare("
        SELECT p.*, pt.type_name
        FROM products p
        LEFT JOIN product_types pt ON p.product_type_id = pt.product_type_id
        ORDER BY p.created_at DESC
    ");
    $stmt->execute();
}

$allProducts = $stmt->fetchAll();
