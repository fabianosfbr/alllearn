<?php $__env->startPush('styles_top'); ?>
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <section>
        <h2 class="section-title"><?php echo e(trans('financial.account_summary')); ?></h2>

        <div class="activities-container mt-25 p-20 p-lg-35">
            <div class="row">
                <div class="col-4 d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/img/activity/36.svg" width="64" height="64" alt="">
                        <strong class="font-30 text-dark-blue font-weight-bold mt-5"><?php echo e($accountCharge ? addCurrencyToPrice($accountCharge) : 0); ?></strong>
                        <span class="font-16 text-gray font-weight-500"><?php echo e(trans('financial.account_charge')); ?></span>
                    </div>
                </div>

                <div class="col-4 d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/img/activity/37.svg" width="64" height="64" alt="">
                        <strong class="font-30 text-dark-blue font-weight-bold mt-5"><?php echo e($readyPayout ? addCurrencyToPrice($readyPayout) : 0); ?></strong>
                        <span class="font-16 text-gray font-weight-500"><?php echo e(trans('financial.ready_to_payout')); ?></span>
                    </div>
                </div>

                <div class="col-4 d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/img/activity/38.svg" width="64" height="64" alt="">
                        <strong class="font-30 text-dark-blue font-weight-bold mt-5"><?php echo e($totalIncome ? addCurrencyToPrice($totalIncome) : 0); ?></strong>
                        <span class="font-16 text-gray font-weight-500"><?php echo e(trans('financial.total_income')); ?></span>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <?php if(\Session::has('msg')): ?>
        <div class="alert alert-warning">
            <ul>
                <li><?php echo \Session::get('msg'); ?></li>
            </ul>
        </div>
    <?php endif; ?>

    <?php
        $showOfflineFields = false;
        if ($errors->has('date') or $errors->has('referral_code') or $errors->has('account') or !empty($editOfflinePayment)) {
            $showOfflineFields = true;
        }
    ?>

    <section class="mt-30">
        <h2 class="section-title"><?php echo e(trans('financial.select_the_payment_gateway')); ?></h2>

        <form action="/panel/financial/<?php echo e(!empty($editOfflinePayment) ? 'offline-payments/'. $editOfflinePayment->id .'/update' : 'charge'); ?>" method="post" enctype="multipart/form-data" class="mt-25">
            <?php echo e(csrf_field()); ?>


            <?php if($errors->has('gateway')): ?>
                <div class="text-danger mb-3">É obrigatório a escolha de um meio de pagamento</div>
            <?php endif; ?>

            <div class="row">
                <?php $__currentLoopData = $paymentChannels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentChannel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-6 col-lg-3 mb-40 charge-account-radio">
                        <input type="radio" class="online-gateway" name="gateway" id="<?php echo e($paymentChannel->class_name); ?>" <?php if(old('gateway') == $paymentChannel->class_name): ?> checked <?php endif; ?> value="<?php echo e($paymentChannel->class_name); ?>">
                        <label for="<?php echo e($paymentChannel->class_name); ?>" class="rounded-sm p-20 p-lg-45 d-flex flex-column align-items-center justify-content-center">
                            <img src="<?php echo e($paymentChannel->image); ?>" width="120" height="60" alt="">
                            <p class="mt-30 font-14 font-weight-500 text-dark-blue"><?php echo e(trans('financial.pay_via')); ?>

                                <span class="font-weight-bold"><?php echo e($paymentChannel->title); ?></span>
                            </p>
                        </label>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div class="col-6 col-lg-3 mb-40 charge-account-radio">
                    <input type="radio" name="gateway" id="offline" value="offline" <?php if(old('gateway') == 'offline' or !empty($editOfflinePayment)): ?> checked <?php endif; ?>>
                    <label for="offline" class="rounded-sm p-20 p-lg-45 d-flex flex-column align-items-center justify-content-center">
                        <img src="/assets/default/img/activity/pay.svg" width="120" height="60" alt="">
                        <p class="mt-30 font-14 font-weight-500 text-dark-blue"><?php echo e(trans('financial.pay_via')); ?>

                            <span class="font-weight-bold"><?php echo e(trans('financial.offline')); ?></span>
                        </p>
                    </label>
                </div>
            </div>

            <div class="">
                <h3 class="section-title mb-10">Inserir créditos em sua Conta All Learn</h3>           
                 <p class="font-12 text-gray mb-20">Os créditos podem ser usados para comprar cursos ou qualquer outro produto educacional</p>

                <div class="row">
                    <div class="col-12 col-lg-3 mb-25 mb-lg-0">
                        <label class="font-weight-500 font-14 text-dark-blue d-block" data-bs-toggle="tooltip" data-bs-placement="right" title="Informe o valor a ser depositado">
                            <?php echo e(trans('panel.amount')); ?> <i class="fa fa-info-circle"></i> 
                        </label>
                        
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-white font-16">
                                    
                                    <?php echo e($currency); ?>

                                </span>
                            </div>
                            <input type="number" name="amount" class="form-control <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(!empty($editOfflinePayment) ? $editOfflinePayment->amount : old('amount')); ?>"
                                   placeholder="<?php echo e(trans('panel.number_only')); ?>"/>
                            <div class="invalid-feedback"><?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 mb-25 mb-lg-0 js-offline-payment-input " style="<?php echo e((!$showOfflineFields) ? 'display:none' : ''); ?>">
                        <div class="form-group">
                            <label class="input-label"><?php echo e(trans('financial.account')); ?></label>
                            <select name="account" class="form-control <?php $__errorArgs = ['account'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option selected disabled><?php echo e(trans('financial.select_the_account')); ?></option>
                                <?php if(!empty(getOfflineBanksTitle()) and count(getOfflineBanksTitle())): ?> {
                                <?php $__currentLoopData = getOfflineBanksTitle(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($accountType); ?>" <?php if(!empty($editOfflinePayment) and $editOfflinePayment->bank == $accountType): ?> selected <?php endif; ?>><?php echo e($accountType); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>

                            <?php $__errorArgs = ['account'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"> <?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 mb-25 mb-lg-0 js-offline-payment-input " style="<?php echo e((!$showOfflineFields) ? 'display:none' : ''); ?>">
                        <div class="form-group">
                            <label for="referralCode" class="input-label"><?php echo e(trans('financial.referral_code')); ?></label>
                            <input type="text" name="referral_code" id="referralCode" value="<?php echo e(!empty($editOfflinePayment) ? $editOfflinePayment->reference_number : old('referral_code')); ?>" class="form-control <?php $__errorArgs = ['referral_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"/>
                            <?php $__errorArgs = ['referral_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"> <?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 mb-25 mb-lg-0 js-offline-payment-input " style="<?php echo e((!$showOfflineFields) ? 'display:none' : ''); ?>">
                        <div class="form-group">
                            <label class="input-label"><?php echo e(trans('public.date_time')); ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="dateRangeLabel">
                                        <i data-feather="calendar" width="18" height="18" class="text-white"></i>
                                    </span>
                                </div>
                                <input type="text" name="date" value="<?php echo e(!empty($editOfflinePayment) ? dateTimeFormat($editOfflinePayment->pay_date, 'Y-m-d H:i', false) : old('date')); ?>" class="form-control datetimepicker <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       aria-describedby="dateRangeLabel"/>
                                <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"> <?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 mb-25 mb-lg-0 js-offline-payment-input " style="<?php echo e((!$showOfflineFields) ? 'display:none' : ''); ?>">
                        <div class="form-group">
                            <label class="input-label">Anexe o comprovante da transferência</label>

                            <label for="attachmentFile" id="attachmentFileLabel" class="custom-upload-input-group">
                                <span class="custom-upload-icon text-white">
                                    <i data-feather="upload" width="18" height="18" class="text-white"></i>
                                </span>
                                <div class="custom-upload-input"></div>
                            </label>

                            <input type="file" name="attachment" id="attachmentFile"
                                   class="form-control h-auto invisible-file-input <?php $__errorArgs = ['attachment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value=""/>
                            <?php $__errorArgs = ['attachment'];
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

                    <div class="col-12 col-lg-3">
                        <div class="mt-30">
                            <button type="button" id="submitChargeAccountForm" class="btn btn-primary btn-sm"><?php echo e(trans('public.pay')); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <section class="mt-40">
        <h2 class="section-title"><?php echo e(trans('financial.bank_accounts_information')); ?></h2>

        <div class="row mt-25">
            <?php if(!empty($siteBankAccounts)): ?>
                <?php $__currentLoopData = $siteBankAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $siteBankAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-12 col-lg-4 mb-30 mb-lg-0">
                        <div class="py-25 px-20 rounded-sm panel-shadow d-flex flex-column align-items-center justify-content-center">
                            <img src="<?php echo e($siteBankAccount['image']); ?>" width="120" height="60" alt="">

                            <div class="mt-15 mt-30 w-100">

                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="font-14 font-weight-500 text-secondary"><?php echo e(trans('public.name')); ?>:</span>
                                    <span class="font-14 font-weight-500 text-gray"><?php echo e($siteBankAccount['title']); ?></span>
                                </div>



                                <div class="d-flex align-items-center justify-content-between mt-10">
                                    <span class="font-14 font-weight-500 text-secondary"><?php echo e(trans('financial.account_id')); ?>:</span>
                                    <span class="font-14 font-weight-500 text-gray"><?php echo e($siteBankAccount['account_id']); ?></span>
                                </div>


                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </section>

    <?php if($offlinePayments->count() > 0): ?>
        <section class="mt-40">
            <h2 class="section-title"><?php echo e(trans('financial.offline_transactions_history')); ?></h2>

            <div class="panel-section-card py-20 px-25 mt-20">
                <div class="row">
                    <div class="col-12 ">
                        <div class="table-responsive">
                            <table class="table text-center custom-table">
                                <thead>
                                <tr>
                                    <th><?php echo e(trans('financial.bank')); ?></th>
                                    <th><?php echo e(trans('financial.referral_code')); ?></th>
                                    <th class="text-center"><?php echo e(trans('panel.amount')); ?> (<?php echo e($currency); ?>)</th>
                                    <th class="text-center"><?php echo e(trans('update.attachment')); ?></th>
                                    <th class="text-center"><?php echo e(trans('public.status')); ?></th>
                                    <th class="text-right"><?php echo e(trans('public.controls')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $offlinePayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offlinePayment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="text-left">
                                            <div class="d-flex flex-column">
                                                <span class="font-weight-500 text-dark-blue"><?php echo e($offlinePayment->bank); ?></span>
                                                <span class="font-12 text-gray"><?php echo e($offlinePayment->pay_date); ?></span>
                                            </div>
                                        </td>
                                        <td class="text-left align-middle">
                                            <span><?php echo e($offlinePayment->reference_number); ?></span>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span class="font-16 font-weight-bold text-primary"><?php echo e($offlinePayment->amount); ?></span>
                                        </td>

                                        <td class="text-center align-middle">
                                            <?php if(!empty($offlinePayment->attachment)): ?>
                                                <a href="<?php echo e($offlinePayment->getAttachmentPath()); ?>" target="_blank" class="text-primary"><?php echo e(trans('public.view')); ?></a>
                                            <?php else: ?>
                                                ---
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-center align-middle">
                                            <?php switch($offlinePayment->status):
                                                case (\App\Models\OfflinePayment::$waiting): ?>
                                                <span class="text-warning"><?php echo e(trans('public.waiting')); ?></span>
                                                <?php break; ?>
                                                <?php case (\App\Models\OfflinePayment::$approved): ?>
                                                <span class="text-primary"><?php echo e(trans('financial.approved')); ?></span>
                                                <?php break; ?>
                                                <?php case (\App\Models\OfflinePayment::$reject): ?>
                                                <span class="text-danger"><?php echo e(trans('public.rejected')); ?></span>
                                                <?php break; ?>
                                            <?php endswitch; ?>
                                        </td>
                                        <td class="text-right align-middle">
                                            <?php if($offlinePayment->status != 'approved'): ?>
                                                <div class="btn-group dropdown table-actions">
                                                    <button type="button" class="btn-transparent dropdown-toggle"
                                                            data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                        <i data-feather="more-vertical" height="20"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a href="/panel/financial/offline-payments/<?php echo e($offlinePayment->id); ?>/edit"
                                                           class="webinar-actions d-block mt-10"><?php echo e(trans('public.edit')); ?></a>
                                                        <a href="/panel/financial/offline-payments/<?php echo e($offlinePayment->id); ?>/delete" data-item-id="1"
                                                           class="webinar-actions d-block mt-10 delete-action"><?php echo e(trans('public.delete')); ?></a>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </section>

    <?php else: ?>

        <?php echo $__env->make(getTemplate() . '.includes.no-result',[
            'file_name' => 'offline.png',
            'title' => trans('financial.offline_no_result'),
            'hint' => nl2br(trans('financial.offline_no_result_hint')),
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts_bottom'); ?>
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>

    <script src="/assets/default/js/panel/financial/account.min.js"></script>

    <script>
        (function ($) {
            "use strict";

            <?php if(session()->has('sweetalert')): ?>
            Swal.fire({
                icon: "<?php echo e(session()->get('sweetalert')['status'] ?? 'success'); ?>",
                html: '<h3 class="font-20 text-center text-dark-blue py-25"><?php echo e(session()->get('sweetalert')['msg'] ?? ''); ?></h3>',
                showConfirmButton: false,
                width: '25rem',
            });
            <?php endif; ?>
        })(jQuery)
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make(getTemplate() .'.panel.layouts.panel_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/lean0314/alllearn.com.br/public/resources/views/web/default/panel/financial/account.blade.php ENDPATH**/ ?>