<?php 
include("php/query.php"); 
include("components/header.php"); 


?>

<style>

    .container{
        width: 600px;
        font: 1em sans-serif;
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
                    <div>Add New Product
                        <div class="page-title-subheading">Enter Product details below.</div>
                    </div>
                </div>
            </div>
        </div>

    <form method="POST" enctype="multipart/form-data">
        <!-- Product Name -->
        <div class="mb-3">
            <label for="productName" class="form-label fw-bold">Product Name</label>
            <input type="text" class="form-control form-control-lg" id="productName" name="product_name" placeholder="Enter product Name" value="<?php echo htmlspecialchars($product_name); ?>">
            <small class="text-danger"><?php echo $productNameErr ?? ''; ?></small>
        </div>

        <!-- Product Type -->
        <div class="mb-3">
            <label for="productType" class="form-label fw-bold">Product Type</label>
            <select name="product_type_id" id="productType" class="form-control form-control-lg">
                <option value="">Select Product Type</option>
                <?php
                $query = $pdo->query("SELECT product_type_id, type_name FROM product_types");
                $productTypes = $query->fetchAll(PDO::FETCH_ASSOC);
                foreach ($productTypes as $type) {
                    $selected = ($product_type_id == $type['product_type_id']) ? 'selected' : '';
                    echo "<option value=\"" . htmlspecialchars($type['product_type_id']) . "\" $selected>" . htmlspecialchars($type['type_name']) . "</option>";
                }
                ?>
            </select>
            <small class="text-danger"><?php echo $productTypeIdErr ?? ''; ?></small>
        </div>

        <!-- Revise Code (Read-only display + Hidden input) -->
        <div class="mb-3">
            <input type="hidden" class="form-control form-control-lg" id="reviseCode" value="<?php echo htmlspecialchars($revise_code); ?>" readonly>
            <input type="hidden" name="revise_code" value="<?php echo htmlspecialchars($revise_code); ?>">
        </div>

        <!-- Manufacture No (Read-only display + Hidden input) -->
        <div class="mb-3">
            <input type="hidden" class="form-control form-control-lg" id="manufactureNo" value="<?php echo htmlspecialchars($manufacture_no); ?>" readonly>
            <input type="hidden" name="manufacture_no" value="<?php echo htmlspecialchars($manufacture_no); ?>">
        </div>

        <!-- Manufacture Date -->
        <div class="mb-3">
            <label for="manufactureDate" class="form-label fw-bold">Manufacture Date</label>
            <input type="date" class="form-control form-control-lg" id="manufactureDate" name="manufacture_date" max="<?= date('Y-m-d'); ?>" value="<?php echo htmlspecialchars($manufacture_date); ?>required>
            <small class="text-danger"><?php echo $manufactureDateErr ?? ''; ?></small>
        </div>

        <!-- Submit Button -->
        <button name="addproduct" class="btn btn-primary btn-lg w-100">Add Product</button>
    </form>
</div>

<?php include("components/footer.php"); ?>
