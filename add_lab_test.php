<?php
include("php/query.php");
include("components/header.php");


?>
<style>

    .container{
        width: 700px;
        margin-top: 150px; 
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
                <label>Product</label>
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
                <input type="date" name="test_date" class="form-control"  max="<?= date('Y-m-d'); ?>" Required>

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

                <!-- Created/Updated -->
                <input type="hidden" name="created_at" value="<?= date('Y-m-d H:i:s') ?>">
                <input type="hidden" name="updated_at" value="<?= date('Y-m-d H:i:s') ?>">
                <input type="hidden" name="labTest" value="1"> 
                <br>
                <button type="submit" name="labTest" class="btn btn-primary">Submit Lab Test</button>
            </form>
        </div>
    </div>
</div>

<?php include("components/footer.php"); ?>
 