<?php
include("php/query.php");
include("components/header.php");


?>

<style>
    .container {
        width: 700px;
        margin-top: -500px;
    }
</style>

<div class="container">
    <div class="app-main__outer">
               <div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-box1 text-success"></i>
                    </div>
                    <div>Testing Type
                     
                    </div>
                </div>
            </div>
        </div>

    <div class="container mt-5" style="max-width: 600px;">
        <form method="POST">
            <!-- Test Name -->
            <div class="mb-3">
                <label for="testName" class="form-label fw-bold">Test Name</label>
                <input type="text" class="form-control" id="testName" name="test_name" placeholder="e.g. CPRI Test" value="<?php echo htmlspecialchars($test_name); ?>">
                <small class="text-danger"><?php echo $testNameErr; ?></small>
            </div>

            <!-- Department Dropdown -->
            <div class="mb-3">
                <label for="departmentId" class="form-label fw-bold">Department</label>
                <select class="form-control" id="departmentId" name="department_id" required>
                    <option value="">-- Select Department --</option>
                    <?php foreach ($departments as $dept): ?>
                        <option value="<?php echo htmlspecialchars($dept['department_id']); ?>"
                            <?php if ($dept['department_id'] == $department_id) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($dept['dept_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <small class="text-danger"><?php echo $departmentIdErr; ?></small>
            </div>

            <!-- Submit -->
            <button type="submit" name="addTestingType" class="btn btn-primary w-100">Add Testing Type</button>
        </form>
    </div>
</div>

<?php include("components/footer.php"); ?>
