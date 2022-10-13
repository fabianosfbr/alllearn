<?php $__env->startSection('content'); ?>
    <div class="container">

        <div class="row login-container">
            <div class="col-12 col-md-6 pl-0">
                <img src="<?php echo e(getPageBackgroundSettings('become_instructor')); ?>" class="img-cover" alt="Login">
            </div>

            <div class="col-12 col-md-6">
                <div class="login-card">
                    <h1 class="font-20 font-weight-bold">Solicitação para tornar-se um parceiro.</h1>

                    <form method="Post" action="/become-instructor" class="mt-35">
                        <?php echo e(csrf_field()); ?>


                        <div class="form-group">
                  
                      
                        </div>

                        <div class="form-group">
                            <label class="js-instructor-label font-weight-500 text-dark-blue <?php echo e(!$isInstructorRole ? 'd-none' : ''); ?>"><?php echo e(trans('update.instructor_select_role')); ?></label>
                            <label class="js-organization-label font-weight-500 text-dark-blue <?php echo e(!$isOrganizationRole ? 'd-none' : ''); ?>"><?php echo e(trans('update.organization_select_role')); ?></label>

                            <select name="role" class="form-control <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>  is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option selected disabled><?php echo e(trans('update.select_role')); ?></option>

                                <option value="<?php echo e(\App\Models\Role::$teacher); ?>" <?php echo e($isInstructorRole ? 'selected' : ''); ?>><?php echo e(trans('panel.teacher')); ?></option>
                                <option value="<?php echo e(\App\Models\Role::$organization); ?>" <?php echo e($isOrganizationRole ? 'selected' : ''); ?>><?php echo e(trans('home.organization')); ?></option>
                            </select>
                            <?php $__errorArgs = ['role'];
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

                        <div class="form-group">
                            <label class="font-weight-500 text-dark-blue">Nº CNPJ</label>
                            <input type="text" name="cnpj_id" value="<?php echo e((!empty($user)) ? $user->cnpj_id : old('cnpj_id')); ?>" class="form-control <?php $__errorArgs = ['cnpj_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>  is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder=""/>
                            <?php $__errorArgs = ['cnpj_id'];
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

                        <div class="form-group">
                            <label class="js-instructor-label font-weight-500 text-dark-blue <?php echo e(!$isInstructorRole ? 'd-none' : ''); ?>"><?php echo e(trans('update.instructor_certificate_and_documents')); ?></label>
                            <label class="js-organization-label font-weight-500 text-dark-blue <?php echo e(!$isOrganizationRole ? 'd-none' : ''); ?>"><?php echo e(trans('update.organization_certificate_and_documents')); ?></label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="input-group-text panel-file-manager" data-input="certificate" data-preview="holder">
                                        <i data-feather="arrow-up" width="18" height="18" class="text-white"></i>
                                    </button>
                                </div>
                                <input type="text" name="certificate" id="certificate" value="<?php echo e((!empty($user)) ? $user->certificate : old('certificate')); ?>" class="form-control "/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="js-instructor-label font-weight-500 text-dark-blue <?php echo e(!$isInstructorRole ? 'd-none' : ''); ?>"><?php echo e(trans('update.instructor_select_account_type')); ?></label>
                            <label class="js-organization-label font-weight-500 text-dark-blue <?php echo e(!$isOrganizationRole ? 'd-none' : ''); ?>"><?php echo e(trans('update.organization_select_account_type')); ?></label>
                            <select name="account_type" class="form-control <?php $__errorArgs = ['account_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>  is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option selected disabled><?php echo e(trans('financial.select_account_type')); ?></option>

                                <?php if(!empty(getOfflineBanksTitle()) and count(getOfflineBanksTitle())): ?>
                                    <?php $__currentLoopData = getOfflineBanksTitle(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($accountType); ?>" <?php if(!empty($user) and $user->account_type == $accountType): ?> selected="selected" <?php endif; ?>><?php echo e($accountType); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                            <?php $__errorArgs = ['account_type'];
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



                        <div class="form-group">
                            <label class="js-instructor-label font-weight-500 text-dark-blue <?php echo e(!$isInstructorRole ? 'd-none' : ''); ?>"><?php echo e(trans('update.instructor_account_id')); ?></label>
                            <label class="js-organization-label font-weight-500 text-dark-blue <?php echo e(!$isOrganizationRole ? 'd-none' : ''); ?>"><?php echo e(trans('update.organization_account_id')); ?></label>
                            <input type="text" name="account_id" value="<?php echo e((!empty($user)) ? $user->account_id : old('account_id')); ?>" class="form-control <?php $__errorArgs = ['account_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>  is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder=""/>
                            <?php $__errorArgs = ['account_id'];
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

                        <div class="form-group">
                            <label class="js-instructor-label font-weight-500 text-dark-blue <?php echo e(!$isInstructorRole ? 'd-none' : ''); ?>"><?php echo e(trans('update.instructor_identity_scan')); ?></label>
                            <label class="js-organization-label font-weight-500 text-dark-blue <?php echo e(!$isOrganizationRole ? 'd-none' : ''); ?>"><?php echo e(trans('update.organization_identity_scan')); ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="input-group-text panel-file-manager" data-input="identity_scan" data-preview="holder">
                                        <i data-feather="arrow-up" width="18" height="18" class="text-white"></i>
                                    </button>
                                </div>
                                <input type="text" name="identity_scan" id="identity_scan" value="<?php echo e((!empty($user)) ? $user->identity_scan : old('identity_scan')); ?>" class="form-control <?php $__errorArgs = ['identity_scan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>  is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"/>
                                <?php $__errorArgs = ['identity_scan'];
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

                        <div class="form-group">
                            <label class="js-instructor-label font-weight-500 text-dark-blue <?php echo e(!$isInstructorRole ? 'd-none' : ''); ?>"><?php echo e(trans('update.instructor_extra_information')); ?></label>
                            <label class="js-organization-label font-weight-500 text-dark-blue <?php echo e(!$isOrganizationRole ? 'd-none' : ''); ?>"><?php echo e(trans('update.organization_extra_information')); ?></label>
                            <textarea name="description" rows="6" class="form-control"><?php echo e(!empty($lastRequest) ? $lastRequest->description : old('description')); ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mt-20"><?php echo e((!empty(getRegistrationPackagesGeneralSettings('show_packages_during_registration')) and getRegistrationPackagesGeneralSettings('show_packages_during_registration')) ? trans('webinars.next') : trans('site.send_request')); ?></button>
                    </form>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts_bottom'); ?>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>

    <script src="/assets/default/js/parts/become_instructor.min.js"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make(getTemplate().'.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/lean0314/alllearn.com.br/public/resources/views/web/default/user/become_instructor/index.blade.php ENDPATH**/ ?>