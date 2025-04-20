<?php include 'includes/header.php'; ?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2>Simple, Transparent Pricing</h2>
        <p class="lead">Choose the plan that's right for you</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="card-title">Professional Plan</h3>
                    <div class="display-4 my-4">$99<span class="text-muted">/month</span></div>
                    <p class="text-success mb-4">Start with a 10-day free trial</p>
                    
                    <ul class="list-unstyled mb-4">
                        <li class="mb-3">
                            <i class="fas fa-check text-success me-2"></i>
                            Unlimited Contracts
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-check text-success me-2"></i>
                            Client Management
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-check text-success me-2"></i>
                            Contract Templates
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-check text-success me-2"></i>
                            PDF Generation
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-check text-success me-2"></i>
                            Priority Support
                        </li>
                    </ul>

                    <?php if (isAuthenticated()): ?>
                        <a href="settings.php" class="btn btn-primary btn-lg w-100">Manage Subscription</a>
                    <?php else: ?>
                        <a href="register.php" class="btn btn-primary btn-lg w-100">Start Free Trial</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                    <h5>Secure & Reliable</h5>
                    <p>Your data is protected with enterprise-grade security</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-sync fa-3x text-primary mb-3"></i>
                    <h5>Flexible Billing</h5>
                    <p>Cancel anytime, no long-term commitment required</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-headset fa-3x text-primary mb-3"></i>
                    <h5>24/7 Support</h5>
                    <p>Get help whenever you need it</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?> 