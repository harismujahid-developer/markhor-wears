<?php
require_once 'connection.php';
include 'header.php';

$feedback_msg = "";

if (isset($_POST['save_cat'])) {
    $name = trim($_POST['name']);
    $desc = trim($_POST['description']);

    if (!empty($name)) {
        $stmt = $conn->prepare("INSERT INTO `categories` (`name`, `description`) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $desc);
        if ($stmt->execute()) {
            $feedback_msg = "<div class='alert alert-success p-2 small border-0'>New Design Line Registered.</div>";
        }
        $stmt->close();
    }
}

if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    $stmt = $conn->prepare("DELETE FROM `categories` WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>window.location.href='categories.php';</script>";
        exit();
    }
    $stmt->close();
}
?>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card p-3 border-0 shadow-sm bg-white rounded-3">
            <h5 class="fw-bold mb-3 text-dark">Deploy New Collection</h5>
            <?php echo $feedback_msg; ?>
            <form action="" method="post">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Collection Label Name</label>
                    <input type="text" name="name" class="form-control form-control-sm" placeholder="e.g., Markhor Premium Fits" required />
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Brand Narrative Sketch</label>
                    <textarea name="description" class="form-control form-control-sm" rows="3" placeholder="Describe aesthetic choices and themes..." required></textarea>
                </div>
                <button type="submit" name="save_cat" class="btn btn-dark btn-sm w-100" style="background:#1a2230;">Launch Collection Line</button>
            </form>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card p-3 border-0 shadow-sm bg-white rounded-3">
            <h5 class="fw-bold mb-3 text-dark">Active Ecosystem Collections</h5>
            <table class="table align-middle small">
                <thead class="table-light">
                    <tr><th>ID</th><th>Collection Line</th><th>Narrative Blueprint</th><th class="text-center">Action</th></tr>
                </thead>
                <tbody>
                    <?php
                    $res = $conn->query("SELECT * FROM `categories` ORDER BY id DESC");
                    while ($r = $res->fetch_assoc()) {
                        echo "<tr>
                            <td>#{$r['id']}</td>
                            <td class='fw-bold text-dark'>{$r['name']}</td>
                            <td class='text-muted small'>{$r['description']}</td>
                            <td class='text-center'>
                                <a href='categories.php?del={$r['id']}' class='btn btn-outline-danger btn-sm' onclick='return confirm(\"Purge this entire collection category variant?\");'><i class='bi bi-trash3'></i></a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>