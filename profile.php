<?php
require_once 'connection.php';
include 'header.php';

$msg = "";
$user_id = $_SESSION['admin_id'] ?? 1;

if (isset($_POST['update_profile'])) {
    $name = trim($_POST['username']);
    $email = trim($_POST['email']);
    $new_pass = trim($_POST['password']);

    if (!empty($new_pass)) {
        $secured_hash = password_hash($new_pass, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE `admins` SET `username`=?, `email`=?, `password`=? WHERE `id`=?");
        $stmt->bind_param("sssi", $name, $email, $secured_hash, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE `admins` SET `username`=?, `email`=? WHERE `id`=?");
        $stmt->bind_param("ssi", $name, $email, $user_id);
    }

    if ($stmt->execute()) {
        $msg = "<div class='alert alert-success small p-2 border-0'>System parameter configurations modification successfully committed!</div>";
        $_SESSION['admin_user'] = $name;
    } else {
        $msg = "<div class='alert alert-danger small p-2 border-0'>Execution pipeline dropped an exception query mapping error.</div>";
    }
    $stmt->close();
}

$admin_data = $conn->query("SELECT * FROM `admins` WHERE `id` = $user_id")->fetch_assoc();
?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card p-4 border-0 shadow-sm bg-white rounded-3">
            <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-fingerprint me-2"></i>Executive Portal Security Signatures</h5>
            <?php echo $msg; ?>
            <form action="" method="post">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Founder Handle Username</label>
                    <input type="text" name="username" class="form-control form-control-sm" value="<?php echo htmlspecialchars($admin_data['username'] ?? $_SESSION['admin_user']); ?>" required />
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Primary Corporate Communications Node</label>
                    <input type="email" name="email" class="form-control form-control-sm" value="<?php echo htmlspecialchars($admin_data['email'] ?? 'management@markhorwears.com'); ?>" required />
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Alter Encryption Key Signature</label>
                    <input type="password" name="password" class="form-control form-control-sm" placeholder="Leave blank to retain current token signature value..." />
                </div>
                <button type="submit" name="update_profile" class="btn btn-dark btn-sm w-100" style="background:#1a2230;">Apply Architectural Security Upgrades</button>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>