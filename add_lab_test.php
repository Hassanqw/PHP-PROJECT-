<?php
include("php/query.php");
include("components/header.php");

// Step 1: Saare products uthao
$allProducts = $pdo->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);

// Step 2: Jo products lab_test table mein "Pass" ho chuke hain, unke IDs
$passedProductIds = $pdo->query("
    SELECT DISTINCT product_id 
    FROM lab_test 
    WHERE result = 'Pass'
")->fetchAll(PDO::FETCH_COLUMN);

// Step 3: Filter karo sirf un products ko jo abhi Pass nahi hue
$availableProducts = array_filter($allProducts, function($p) use ($passedProductIds) {
    return !in_array($p['product_id'], $passedProductIds);
});

// Step 4: Baaki dropdowns
$testingTypes = $pdo->query("SELECT * FROM testing_types")->fetchAll(PDO::FETCH_ASSOC);
$departments = $pdo->query("SELECT * FROM departments")->fetchAll(PDO::FETCH_ASSOC);
$testers = $pdo->query("SELECT * FROM testers")->fetchAll(PDO::FETCH_ASSOC);

// Step 5: Form submit hone pe insert karo
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['labTest'])) {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO lab_test (
                product_id, testing_type_id, department_id, tester_id, test_date, 
                test_start_time, test_end_time, criteria_tested, observed_output, expected_output, 
                result, remarks, status, is_sent_to_CPRI, test_roll_number, created_at, updated_at
            ) VALUES (
                :product_id, :testing_type_id, :department_id, :tester_id, :test_date, 
                :test_start_time, :test_end_time, :criteria_tested, :observed_output, :expected_output, 
                :result, :remarks, :status, :is_sent_to_CPRI, :test_roll_number, :created_at, :updated_at
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
            ':status'            => $_POST['status'],
            ':is_sent_to_CPRI'   => $_POST['is_sent_to_CPRI'],
            ':test_roll_number'  => $_POST['test_roll_number'],
            ':created_at'        => $_POST['created_at'],
            ':updated_at'        => $_POST['updated_at']
        ]);

        echo "<script>alert('Test successfully added!'); window.location.href='add_lab_test.php';</script>";
        exit;

    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>

<style>
.container {
    width: 700px;
    margin-top: -800px;
    margin-left: 300px;
}
</style>

<div class="container">
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-box1 text-success"></i>
                        </div>
                        <div>Add Lab Test.
                            <div class="page-title-subheading">Add new lab test to the system.</div>
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST">
                <!-- Product (Only Not Passed) -->
                <label>Product (Testing ke liye)</label>
                <select name="product_id" class="form-control" required>
                    <option value="">Select Product</option>
                    <?php foreach ($availableProducts as $p): ?>
                        <option value="<?= htmlspecialchars($p['product_id']) ?>">
                            <?= htmlspecialchars($p['product_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Testing Type -->
                <label>Testing Type</label>
                <select name="testing_type_id" class="form-control" required>
                    <option value="">Select Test</option>
                    <?php foreach ($testingTypes as $t): ?>
                        <option value="<?= htmlspecialchars($t['testing_type_id']) ?>">
                            <?= htmlspecialchars($t['test_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Department -->
                <label>Department</label>
                <select name="department_id" class="form-control" required>
                    <option value="">Select Department</option>
                    <?php foreach ($departments as $d): ?>
                        <option value="<?= htmlspecialchars($d['department_id']) ?>">
                            <?= htmlspecialchars($d['dept_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Tester -->
                <label>Tester</label>
                <select name="tester_id" class="form-control" required>
                    <option value="">Select Tester</option>
                    <?php foreach ($testers as $t): ?>
                        <option value="<?= htmlspecialchars($t['tester_id']) ?>">
                            <?= htmlspecialchars($t['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Test Date -->
                <label>Test Date</label>
                <input type="date" name="test_date" class="form-control" required>

                <!-- Test Start Time -->
                <label>Test Start Time</label>
                <input type="time" name="test_start_time" class="form-control" required>

                <!-- Test End Time -->
                <label>Test End Time</label>
                <input type="time" name="test_end_time" class="form-control" required>

                <!-- Criteria Tested -->
                <label>Criteria Tested</label>
                <input type="text" name="criteria_tested" class="form-control" required>

                <!-- Observed Output -->
                <label>Observed Output</label>
                <input type="text" name="observed_output" class="form-control" required>

                <!-- Expected Output -->
                <label>Expected Output</label>
                <input type="text" name="expected_output" class="form-control" required>

                <!-- Result -->
                <label>Result</label>
                <select name="result" class="form-control" required>
                    <option value="Pass">Pass</option>
                    <option value="Fail">Fail</option>
                </select>

                <!-- Remarks -->
                <label>Remarks</label>
                <textarea name="remarks" class="form-control"></textarea>

                <!-- Status -->
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="Pending">Pending</option>
                    <option value="Tested">Tested</option>
                    <option value="Re-test">Re-test</option>
                </select>

                <!-- Sent to CPRI -->
                <label>Sent to CPRI?</label>
                <select name="is_sent_to_CPRI" class="form-control" required>
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>

                <!-- Test Roll Number -->
                <label>Test Roll Number</label>
                <input type="text" name="test_roll_number" class="form-control" required>

                <!-- Created/Updated -->
                <input type="hidden" name="created_at" value="<?= date('Y-m-d H:i:s') ?>">
                <input type="hidden" name="updated_at" value="<?= date('Y-m-d H:i:s') ?>">

                <br>
                <button type="submit" name="labTest" class="btn btn-primary">Submit Lab Test</button>
            </form>
        </div>
    </div>
</div>

<?php include("components/footer.php"); ?>
 