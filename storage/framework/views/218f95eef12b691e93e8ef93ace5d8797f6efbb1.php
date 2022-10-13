
<?php if($bundle->description): ?>
    <div class="mt-20">
        <h2 class="section-title after-line"><?php echo e(trans('update.bundle_description')); ?></h2>
        <div class="mt-15 course-description">
            <?php echo clean($bundle->description); ?>

        </div>
    </div>
<?php endif; ?>




<?php if(!empty($bundle->faqs) and $bundle->faqs->count() > 0): ?>
    <div class="mt-20">
        <h2 class="section-title after-line"><?php echo e(trans('public.faq')); ?></h2>

        <div class="accordion-content-wrapper mt-15" id="accordion" role="tablist" aria-multiselectable="true">
            <?php $__currentLoopData = $bundle->faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="accordion-row rounded-sm shadow-lg border mt-20 py-20 px-35">
                    <div class="font-weight-bold font-14 text-secondary" role="tab" id="faq_<?php echo e($faq->id); ?>">
                        <div href="#collapseFaq<?php echo e($faq->id); ?>" aria-controls="collapseFaq<?php echo e($faq->id); ?>" class="d-flex align-items-center justify-content-between" role="button" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
                            <span><?php echo e(clean($faq->title,'title')); ?>?</span>
                            <i class="collapse-chevron-icon" data-feather="chevron-down" width="25" class="text-gray"></i>
                        </div>
                    </div>
                    <div id="collapseFaq<?php echo e($faq->id); ?>" aria-labelledby="faq_<?php echo e($faq->id); ?>" class=" collapse" role="tabpanel">
                        <div class="panel-collapse text-gray">
                            <?php echo e(clean($faq->answer,'answer')); ?>

                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php endif; ?>



<?php echo $__env->make('web.default.includes.comments',[
        'comments' => $bundle->comments,
        'inputName' => 'bundle_id',
        'inputValue' => $bundle->id
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php /**PATH /home1/lean0314/alllearn.com.br/public/resources/views/web/default/bundle/tabs/information.blade.php ENDPATH**/ ?>