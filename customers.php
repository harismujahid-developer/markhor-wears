<?php
require_once 'connection.php';
include 'header.php';

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Pagination Cluster Sets Setup
$limit = 5; 
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

$search_escaped = $conn->real_escape_string($search);
$count_query = "SELECT COUNT(*) AS total FROM `customers`";
if (!empty($search)) {
    $count_query .= " WHERE `name` LIKE '%$search_escaped%' OR `city` LIKE '%$search_escaped%' OR `email` LIKE '%$search_escaped%'";
}
$total_rows = $conn->query($count_query)->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

$sql = "SELECT * FROM `customers`";
if (!empty($search)) {
    $sql .= " WHERE `name` LIKE '%$search_escaped%' OR `city` LIKE '%$search_escaped%' OR `email` LIKE '%$search_escaped%'";
}
$sql .= " ORDER BY name ASC LIMIT $limit OFFSET $offset";
$res = $conn->query($sql);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold text-dark m-0"><i class="bi bi-people me-2"></i>Brand Consumer & Subscriber Ledger</h5>
    <form action="" method="get" class="d-flex gap-2" style="max-width: 320px;">
        <input type="text" name="search" class="form-control form-control-sm" placeholder="Filter parameters..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit" class="btn btn-dark btn-sm px-3" style="background:#1a2230;">Query</button>
    </form>
</div>

<div class="card p-3 border-0 shadow-sm bg-white rounded-3">
    <table class="table table-striped align-middle small">
        <thead class="table-light">
            <tr><th>Account Code</th><th>Full Identity</th><th>Secure Electronic Mail Address</th><th>Contact Index</th><th>Shipping Target Node</th></tr>
        </thead>
        <tbody>
            <?php if ($res && $res->num_rows > 0): ?>
                <?php while ($row = $res->fetch_assoc()): ?>
                    <tr>
                        <td>#MKC-<?php echo $row['id']; ?></td>
                        <td class='fw-bold text-dark'><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><span class='badge bg-light text-dark border'><?php echo $row['city']; ?></span></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" class="text-center text-muted py-4">No accounts found corresponding with standard query array descriptor configurations.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if ($total_pages > 1): ?>
        <nav class="mt-2">
            <ul class="pagination pagination-sm justify-content-center m-0">
                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php if($page == $i) echo 'active'; ?>">
                        <a class="page-link" href="customers.php?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>