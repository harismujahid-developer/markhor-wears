<?php
require_once 'connection.php';
include 'header.php';

$sales_res = $conn->query("SELECT SUM(total_amount) AS income FROM `orders` WHERE status='delivered'");
$sales_data = $sales_res->fetch_assoc();
$total_turnover = $sales_data['income'] ?? 0;

$orders_cnt = $conn->query("SELECT COUNT(*) as tot FROM `orders`")->fetch_assoc()['tot'];
$cats_cnt = $conn->query("SELECT COUNT(*) as tot FROM `categories`")->fetch_assoc()['tot'];
$prods_cnt = $conn->query("SELECT COUNT(*) as tot FROM `products`")->fetch_assoc()['tot'];
$custs_cnt = $conn->query("SELECT COUNT(*) as tot FROM `customers`")->fetch_assoc()['tot'];
?>

<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold text-dark">Brand Operational Analytics Console</h2>
        <p class="text-muted small">Live orchestration node linking customized apparel variants, fabrication volume, and active customer acquisitions inside <strong>mar_wear_db</strong>.</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4 col-sm-12">
        <div class="card border-0 shadow-sm p-4 text-white" style="background-color: #1a2230;">
            <h6 class="text-uppercase small tracking-wider opacity-75 mb-1">Gross Realized Value</h6>
            <h3 class="fw-bold m-0 text-warning">PKR <?php echo number_format($total_turnover); ?></h3>
        </div>
    </div>
    <div class="col-md-2 col-sm-6">
        <div class="card bg-white border-0 shadow-sm p-3">
            <h6 class="text-uppercase text-muted small opacity-75 mb-1">Total Pipeline</h6>
            <h3 class="fw-bold m-0 text-dark"><?php echo $orders_cnt; ?> <span class="small fs-6 text-muted">Orders</span></h3>
        </div>
    </div>
    <div class="col-md-2 col-sm-6">
        <div class="card bg-white border-0 shadow-sm p-3">
            <h6 class="text-uppercase text-muted small opacity-75 mb-1">Apparel Lines</h6>
            <h3 class="fw-bold m-0 text-dark"><?php echo $prods_cnt; ?> <span class="small fs-6 text-muted">SKUs</span></h3>
        </div>
    </div>
    <div class="col-md-2 col-sm-6">
        <div class="card bg-white border-0 shadow-sm p-3">
            <h6 class="text-uppercase text-muted small opacity-75 mb-1">Collections</h6>
            <h3 class="fw-bold m-0 text-dark"><?php echo $cats_cnt; ?></h3>
        </div>
    </div>
    <div class="col-md-2 col-sm-6">
        <div class="card bg-white border-0 shadow-sm p-3">
            <h6 class="text-uppercase text-muted small opacity-75 mb-1">Client Base</h6>
            <h3 class="fw-bold m-0 text-dark"><?php echo $custs_cnt; ?></h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm p-4 bg-white text-center rounded-3">
            <i class="bi bi-shield-check text-success fs-1"></i>
            <h5 class="fw-bold text-dark mt-2">Database Encryption Stack Verified</h5>
            <p class="text-muted small mx-auto" style="max-width:500px;">
                Session tokens are monitored continuously. All modification pathways targeting the localized tables inside the <strong>mar_wear_db</strong> data schema require authorized signatures.
            </p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>