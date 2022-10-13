<section class="mt-30">
    <h2 class="section-title after-line"><?php echo e(trans('public.zoom_api')); ?></h2>

    <div class="row mt-20">
        <div class="col-12 col-lg-4">

            <div class="form-group">
                <label class="input-label"><?php echo e(trans('public.zoom_jwt_token')); ?></label>
                <textarea type="text" name="zoom_jwt_token" rows="6" class="form-control <?php $__errorArgs = ['zoom_jwt_token'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>  is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e((!empty($user) and empty($new_user) and $user->zoomApi) ? $user->zoomApi->jwt_token : old('zoom_jwt_token')); ?></textarea>
                <?php $__errorArgs = ['zoom_jwt_token'];
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

        </div>
    </div>
        <div>
        <p class="font-12 text-gray"><a href="https://marketplace.zoom.us/docs/guides/auth/jwt"><?php echo e(trans('public.how_zoom_jwt_token')); ?></a></p>
    </div>

</section>
<?php /**PATH /home1/lean0314/alllearn.com.br/public/resources/views/web/default/panel/setting/setting_includes/zoom_api.blade.php ENDPATH**/ ?>