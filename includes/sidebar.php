<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="col-md-3">
    <div class="card sidebar">
        <div class="card-body">
            <div class="text-center mb-4">
                <img src="/assets/img/profile-placeholder.png" class="rounded-circle mb-3" alt="Profile" width="100">
                <h5 class="text-white"><?php echo $_SESSION['user_name'] ?? 'User'; ?></h5>
                <p class="text-white-50">Freelance Developer</p>
            </div>
            <nav class="nav flex-column">
                <a class="nav-link <?php echo $current_page === 'dashboard.php' ? 'active' : ''; ?>" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i> Dashboard
                </a>
                <a class="nav-link <?php echo $current_page === 'contracts.php' ? 'active' : ''; ?>" href="contracts.php">
                    <i class="fas fa-fw fa-file-contract"></i> Contracts
                </a>
                <a class="nav-link <?php echo $current_page === 'clients.php' ? 'active' : ''; ?>" href="clients.php">
                    <i class="fas fa-fw fa-users"></i> Clients
                </a>
                <a class="nav-link <?php echo $current_page === 'new-contract.php' ? 'active' : ''; ?>" href="new-contract.php">
                    <i class="fas fa-fw fa-plus-circle"></i> New Contract
                </a>
                <a class="nav-link <?php echo $current_page === 'settings.php' ? 'active' : ''; ?>" href="settings.php">
                    <i class="fas fa-fw fa-cog"></i> Settings
                </a>
            </nav>
        </div>
    </div>
</div> 