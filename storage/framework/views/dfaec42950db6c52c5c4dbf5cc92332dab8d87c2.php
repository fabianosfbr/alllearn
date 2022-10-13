<?php $__env->startPush('styles_top'); ?>
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
    <link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
<?php $__env->stopPush(); ?>


<section class="mt-50">
    <div class="">
        <h2 class="section-title after-line"><?php echo e(trans('public.prerequisites')); ?> (<?php echo e(trans('public.optional')); ?>)</h2>
    </div>
    <div>
        <br>
        <p class="font-12 text-gray">- Aqui você deve incluir os pré requisitos necessários para que o aluno ingressar neste curso. Ex. Curso Excel Avançado, você pode definir como pré-requisito que o aluno tenha excel intermediário.</p>
        <p class="font-12 text-gray">- Só pode escolher como requsito necessário, os seus cursos e não de outros.</p>
        <br>
    </div>

    <button id="webinarAddPrerequisites" data-webinar-id="<?php echo e($webinar->id); ?>" type="button" class="btn btn-primary btn-sm mt-15"><?php echo e(trans('public.add_prerequisites')); ?></button>

    <div class="row mt-10">
        <div class="col-12">

            <div class="accordion-content-wrapper mt-15" id="prerequisitesAccordion" role="tablist" aria-multiselectable="true">
                <?php if(!empty($webinar->prerequisites) and count($webinar->prerequisites)): ?>
                    <ul class="draggable-lists" data-order-table="prerequisites">
                        <?php $__currentLoopData = $webinar->prerequisites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prerequisiteInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo $__env->make('web.default.panel.webinar.create_includes.accordions.prerequisites',['webinar' => $webinar,'prerequisite' => $prerequisiteInfo], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php else: ?>
                    <?php echo $__env->make(getTemplate() . '.includes.no-result',[
                        'file_name' => 'comment.png',
                        'title' => trans('public.prerequisites_no_result'),
                        'hint' => trans('public.prerequisites_no_result_hint'),
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<div id="newPrerequisiteForm" class="d-none">
    <?php echo $__env->make('web.default.panel.webinar.create_includes.accordions.prerequisites',['webinar' => $webinar], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>


<?php $__env->startPush('scripts_bottom'); ?>
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
    <script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>
<?php $__env->stopPush(); ?><?php /**PATH /home1/lean0314/alllearn.com.br/public/resources/views/web/default/panel/webinar/create_includes/step_5.blade.php ENDPATH**/ ?>