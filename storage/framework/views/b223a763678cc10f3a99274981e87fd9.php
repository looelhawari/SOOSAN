<?php $__env->startSection('title', __('auth.admin_login')); ?>

<?php $__env->startSection('content'); ?>
    <div class="min-vh-100 d-flex align-items-center justify-content-center"
        style="background: linear-gradient(135deg, #66aaea 0%, #764ba2 100%);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="admin-card p-4">
                        <!-- Logo/Brand -->
                        <div class="text-center mb-4">
                            <i class="fas fa-cogs fa-3x text-primary mb-3"></i>
                            <h2 class="h4 mb-0"><?php echo e(__('auth.admin_panel')); ?></h2>
                            <p class="text-muted"><?php echo e(__('auth.sign_in_to_dashboard')); ?></p>
                        </div>

                        <!-- Session Status -->
                        <?php if(session('status')): ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                <?php echo e(session('status')); ?>

                            </div>
                        <?php endif; ?>

                        <!-- Login Form -->
                        <form method="POST" action="<?php echo e(route('admin.login.submit')); ?>" id="adminLoginForm">
                            <?php echo csrf_field(); ?>

                            <!-- Email Field -->
                            <div class="mb-3">
                                <label for="email" class="form-label"><?php echo e(__('auth.email_address')); ?></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                                        placeholder="<?php echo e(__('auth.enter_your_email')); ?>" aria-describedby="email-help">
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback">
                                            <?php if(Str::contains($message, 'mailto:')): ?>
                                                <?php echo $message; ?>

                                            <?php else: ?>
                                                <?php echo e($message); ?>

                                            <?php endif; ?>
                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <small id="email-help" class="form-text text-muted"><?php echo e(__('auth.valid_email')); ?></small>
                            </div>

                            <!-- Password Field -->
                            <div class="mb-3">
                                <label for="password" class="form-label"><?php echo e(__('auth.password')); ?></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="password" name="password" required
                                        placeholder="<?php echo e(__('auth.enter_your_password')); ?>"
                                        aria-describedby="password-help">
                                    <button type="button" class="btn btn-outline-secondary" onclick="toggleAdminPassword()"
                                        title="<?php echo e(__('auth.toggle_password_visibility')); ?>">
                                        <i class="fas fa-eye" id="admin-password-eye"></i>
                                    </button>
                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <small id="password-help"
                                    class="form-text text-muted"><?php echo e(__('auth.secure_password')); ?></small>
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    <?php echo e(__('auth.remember_me_30_days')); ?>

                                </label>
                            </div>

                            <!-- Language Selection -->
                            <div class="mb-3">
                                <label for="language" class="form-label"><?php echo e(__('auth.preferred_language')); ?></label>
                                <select class="form-select" id="language" name="language">
                                    <option value="en">English</option>
                                    <option value="ar">العربية</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-admin-primary btn-lg" id="adminLoginBtn">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    <?php echo e(__('auth.sign_in')); ?>

                                </button>
                            </div>
                        </form>

                        <!-- Security Notice -->
                        <div class="mt-3 text-center">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                <?php echo e(__('auth.secure_connection')); ?>

                            </small>
                        </div>

                        <!-- Back to Website Link -->
                        <div class="text-center mt-4">
                            <a href="<?php echo e(route('homepage')); ?>" class="text-decoration-none">
                                <i class="fas fa-arrow-left me-1"></i>
                                <?php echo e(__('auth.back_to_website')); ?>

                            </a>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Prevent Back Button to Protected Pages
        (function() {
            if (window.history && window.history.pushState) {
                window.history.pushState(null, null, window.location.href);
                window.addEventListener('popstate', function() {
                    window.history.pushState(null, null, window.location.href);
                });
            }

            // Clear browser cache on page load
            if (performance.navigation.type === 2) { // Returned via back button
                window.location.reload();
            }
        })();

        // User Preferences Manager
        const UserPreferences = {
            load: function() {
                const preferences = localStorage.getItem('adminPreferences');
                return preferences ? JSON.parse(preferences) : {};
            },

            save: function(key, value) {
                const preferences = this.load();
                preferences[key] = value;
                localStorage.setItem('adminPreferences', JSON.stringify(preferences));
            },

            get: function(key, defaultValue = null) {
                const preferences = this.load();
                return preferences[key] || defaultValue;
            },

            clear: function() {
                localStorage.removeItem('adminPreferences');
            }
        };

        function toggleAdminPassword() {
            const passwordInput = document.getElementById('password');
            const passwordEye = document.getElementById('admin-password-eye');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordEye.classList.remove('fa-eye');
                passwordEye.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordEye.classList.remove('fa-eye-slash');
                passwordEye.classList.add('fa-eye');
            }
        }

        // Add loading state to admin login form
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('adminLoginForm');
            const submitButton = document.getElementById('adminLoginBtn');
            const originalText = submitButton.innerHTML;

            // Apply saved preferences on page load
            const savedLanguage = UserPreferences.get('language', 'en');
            const languageSelect = document.getElementById('language');
            if (languageSelect) {
                languageSelect.value = savedLanguage;
            }

            // Restore remember me preference
            const rememberMe = UserPreferences.get('rememberMe', false);
            const rememberCheckbox = document.getElementById('remember');
            if (rememberCheckbox) {
                rememberCheckbox.checked = rememberMe;
            }

            form.addEventListener('submit', function() {
                // Save preferences when form is submitted
                const languageSelect = document.getElementById('language');
                const rememberCheckbox = document.getElementById('remember');

                if (languageSelect) {
                    UserPreferences.save('language', languageSelect.value);
                }

                if (rememberCheckbox) {
                    UserPreferences.save('rememberMe', rememberCheckbox.checked);
                }

                submitButton.disabled = true;
                submitButton.innerHTML =
                    '<i class="fas fa-spinner fa-spin me-2"></i><?php echo e(__('auth.processing')); ?>';

                // Re-enable button after 5 seconds as failsafe
                setTimeout(() => {
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalText;
                }, 5000);
            });

            // Add focus effects
            const inputs = form.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('input-group-focus');
                });

                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('input-group-focus');
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\drilling-dashboard-listing\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>