<?php
require_once 'connection.php';
include 'header.php';

$feedback_msg = "";

if (isset($_POST['save_prod'])) {
    $name = trim($_POST['name']);
    $desc = trim($_POST['description']);
    $price = doubleval($_POST['price']);
    $stock = intval($_POST['stock']);
    $cat_id = intval($_POST['cat_id']);

    $img_file = $_FILES['p_img']['name'];
    $img_tmp = $_FILES['p_img']['tmp_name'];
    
    if(!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }
    
    $target_folder = "uploads/" . time() . "_" . basename($img_file);

    if (move_uploaded_file($img_tmp, $target_folder)) {
        $stmt = $conn->prepare("INSERT INTO `products` (`name`, `description`, `price`, `image`, `stock_quantity`, `category_id`) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdssi", $name, $desc, $price, $target_folder, $stock, $cat_id);
        if ($stmt->execute()) {
            $feedback_msg = "<div class='alert alert-success p-2 small border-0'>Apparel item logged successfully.</div>";
        } else {
            $feedback_msg = "<div class='alert alert-danger p-2 small border-0'>Configuration mismatch detected on database mapping.</div>";
        }
        $stmt->close();
    } else {
        $feedback_msg = "<div class='alert alert-danger p-2 small border-0'>Fabric specification image blueprint failed to upload.</div>";
    }
}

if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    $stmt = $conn->prepare("DELETE FROM `products` WHERE id=?");
    $stmt->bind_param("i", $id);
    if($stmt->execute()) {
        echo "<script>window.location.href='products.php';</script>";
        exit();
    }
    $stmt->close();
}
?>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card p-3 border-0 shadow-sm bg-white rounded-3">
            <h5 class="fw-bold mb-3 text-dark">Develop Custom Apparel Variant</h5>
            <?php echo $feedback_msg; ?>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-2">
                    <label class="form-label small fw-bold">Garment Item Label</label>
                    <input type="text" name="name" class="form-control form-control-sm" required />
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Ecosystem Line Link</label>
                    <select name="cat_id" class="form-select form-select-sm" required>
                        <?php
                        $cats = $conn->query("SELECT * FROM `categories` ORDER BY name ASC");
                        while($c = $cats->fetch_assoc()) {
                            echo "<option value='{$c['id']}'>{$c['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label small fw-bold">Unit Cost (PKR)</label>
                        <input type="number" name="price" class="form-control form-control-sm" required />
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">Fabric Units</label>
                        <input type="number" name="stock" class="form-control form-control-sm" required />
                    </div>
                </div>
                <div class="mb-2 mt-2">
                    <label class="form-label small fw-bold">Fabric Cut & Metric Blueprint Configurations</label>
                    <textarea name="description" class="form-control form-control-sm" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Design Artwork / Showcase File</label>
                    <input type="file" name="p_img" class="form-control form-control-sm" accept="image/*" required />
                </div>
                <button type="submit" name="save_prod" class="btn btn-dark btn-sm w-100" style="background:#1a2230;">Catalog Line Item</button>
            </form>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card p-3 border-0 shadow-sm bg-white rounded-3">
            <h5 class="fw-bold mb-3 text-dark">Inventory Track Matrix</h5>
            <table class="table table-hover align-middle small">
                <thead class="table-light">
                    <tr><th>Artwork File</th><th>Garment Variant Metadata</th><th>Unit Cost</th><th>Logistical Standing</th><th class="text-center">Purge</th></tr>
                </thead>
                <tbody>
                    <?php
                    $prods = $conn->query("SELECT * FROM `products` ORDER BY id DESC");
                    while ($p = $prods->fetch_assoc()) {
                        $stock_num = $p['stock_quantity'];
                        $badge = ($stock_num <= 5) ? "<span class='badge bg-danger'>Critical Stock: $stock_num remaining</span>" : "<span class='badge bg-success'>Supply Stable: $stock_num units</span>";
                        
                        echo "<tr>
                            <td><img src='{$p['image']}' width='45' height='45' class='rounded border shadow-sm' style='object-fit:cover;' /></td>
                            <td>
                                <div class='fw-bold text-dark'>{$p['name']}</div>
                                <div class='text-muted' style='font-size:11px; max-width:280px;'>{$p['description']}</div>
                            </td>
                            <td class='fw-semibold text-dark'>PKR " . number_format($p['price']) . "</td>
                            <td>$badge</td>
                            <td class='text-center'><a href='products.php?del={$p['id']}' class='btn btn-link link-danger p-0' onclick='return confirm(\"Drop this garment variant layout permanently?\");'><i class='bi bi-trash3-fill fs-6'></i></a></td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>