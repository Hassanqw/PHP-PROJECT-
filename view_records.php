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
<div class="container p-5">
    <h2 class="mb-4">All Product Records</h2>

    <!-- Search Form -->
    <form method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" id="search" placeholder="Search by Product ID or Name" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <button type="submit" class="btn btn-primary" id="sButton">Search</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
    <tr>
        <th>#</th>
        <th>Product ID</th>
        <th>Product Name</th>
        <th>Tester Name</th>
        <th>Department Name</th>
        <th>Type</th>
        <th>Manufacture Date</th>
    </tr>
</thead>
     <tbody>

    <?php if (!empty($allProducts)): ?>
        <?php $count = 1; ?>
        <?php foreach ($allProducts as $product): ?>
            <tr>
                <td><?= $count++ ?></td>
                <td><?= htmlspecialchars($product['product_id']) ?></td>
                <td><?= htmlspecialchars($product['product_name']) ?></td>
                <td><?= htmlspecialchars($product['tester_name'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($product['department_name'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($product['type_name'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($product['manufacture_date']) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6">No records found.</td>
        </tr>
    <?php endif; ?>
</tbody>
    </table>
</div>

<?php include("components/footer.php"); ?>

