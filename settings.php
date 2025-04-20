<?php
require_once 'includes/config.php';
requireAuth();

// Get user's settings
$userSettings = $users->findOne(['_id' => new MongoDB\BSON\ObjectId($_SESSION['user_id'])]);

$page_title = 'Settings';
?>

<?php include 'includes/header.php'; ?>

<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Settings</h1>
        <p class="mt-1 text-sm text-gray-500">
            Manage your account settings and preferences
        </p>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Profile Settings -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900">Profile Settings</h3>
                <form action="update-profile.php" method="POST" class="mt-6 space-y-6">
                    <div>
                        <label for="name" class="label">Full Name</label>
                        <input type="text" id="name" name="name" class="input" 
                               value="<?php echo htmlspecialchars($userSettings['name']); ?>" required>
                    </div>
                    <div>
                        <label for="email" class="label">Email Address</label>
                        <input type="email" id="email" name="email" class="input" 
                               value="<?php echo htmlspecialchars($userSettings['email']); ?>" required>
                    </div>
                    <div>
                        <label for="company" class="label">Company Name</label>
                        <input type="text" id="company" name="company" class="input" 
                               value="<?php echo htmlspecialchars($userSettings['company'] ?? ''); ?>">
                    </div>
                    <div>
                        <label for="phone" class="label">Phone Number</label>
                        <input type="tel" id="phone" name="phone" class="input" 
                               value="<?php echo htmlspecialchars($userSettings['phone'] ?? ''); ?>">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-primary">
                            Save Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Account Settings -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900">Account Settings</h3>
                <form action="update-password.php" method="POST" class="mt-6 space-y-6">
                    <div>
                        <label for="current_password" class="label">Current Password</label>
                        <input type="password" id="current_password" name="current_password" class="input" required>
                    </div>
                    <div>
                        <label for="new_password" class="label">New Password</label>
                        <input type="password" id="new_password" name="new_password" class="input" required>
                    </div>
                    <div>
                        <label for="confirm_password" class="label">Confirm New Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="input" required>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-primary">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Notification Settings -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900">Notification Settings</h3>
                <form action="update-notifications.php" method="POST" class="mt-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <label for="email_notifications" class="text-sm font-medium text-gray-700">
                                Email Notifications
                            </label>
                            <p class="text-sm text-gray-500">
                                Receive email notifications for contract updates
                            </p>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="email_notifications" name="email_notifications" 
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                                   <?php echo ($userSettings['notifications']['email'] ?? true) ? 'checked' : ''; ?>>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <label for="contract_updates" class="text-sm font-medium text-gray-700">
                                Contract Updates
                            </label>
                            <p class="text-sm text-gray-500">
                                Get notified when contracts are updated
                            </p>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="contract_updates" name="contract_updates" 
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                                   <?php echo ($userSettings['notifications']['contract_updates'] ?? true) ? 'checked' : ''; ?>>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <label for="payment_reminders" class="text-sm font-medium text-gray-700">
                                Payment Reminders
                            </label>
                            <p class="text-sm text-gray-500">
                                Receive reminders for upcoming payments
                            </p>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="payment_reminders" name="payment_reminders" 
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                                   <?php echo ($userSettings['notifications']['payment_reminders'] ?? true) ? 'checked' : ''; ?>>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-primary">
                            Save Notifications
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Subscription Settings -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900">Subscription</h3>
                <div class="mt-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-700">Current Plan</p>
                            <p class="text-sm text-gray-500">
                                <?php echo ucfirst($userSettings['subscription']['plan'] ?? 'free'); ?> Plan
                            </p>
                        </div>
                        <div>
                            <a href="pricing.php" class="btn btn-primary">
                                Upgrade Plan
                            </a>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-700">Billing Information</p>
                        <p class="text-sm text-gray-500">
                            Next billing date: 
                            <?php 
                            if (isset($userSettings['subscription']['next_billing_date'])) {
                                echo date('M d, Y', strtotime($userSettings['subscription']['next_billing_date']));
                            } else {
                                echo 'N/A';
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?> 