<?php
include("php/query.php");
include("components/header.php");


?>

<style>
.container {
    width: 700px;
    margin-top: -500px;
    margin-left: 300px;
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
