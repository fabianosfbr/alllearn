<!-- Modal -->
<div class="d-none" id="extraDescriptionForm">
    <h3 class="section-title after-line font-20 text-dark-blue mb-25"><?php echo e(trans('update.add_items')); ?></h3>

    <form action="/admin/webinar-extra-description/store" method="post">
        <input type="hidden" name="webinar_id" value="<?php echo e(!empty($webinar) ? $webinar->id :''); ?>">
        <input type="hidden" name="type">

        <div class="js-form-groups">
            <?php if(!empty(getGeneralSettings('content_translate'))): ?>
                <div class="js-no-company-input form-group">
                    <label class="input-label"><?php echo e(trans('auth.language')); ?></label>
                    <select name="locale" class="form-control ">
                        <?php $__currentLoopData = $userLanguages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($lang); ?>" <?php if(mb_strtolower(request()->get('locale', app()->getLocale())) == mb_strtolower($lang)): ?> selected <?php endif; ?>><?php echo e($language); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['locale'];
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
            <?php else: ?>
                <input type="hidden" name="locale" value="<?php echo e(getDefaultLocale()); ?>">
            <?php endif; ?>

            <div class="js-no-company-input form-group">
                <label class="input-label"><?php echo e(trans('public.title')); ?></label>
                <input type="text" name="value" class="form-control"/>
                <div class="invalid-feedback"></div>
            </div>
        </div>

        <div class="mt-30 d-flex align-items-center justify-content-end">
            <button type="button" id="saveExtraDescription" class="btn btn-primary"><?php echo e(trans('public.save')); ?></button>
            <button type="button" class="btn btn-danger ml-2 close-swl"><?php echo e(trans('public.close')); ?></button>
        </div>
    </form>
</div>
<?php /**PATH /home1/lean0314/alllearn.com.br/public/resources/views/admin/webinars/modals/extra_description.blade.php ENDPATH**/ ?>