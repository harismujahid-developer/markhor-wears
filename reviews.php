<?php
require_once 'connection.php';
include 'header.php';

if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    $stmt = $conn->prepare("DELETE FROM `reviews` WHERE id=?");
    $stmt->bind_param("i", $id);
    if($stmt->execute()) {
        echo "<script>window.location.href='reviews.php';</script>";
        exit();
    }
    $stmt->close();
}
?>

<div class="card p-3 border-0 shadow-sm bg-white rounded-3">
    <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-chat-left-quote me-2"></i>Consumer Fabric Critiques & Fitting Feedback Engine</h5>
    <table class="table align-middle small">
        <thead class="table-light">
            <tr><th>Patron Profile</th><th>Design Model Target</th><th>Apparel Review Commentary String</th><th class="text-center">Purge</th></tr>
        </thead>
        <tbody>
            <?php
            $res = $conn->query("SELECT * FROM `reviews` ORDER BY id DESC");
            if ($res && $res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    echo "<tr>
                        <td class='fw-bold text-dark'>{$row['customer_name']}</td>
                        <td><span class='badge bg-dark text-white'>{$row['product_name']}</span></td>
                        <td class='text-muted fst-italic'>\"{$row['comment']}\"</td>
                        <td class='text-center'>
                            <a href='reviews.php?del={$row['id']}' class='btn btn-sm btn-outline-danger px-2 py-1' onclick='return confirm(\"Delete feedback logging reference permanently?\");'><i class='bi bi-trash3'></i></a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='text-center text-muted py-4'>No design variations have critiques recorded at this operational interval.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>