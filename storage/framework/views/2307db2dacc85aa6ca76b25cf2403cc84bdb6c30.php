<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row login-container">
            <div class="col-12 col-md-6 pl-0">
                <img src="<?php echo e(getPageBackgroundSettings('remember_pass')); ?>" class="img-cover" alt="Login">
            </div>

            <div class="col-12 col-md-6">

                <div class="login-card">
                    <h1 class="font-20 font-weight-bold"><?php echo e(trans('auth.forget_password')); ?></h1>

                    <form method="post" action="/send-email" class="mt-35">
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        <div class="form-group">
                            <label class="input-label" for="email"><?php echo e(trans('auth.email')); ?>:</label>
                            <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email"
                                   aria-describedby="emailHelp">
                            <?php $__errorArgs = ['email'];
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

                        <button type="submit" class="btn btn-primary btn-block mt-20"><?php echo e(trans('auth.reset_password')); ?></button>
                    </form>

                    <div class="text-center mt-20">
                        <span class="badge badge-circle-gray300 text-secondary d-inline-flex align-items-center justify-content-center"><?php echo e(trans('auth.or')); ?></span>
                    </div>

                    <div class="text-center mt-20">
                        <span class="text-secondary">
                            <a href="/login" class="text-secondary font-weight-bold"><?php echo e(trans('auth.login')); ?></a>
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(getTemplate().'.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/lean0314/alllearn.com.br/public/resources/views/web/default/auth/forgot_password.blade.php ENDPATH**/ ?>