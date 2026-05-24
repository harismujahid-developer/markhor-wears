<?php
require_once 'connection.php';
include 'header.php';

if (isset($_POST['update_status'])) {
    $o_id = intval($_POST['order_id']);
    $new_status = trim($_POST['status']);
    
    $stmt = $conn->prepare("UPDATE `orders` SET `status`=? WHERE id=?");
    $stmt->bind_param("si", $new_status, $o_id);
    $stmt->execute();
    $stmt->close();
}
?>

<div class="card p-3 border-0 shadow-sm bg-white rounded-3">
    <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-truck me-2"></i>Fulfillment Engine Logistics Tracker</h5>
    <table class="table align-middle text-center small">
        <thead class="table-light">
            <tr><th>Invoice Handle</th><th>Client Identifier</th><th>Placement Date</th><th>Value Amount</th><th>Pipeline Status</th><th>Action Switch</th></tr>
        </thead>
        <tbody>
            <?php
            $res = $conn->query("SELECT * FROM `orders` ORDER BY id DESC");
            while ($row = $res->fetch_assoc()) {
                $status_class = "bg-secondary";
                if($row['status'] == 'delivered') $status_class = "bg-success";
                if($row['status'] == 'shipped') $status_class = "bg-info text-dark";
                if($row['status'] == 'processing') $status_class = "bg-warning text-dark";
                
                echo "<tr>
                    <td>#MK-{$row['id']}</td>
                    <td class='fw-bold text-dark text-start'>{$row['customer_name']}</td>
                    <td>{$row['order_date']}</td>
                    <td class='text-dark fw-semibold'>PKR " . number_format($row['total_amount']) . "</td>
                    <td><span class='badge $status_class text-uppercase' style='font-size:10px;'>{$row['status']}</span></td>
                    <td>
                        <form action='' method='post' class='d-flex justify-content-center gap-1'>
                            <input type='hidden' name='order_id' value='{$row['id']}' />
                            <select name='status' class='form-select form-select-sm' style='width:130px; font-size:12px;'>
                                <option value='pending'>Pending</option>
                                <option value='processing'>Processing</option>
                                <option value='shipped'>Shipped</option>
                                <option value='delivered'>Delivered</option>
                            </select>
                            <button type='submit' name='update_status' class='btn btn-dark btn-sm px-2'><i class='bi bi-arrow-repeat'></i></button>
                        </form>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>