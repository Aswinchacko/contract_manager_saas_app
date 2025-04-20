    </main>
    
    <?php if (!isAuthenticated()): ?>
    <!-- Footer for non-authenticated pages -->
    <footer class="bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Product</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="features.php" class="text-base text-gray-500 hover:text-gray-900">Features</a></li>
                        <li><a href="pricing.php" class="text-base text-gray-500 hover:text-gray-900">Pricing</a></li>
                        <li><a href="templates.php" class="text-base text-gray-500 hover:text-gray-900">Templates</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Company</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="about.php" class="text-base text-gray-500 hover:text-gray-900">About</a></li>
                        <li><a href="blog.php" class="text-base text-gray-500 hover:text-gray-900">Blog</a></li>
                        <li><a href="careers.php" class="text-base text-gray-500 hover:text-gray-900">Careers</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Resources</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="help.php" class="text-base text-gray-500 hover:text-gray-900">Help Center</a></li>
                        <li><a href="contact.php" class="text-base text-gray-500 hover:text-gray-900">Contact</a></li>
                        <li><a href="privacy.php" class="text-base text-gray-500 hover:text-gray-900">Privacy</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Connect</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="#" class="text-base text-gray-500 hover:text-gray-900">Twitter</a></li>
                        <li><a href="#" class="text-base text-gray-500 hover:text-gray-900">LinkedIn</a></li>
                        <li><a href="#" class="text-base text-gray-500 hover:text-gray-900">GitHub</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-200 pt-8">
                <p class="text-base text-gray-400 text-center">
                    &copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
    <?php endif; ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?php echo APP_URL; ?>/assets/js/main.js"></script>
</body>
</html> 