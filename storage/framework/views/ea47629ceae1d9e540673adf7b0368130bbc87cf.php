<?php $__env->startSection('content'); ?>
    <?php if($accountings->count() > 0): ?>
        <section>
            <h2 class="section-title"><?php echo e(trans('financial.financial_documents')); ?></h2>

            <div class="panel-section-card py-20 px-25 mt-20">
                <div class="row">
                    <div class="col-12 ">
                        <div class="table-responsive">
                            <table class="table text-center custom-table">
                                <thead>
                                <tr>
                                    <th><?php echo e(trans('public.title')); ?></th>
                                    <th><?php echo e(trans('public.description')); ?></th>
                                    <th class="text-center"><?php echo e(trans('panel.amount')); ?> (<?php echo e($currency); ?>)</th>
                                    <th class="text-center"><?php echo e(trans('public.creator')); ?></th>
                                    <th class="text-center"><?php echo e(trans('public.date')); ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php $__currentLoopData = $accountings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accounting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="text-left">
                                            <div class="d-flex flex-column">
                                            <span class="font-14 font-weight-500">
                                                <?php if(!empty($accounting->webinar_id) and !empty($accounting->webinar)): ?>
                                                    <?php echo e($accounting->webinar->title); ?>

                                                <?php elseif(!empty($accounting->meeting_time_id)): ?>
                                                    <?php echo e(trans('meeting.reservation_appointment')); ?>

                                                <?php elseif(!empty($accounting->subscribe_id) and !empty($accounting->subscribe)): ?>
                                                    <?php echo e($accounting->subscribe->title); ?>

                                                <?php elseif(!empty($accounting->promotion_id) and !empty($accounting->promotion)): ?>
                                                    <?php echo e($accounting->promotion->title); ?>

                                                <?php elseif(!empty($accounting->registration_package_id) and !empty($accounting->registrationPackage)): ?>
                                                    <?php echo e($accounting->registrationPackage->title); ?>

                                                <?php elseif($accounting->store_type == \App\Models\Accounting::$storeManual): ?>
                                                    <?php echo e(trans('financial.manual_document')); ?>

                                                <?php elseif($accounting->type == \App\Models\Accounting::$addiction and $accounting->type_account == \App\Models\Accounting::$asset): ?>
                                                    <?php echo e(trans('financial.charge_account')); ?>

                                                <?php elseif($accounting->type == \App\Models\Accounting::$deduction and $accounting->type_account == \App\Models\Accounting::$income): ?>
                                                    <?php echo e(trans('financial.payout')); ?>

                                                <?php else: ?>
                                                    ---
                                                <?php endif; ?>
                                            </span>

                                                <span class="font-12 text-gray">
                                                <?php if(!empty($accounting->webinar_id) and !empty($accounting->webinar)): ?>
                                                        <?php echo e($accounting->webinar->id); ?>

                                                    <?php elseif(!empty($accounting->meeting_time_id) and !empty($accounting->meetingTime)): ?>
                                                        <?php echo e($accounting->meetingTime->meeting->creator->full_name); ?>

                                                    <?php elseif(!empty($accounting->subscribe_id) and !empty($accounting->subscribe)): ?>
                                                        <?php echo e($accounting->subscribe->id); ?>

                                                    <?php elseif(!empty($accounting->promotion_id) and !empty($accounting->promotion)): ?>
                                                        <?php echo e($accounting->promotion->id); ?>

                                                    <?php elseif(!empty($accounting->registration_package_id) and !empty($accounting->registrationPackage)): ?>
                                                        <?php echo e($accounting->registrationPackage->id); ?>

                                                    <?php else: ?>
                                                        ---
                                                    <?php endif; ?>
                                            </span>
                                            </div>
                                        </td>
                                        <td class="text-left align-middle">
                                            <span class="font-weight-500 text-gray"><?php echo e($accounting->description); ?></span>
                                        </td>
                                        <td class="text-center align-middle">
                                            <?php switch($accounting->type):
                                                case (\App\Models\Accounting::$addiction): ?>
                                                <span class="font-16 font-weight-bold text-primary">+<?php echo e(handlePriceFormat($accounting->amount)); ?></span>
                                                <?php break; ?>;
                                                <?php case (\App\Models\Accounting::$deduction): ?>
                                                <span class="font-16 font-weight-bold text-danger">-<?php echo e(handlePriceFormat($accounting->amount)); ?></span>
                                                <?php break; ?>;
                                            <?php endswitch; ?>
                                        </td>
                                        <td class="text-center align-middle"><?php echo e(trans('public.'.$accounting->store_type)); ?></td>
                                        <td class="text-center align-middle">
                                            <span><?php echo e(dateTimeFormat($accounting->created_at, 'j M Y')); ?></span>
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
            'file_name' => 'financial.png',
            'title' => trans('financial.financial_summary_no_result'),
            'hint' => nl2br(trans('financial.financial_summary_no_result_hint')),
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    <div class="my-30">
        <?php echo e($accountings->appends(request()->input())->links('vendor.pagination.panel')); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(getTemplate() .'.panel.layouts.panel_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/lean0314/alllearn.com.br/public/resources/views/web/default/panel/financial/summary.blade.php ENDPATH**/ ?>