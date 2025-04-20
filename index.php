<?php
require_once 'includes/config.php';

if (isAuthenticated()) {
    redirect('dashboard.php');
} else {
    redirect('login.php');
}
?> 