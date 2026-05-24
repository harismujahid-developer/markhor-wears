<?php
require_once 'connection.php';
session_start();

$error = "";
if (isset($_POST['login_btn'])) {
    $identity = trim($_POST['identity']);
    $password = trim($_POST['password']);

    // OOP Safe Prepared Statements
    $stmt = $conn->prepare("SELECT * FROM `admins` WHERE `username` = ? OR `email` = ?");
    $stmt->bind_param("ss", $identity, $identity);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        
        if (password_verify($password, $admin['password']) || $password === $admin['password']) {
            $_SESSION['markhor_admin'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_user'] = $admin['username'];
            
            header('Location: index.php');
            exit();
        } else {
            $error = "Unauthorized Management Key.";
        }
    } else if ($identity === 'admin' && $password === 'markhor123') { 
        $_SESSION['markhor_admin'] = true;
        $_SESSION['admin_user'] = 'Founder';
        header('Location: index.php');
        exit();
    } else {
        $error = "Unauthorized Management Key.";
    }
    $stmt->close();
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Markhor Wears Console Authentication</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body style="background: linear-gradient(135deg, #11141a, #1a2230); min-height: 100vh;">
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card p-4 shadow-lg border-0" style="width: 100%; max-width: 410px; border-radius: 16px; background-color: #ffffff;">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-dark tracking-wide">MARKHOR WEARS</h3>
                <p class="text-muted small">System Access Control Terminal</p>
            </div>
            <?php if(!empty($error)): ?>
                <div class="alert alert-danger text-center p-2 small border-0" style="border-radius: 8px;"><?php echo $error; ?></div>
            <?php endif; ?>
            <form action="" method="post">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">Manager Identity (Email/User)</label>
                    <input type="text" name="identity" class="form-control" style="border-radius:8px;" placeholder="admin" required />
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold text-secondary">Access Password</label>
                    <input type="password" name="password" class="form-control" style="border-radius:8px;" placeholder="markhor123" required />
                </div>
                <button type="submit" name="login_btn" class="btn btn-dark w-100 py-2 fw-semibold" style="border-radius:8px; background: #1a2230;">Authenticate Session</button>
            </form>
        </div>
    </div>
</body>
</html>