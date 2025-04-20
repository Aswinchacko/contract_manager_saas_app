<?php
require_once 'includes/config.php';

if (isAuthenticated()) {
    redirect('dashboard.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    // Validate input
    if (empty($email) || empty($password)) {
        $error = 'Email and password are required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format';
    } else {
        // Find user in MongoDB
        $user = findUser($email);
        
        if ($user && password_verify($password, $user['password'])) {
            // Check subscription status
            $now = new MongoDB\BSON\UTCDateTime();
            $trialEndsAt = $user['trial_ends_at'];
            
            if ($user['subscription_status'] === 'trial' && $now > $trialEndsAt) {
                $error = 'Your trial period has ended. Please subscribe to continue using our services.';
            } else {
                // Set session variables
                $_SESSION['user_id'] = (string)$user['_id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['subscription_status'] = $user['subscription_status'];
                
                // Set remember me cookie if requested
                if ($remember) {
                    $token = generateToken();
                    $expires = time() + (30 * 24 * 60 * 60); // 30 days
                    
                    // Update user with remember token
                    updateUser($user['_id'], [
                        'remember_token' => $token,
                        'remember_token_expires' => new MongoDB\BSON\UTCDateTime($expires * 1000)
                    ]);
                    
                    setcookie('remember_token', $token, $expires, '/', '', true, true);
                }
                
                // Update last login
                updateUser($user['_id'], [
                    'last_login' => new MongoDB\BSON\UTCDateTime()
                ]);
                
                redirect('dashboard.php');
            }
        } else {
            $error = 'Invalid email or password';
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-center mb-4">Login to <?php echo APP_NAME; ?></h2>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" 
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <p>
                            <a href="forgot-password.php">Forgot your password?</a>
                        </p>
                        <p>
                            Don't have an account? <a href="register.php">Register here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?> 