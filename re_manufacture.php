<?php
include("php/query.php");
include("components/header.php");

// Step 1: All products
$allProducts = $pdo->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);

/// Step 1: All products
$allProducts = $pdo->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);

// Step 2: Get products which have passed lab_test
$passedProductIds = $pdo->query("
    SELECT DISTINCT product_id 
    FROM lab_test 
    WHERE result = 'Pass'
")->fetchAll(PDO::FETCH_COLUMN);

// Step 3: Get products which have failed (i.e. NOT passed)
$failedProducts = array_filter($allProducts, function($p) use ($passedProductIds) {
    return !in_array($p['product_id'], $passedProductIds);
});

// **New Step: Get products already added in re-manufacture**
$addedRemanufactureProductIds = $pdo->query("
    SELECT DISTINCT `Re-Product_id` FROM `re-manufacture`
")->fetchAll(PDO::FETCH_COLUMN);

// Step 4: Filter failed products to exclude those already added to re-manufacture
$availableProductsForRemanufacture = array_filter($failedProducts, function($p) use ($addedRemanufactureProductIds) {
    return !in_array($p['product_id'], $addedRemanufactureProductIds);
});

// Step 3: Get products which have failed (i.e. NOT passed)
$failedProducts = array_filter($allProducts, function($p) use ($passedProductIds) {
    return !in_array($p['product_id'], $passedProductIds);
});

// Step 4: Get testers and departments for dropdowns
$testers = $pdo->query("SELECT * FROM testers")->fetchAll(PDO::FETCH_ASSOC);
$departments = $pdo->query("SELECT * FROM departments")->fetchAll(PDO::FETCH_ASSOC);

// Step 5: On form submission, insert into re-manufacture table
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remanufactureForm'])) {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO `re-manufacture` (`Re-Product_id`, `Tested_by`, `Department`) 
            VALUES (:re_product_id, :tested_by, :department)
        ");

        $stmt->execute([
            ':re_product_id' => $_POST['Re_Product_id'],
            ':tested_by' => $_POST['Tested_by'],
            ':department' => $_POST['Department'],
        ]);

        echo "<script>alert('Re-Manufacture record added successfully!'); window.location.href='re_manufacture.php';</script>";
        exit;

    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>

<style>
.container {
    width: 600px;
    margin: 50px auto;
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
    <h2>Add Re-Manufacture Record</h2>
    <form method="POST">
      <select name="Re_Product_id" id="Re_Product_id" class="form-control" required>
    <option value="">Select Product</option>
    <?php foreach ($availableProductsForRemanufacture as $p): ?>
        <option value="<?= htmlspecialchars($p['product_id']) ?>">
            <?= htmlspecialchars($p['product_name']) ?>
        </option>
    <?php endforeach; ?>
</select>


        <!-- Tested By -->
        <label for="Tested_by">Tested By</label>
        <select name="Tested_by" id="Tested_by" class="form-control" required>
            <option value="">Select Tester</option>
            <?php foreach ($testers as $t): ?>
                <option value="<?= htmlspecialchars($t['tester_id']) ?>">
                    <?= htmlspecialchars($t['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Department -->
        <label for="Department">Department</label>
        <select name="Department" id="Department" class="form-control" required>
            <option value="">Select Department</option>
            <?php foreach ($departments as $d): ?>
                <option value="<?= htmlspecialchars($d['department_id']) ?>">
                    <?= htmlspecialchars($d['dept_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" name="remanufactureForm" class="btn btn-primary">Submit</button>
    </form>
</div>

<?php include("components/footer.php"); ?>
