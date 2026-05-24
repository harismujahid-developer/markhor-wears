<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['markhor_admin']) || $_SESSION['markhor_admin'] !== true) {
    header("Location: login.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Markhor Wears - Brand Management Framework</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .navbar-brand { font-weight: 800; letter-spacing: 1px; color: #d4af37 !important; }
        .bg-custom-dark { background-color: #11141a !important; }
        .nav-link:hover { color: #d4af37 !important; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-custom-dark shadow-sm py-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><i class="bi bi-activity me-2"></i>MARKHOR WEARS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#markhorNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="markhorNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.php"><i class="bi bi-cpu me-1"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="categories.php"><i class="bi bi-grid-1x2 me-1"></i> Apparel Collections</a></li>
                    <li class="nav-item"><a class="nav-link" href="products.php"><i class="bi bi-scissors me-1"></i> Product Lines</a></li>
                    <li class="nav-item"><a class="nav-link" href="orders.php"><i class="bi bi-bag-check me-1"></i> Order Pipeline</a></li>
                    <li class="nav-item"><a class="nav-link" href="customers.php"><i class="bi bi-person-lines-fill me-1"></i> Brand Clientele</a></li>
                    <li class="nav-item"><a class="nav-link" href="reviews.php"><i class="bi bi-chat-square-quote me-1"></i> Feedback</a></li>
                    <li class="nav-item"><a class="nav-link text-warning" href="profile.php"><i class="bi bi-sliders me-1"></i> Settings</a></li>
                </ul>
                <div class="d-flex">
                    <a href="logout.php" class="btn btn-outline-danger btn-sm px-3 border-0"><i class="bi bi-power"></i> Secure Exit</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container my-4">