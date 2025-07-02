<?php
include("php/query.php");
include("components/header.php");

?>
<style>

     .container{
        width: 700px;
        margin-top:  -600px ; 
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
                    <div>CPRI TEST
                        <div class="page-title-subheading">FILL THE FORM</div>
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

    <form method="POST" enctype="multipart/form-data">
        
        <!-- Product (Passed in lab_test and not tested in cpri_tests) -->
     <select name="product_id" class="form-control" required>
    <option value="">Select Failed Product</option>
    <?php foreach ($failedProducts as $product): ?>
        <option value="<?= htmlspecialchars($product['product_id']) ?>">
            <?= htmlspecialchars($product['product_name']) ?>
        </option>
    <?php endforeach; ?>
</select>


      

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
            <input type="file" name="uploaded_report" class="form-control" accept=".pdf,image/png,image/jpeg">
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
