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
                        <i class="pe-7s-graph text-success"></i>
                    </div>
                    <div>Add New Tester
                        <div class="page-title-subheading">Enter Tester details below.</div>
                    </div>
                </div>
            </div>
        </div>


    <form method="POST">
        <!-- Tester Name -->
        <div class="mb-3">
            <label for="testerName" class="form-label fw-bold">Tester Name</label>
            <input type="text" class="form-control" id="testerName" name="tester_name" placeholder="Enter tester name">
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label fw-bold">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address">
        </div>

       <!-- Password -->
<div class="mb-3">
    <label for="password" class="form-label fw-bold">Password</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Set password for tester">
    <div class="form-check mt-2">
        <input type="checkbox" class="form-check-input" id="showPassword" onclick="togglePassword()">
        <label class="form-check-label" for="showPassword">Show Password</label>
    </div>
</div>


        <!-- Department -->
        <div class="mb-3">
            <label for="department" class="form-label fw-bold">Department</label>
            <select class="form-control" id="department" name="department_id">
                <option value="">Select Department</option>
                <?php
                $departments = $pdo->query("SELECT * FROM departments")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($departments as $dept) {
                    echo "<option value='{$dept['department_id']}'>{$dept['dept_name']}</option>";
                }
                ?>
            </select>
        </div>
        <button name="addTester" class="btn btn-primary w-100">Add Tester</button>
    </form>
</div>
<script>
function togglePassword() {
    var passField = document.getElementById("password");
    passField.type = (passField.type === "password") ? "text" : "password";
}
</script>

<?php include("components/footer.php"); 
?>
