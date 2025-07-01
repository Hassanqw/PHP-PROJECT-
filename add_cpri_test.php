<?php
include("php/query.php");
include("components/header.php");

// Step 1: Get product IDs which have passed lab_test
$passedProductIds = $pdo->query("
    SELECT DISTINCT product_id 
    FROM lab_test 
    WHERE result = 'Pass'
")->fetchAll(PDO::FETCH_COLUMN);

// Step 2: Get products which are passed
$passedProducts = [];
if (!empty($passedProductIds)) {
    $placeholders = implode(',', array_fill(0, count($passedProductIds), '?'));
    $stmt = $pdo->prepare("SELECT * FROM products WHERE product_id IN ($placeholders)");
    $stmt->execute($passedProductIds);
    $passedProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$errors = [];
$uploaded_report_path = null;

if (isset($_POST['add_cpri_test'])) {
    // Sanitize input
    $product_id = trim($_POST['product_id'] ?? '');
    $related_test_id = trim($_POST['related_test_id'] ?? null);
    $submission_date = trim($_POST['submission_date'] ?? null);
    $received_by = trim($_POST['received_by'] ?? null);
    $test_date = trim($_POST['test_date'] ?? null);
    $test_report_no = trim($_POST['test_report_no'] ?? null);
    $parameters_tested = trim($_POST['parameters_tested'] ?? null);
    $observed_output = trim($_POST['observed_output'] ?? null);
    $result_val = trim($_POST['result'] ?? null);
    $certification_status = trim($_POST['certification_status'] ?? null);
    $remarks = trim($_POST['remarks'] ?? null);
    $documents_attached = trim($_POST['documents_attached'] ?? null);
    $tested_by_cpri = trim($_POST['tested_by_cpri'] ?? null);
    $decision_date = trim($_POST['decision_date'] ?? null);

    // Basic validation
    if (empty($product_id)) {
        $errors[] = "Product is required.";
    }

    // Handle file upload if any
    if (isset($_FILES['uploaded_report']) && $_FILES['uploaded_report']['error'] !== UPLOAD_ERR_NO_FILE) {
        $file = $_FILES['uploaded_report'];
        if ($file['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['application/pdf', 'image/png', 'image/jpeg'];
            if (!in_array($file['type'], $allowed_types)) {
                $errors[] = "Uploaded file must be PDF, PNG, or JPG.";
            } else {
                $upload_dir = __DIR__ . '/uploads/reports/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }

                $filename = uniqid('report_') . '_' . basename($file['name']);
                $target_path = $upload_dir . $filename;

                if (move_uploaded_file($file['tmp_name'], $target_path)) {
                    $uploaded_report_path = 'uploads/reports/' . $filename;
                } else {
                    $errors[] = "Failed to upload the report file.";
                }
            }
        } else {
            $errors[] = "Error uploading file.";
        }
    }

    if (empty($errors)) {
        // Insert CPRI test record
        $stmt = $pdo->prepare("INSERT INTO cpri_tests (
            product_id, related_test_id, submission_date, received_by, test_date, test_report_no,
            parameters_tested, observed_output, result, certification_status, remarks, documents_attached,
            uploaded_report_path, tested_by_cpri, decision_date, created_at, updated_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");

        $res = $stmt->execute([
            $product_id,
            $related_test_id ?: null,
            $submission_date ?: null,
            $received_by ?: null,
            $test_date ?: null,
            $test_report_no ?: null,
            $parameters_tested ?: null,
            $observed_output ?: null,
            $result_val ?: null,
            $certification_status ?: null,
            $remarks ?: null,
            $documents_attached ?: null,
            $uploaded_report_path ?: null,
            $tested_by_cpri ?: null,
            $decision_date ?: null
        ]);

        if ($res) {
            echo "<script>alert('CPRI Test record added successfully!'); location.assign('add_cpri_test.php');</script>";
            exit;
        } else {
            $errors[] = "Failed to insert the test record.";
        }
    }
}
?>

<style>
.container {
    width: 700px;
    margin-top: -500px;
    margin-left: 300px;
}
</style>

<div class="container">
    <h3 class="mb-4">Add CPRI Test Record</h3>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
            <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        
        <!-- Product (Passed in lab_test) -->
        <div class="mb-3">
            <label class="form-label">Product</label>
            <select name="product_id" class="form-control" required>
                <option value="">Select Product</option>
                <?php foreach ($passedProducts as $product): ?>
                    <option value="<?= htmlspecialchars($product['product_id']) ?>" 
                        <?= (($_POST['product_id'] ?? '') == $product['product_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($product['product_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Related Test ID -->
        <div class="mb-3">
            <label class="form-label">Related Test ID</label>
            <input type="text" name="related_test_id" class="form-control" value="<?= htmlspecialchars($_POST['related_test_id'] ?? '') ?>">
        </div>

        <!-- Submission Date -->
        <div class="mb-3">
            <label class="form-label">Submission Date</label>
            <input type="date" name="submission_date" class="form-control" value="<?= htmlspecialchars($_POST['submission_date'] ?? '') ?>">
        </div>

        <!-- Received By -->
        <div class="mb-3">
            <label class="form-label">Received By</label>
            <input type="text" name="received_by" class="form-control" value="<?= htmlspecialchars($_POST['received_by'] ?? '') ?>">
        </div>

        <!-- Test Date -->
        <div class="mb-3">
            <label class="form-label">Test Date</label>
            <input type="date" name="test_date" class="form-control" value="<?= htmlspecialchars($_POST['test_date'] ?? '') ?>">
        </div>

        <!-- Test Report No -->
        <div class="mb-3">
            <label class="form-label">Test Report No</label>
            <input type="text" name="test_report_no" class="form-control" value="<?= htmlspecialchars($_POST['test_report_no'] ?? '') ?>">
        </div>

        <!-- Parameters Tested -->
        <div class="mb-3">
            <label class="form-label">Parameters Tested</label>
            <textarea name="parameters_tested" class="form-control"><?= htmlspecialchars($_POST['parameters_tested'] ?? '') ?></textarea>
        </div>

        <!-- Observed Output -->
        <div class="mb-3">
            <label class="form-label">Observed Output</label>
            <textarea name="observed_output" class="form-control"><?= htmlspecialchars($_POST['observed_output'] ?? '') ?></textarea>
        </div>

        <!-- Result -->
        <div class="mb-3">
            <label class="form-label">Result</label>
            <select name="result" class="form-control">
                <option value="Passed" <?= (($_POST['result'] ?? '') === 'Passed') ? 'selected' : '' ?>>Passed</option>
                <option value="Failed" <?= (($_POST['result'] ?? '') === 'Failed') ? 'selected' : '' ?>>Failed</option>
            </select>
        </div>

        <!-- Certification Status -->
        <div class="mb-3">
            <label class="form-label">Certification Status</label>
            <select name="certification_status" class="form-control">
                <option value="Certified" <?= (($_POST['certification_status'] ?? '') === 'Certified') ? 'selected' : '' ?>>Certified</option>
                <option value="Rejected" <?= (($_POST['certification_status'] ?? '') === 'Rejected') ? 'selected' : '' ?>>Rejected</option>
                <option value="Pending" <?= (($_POST['certification_status'] ?? '') === 'Pending') ? 'selected' : '' ?>>Pending</option>
            </select>
        </div>

        <!-- Remarks -->
        <div class="mb-3">
            <label class="form-label">Remarks</label>
            <textarea name="remarks" class="form-control"><?= htmlspecialchars($_POST['remarks'] ?? '') ?></textarea>
        </div>

        <!-- Documents Attached -->
        <div class="mb-3">
            <label class="form-label">Documents Attached</label>
            <input type="text" name="documents_attached" class="form-control" placeholder="e.g. Report.pdf, Sheet.png" value="<?= htmlspecialchars($_POST['documents_attached'] ?? '') ?>">
        </div>

        <!-- Upload Report -->
        <div class="mb-3">
            <label class="form-label">Upload CPRI Report</label>
            <input type="file" name="uploaded_report" class="form-control">
        </div>

        <!-- Tested By CPRI -->
        <div class="mb-3">
            <label class="form-label">Tested By CPRI (Name)</label>
            <input type="text" name="tested_by_cpri" class="form-control" value="<?= htmlspecialchars($_POST['tested_by_cpri'] ?? '') ?>">
        </div>

        <!-- Decision Date -->
        <div class="mb-3">
            <label class="form-label">Decision Date</label>
            <input type="date" name="decision_date" class="form-control" value="<?= htmlspecialchars($_POST['decision_date'] ?? '') ?>">
        </div>

        <button type="submit" name="add_cpri_test" class="btn btn-primary w-100">Submit CPRI Test</button>
    </form>
</div>

<?php include("components/footer.php"); ?>
