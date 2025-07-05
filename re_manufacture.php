<?php
include("php/query.php");
include("components/header.php");


$errors = [];

// Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Re-Submit'])) {
    $product_id    = trim($_POST['product_id'] ?? '');
    $tester_id     = trim($_POST['Tested_by'] ?? '');
    $department_id = trim($_POST['Department'] ?? '');

    if (empty($product_id))    $errors[] = "Please select a product.";
    if (empty($tester_id))     $errors[] = "Please select a tester.";
    if (empty($department_id)) $errors[] = "Please select a department.";

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO `re-manufacture`
                (re_product_id, Tested_by, Department, remarks, created_at, updated_at)
                VALUES (?, ?, ?, 're-manufactured manually.', NOW(), NOW())");
            $stmt->execute([$product_id, $tester_id, $department_id]);
            echo "<script>alert('✅ Re-manufacture record added!'); window.location.href='re_manufacture.php';</script>";
            exit;
        } catch (PDOException $e) {
            $errors[] = "Database Error: " . $e->getMessage();
        }
    }
}

// ✅ Get all failed products (lab or CPRI)
$failedLab = $pdo->query("SELECT DISTINCT product_id FROM lab_test WHERE LOWER(result) = 'Fail'")->fetchAll(PDO::FETCH_COLUMN);
$failedCPRI = $pdo->query("SELECT DISTINCT product_id FROM cpri_tests WHERE LOWER(result) = 'Fail'")->fetchAll(PDO::FETCH_COLUMN);
$failed = array_unique(array_merge($failedLab, $failedCPRI));

// ✅ Exclude already retested
$alreadyRetested = $pdo->query("
    SELECT DISTINCT re_product_id FROM `re-manufacture`
    WHERE Tested_by IS NOT NULL AND Department IS NOT NULL
")->fetchAll(PDO::FETCH_COLUMN);

// ✅ Get eligible products
$allProducts = $pdo->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
$reTestProducts = array_filter($allProducts, function ($p) use ($failed, $alreadyRetested) {
    return in_array($p['product_id'], $failed) && !in_array($p['product_id'], $alreadyRetested);
});




?>

<style>

    .container{
        width: 700px;
        margin-top: 150px; 
    }
label {
    font-weight: bold;
    margin-top: 10px;
    display: block;
}
.form-control {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    margin-bottom: 15px;
}
.btn-primary {
    padding: 10px 20px;
    font-size: 16px;
}
</style>

<div class="container">

    <div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-graph text-success"></i>
                    </div>
                    <div>Re Menufacture.
                        <div class="page-title-subheading">Enter Remanufacture Products.</div>
                    </div>
                </div>
            </div>
        </div>
        
  

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST">
  <!-- Product Dropdown -->
<label>Failed Product</label>
<select name="product_id" class="form-control" required>
    <option value="">-- Select Failed Product --</option>
    <?php foreach ($reTestProducts as $product): ?>
        <option value="<?= htmlspecialchars($product['product_id']) ?>">
            <?= htmlspecialchars($product['product_name']) ?>
        </option>
    <?php endforeach; ?>
</select>





    <!-- Tester Dropdown -->
    <label>Tested By</label>
    <select name="Tested_by" class="form-control" required>
        <option value="">Select Tester</option>
        <?php foreach ($testers as $t): ?>
            <option value="<?= htmlspecialchars($t['tester_id']) ?>">
                <?= htmlspecialchars($t['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- Department Dropdown -->
    <label>Department</label>
    <select name="Department" class="form-control" required>
        <option value="">Select Department</option>
        <?php foreach ($departments as $d): ?>
            <option value="<?= htmlspecialchars($d['department_id']) ?>">
                <?= htmlspecialchars($d['dept_name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <br>
    <button type="submit" name="Re-Submit" class="btn btn-primary">Submit</button>
</form>


</div>

<?php include("components/footer.php"); ?>
