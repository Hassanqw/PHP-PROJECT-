<?php
include("php/query.php");
include("components/header.php");
?>

<style>

    .container{
        width: 700px;
        margin-top:  -500px ; 
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
                    <div>Add New Departments
                        <div class="page-title-subheading">Enter Department details below.</div>
                    </div>
                </div>
            </div>
        </div>

    <form method="POST">
        <!-- Department Name -->
        <div class="mb-3">
            <label for="departmentName" class="form-label fw-bold">Department Name</label>
            <input type="text" class="form-control" id="departmentName" name="department_name" placeholder="Enter department name">
        </div>

        <!-- Location -->
        <div class="mb-3">
            <label for="location" class="form-label fw-bold">Location</label>
            <input type="text" class="form-control" id="location" name="location" placeholder="Enter department location">
        </div>

        <button type="submit" name="addDepartment" class="btn btn-success w-100">Add Department</button>
    </form>
</div>
<?php include("components/footer.php"); ?>
