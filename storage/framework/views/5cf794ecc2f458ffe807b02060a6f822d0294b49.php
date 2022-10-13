<div data-action="<?php echo e(!empty($quiz) ? '/admin/quizzes/'. $quiz->id .'/update' : '/admin/quizzes/store'); ?>" class="js-content-form quiz-form webinar-form">
    <?php echo e(csrf_field()); ?>

    <section>

        <div class="row">
            <div class="col-12 col-md-4">


                <div class="d-flex align-items-center justify-content-between">
                    <div class="">
                        <h2 class="section-title"><?php echo e(!empty($quiz) ? (trans('public.edit').' ('. $quiz->title .')') : trans('quiz.new_quiz')); ?></h2>
                        <p><?php echo e(trans('admin/main.instructor')); ?>: <?php echo e($creator->full_name); ?></p>
                    </div>
                </div>

                <?php if(!empty(getGeneralSettings('content_translate'))): ?>
                    <div class="form-group">
                        <label class="input-label"><?php echo e(trans('auth.language')); ?></label>
                        <select name="ajax[locale]" class="form-control <?php echo e(!empty($quiz) ? 'js-edit-content-locale' : ''); ?>">
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

                <?php if(empty($selectedWebinar)): ?>
                    <div class="form-group mt-3">
                        <label class="input-label"><?php echo e(trans('panel.webinar')); ?></label>
                        <select name="ajax[webinar_id]" class="custom-select">
                            <option <?php echo e(!empty($quiz) ? 'disabled' : 'selected disabled'); ?> value=""><?php echo e(trans('panel.choose_webinar')); ?></option>
                            <?php $__currentLoopData = $webinars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $webinar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($webinar->id); ?>" <?php echo e((!empty($quiz) and $quiz->webinar_id == $webinar->id) ? 'selected' : ''); ?>><?php echo e($webinar->title); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="ajax[webinar_id]" value="<?php echo e($selectedWebinar->id); ?>">
                <?php endif; ?>

                <?php if(!empty($chapter) or !empty($webinarChapterPages)): ?>
                    <input type="hidden" name="ajax[chapter_id]" value="<?php echo e(!empty($chapter) ? $chapter->id :''); ?>" class="chapter-input">
                <?php else: ?>
                    <div class="form-group mt-25">
                        <label class="input-label"><?php echo e(trans('public.chapter')); ?></label>

                        <select name="ajax[chapter_id]" class="js-ajax-chapter_id custom-select">
                            <option value=""><?php echo e(trans('public.no_chapter')); ?></option>

                            <?php if(!empty($chapters) and count($chapters)): ?>
                                <?php $__currentLoopData = $chapters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chapter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($chapter->id); ?>" <?php echo e((!empty($quiz) and $quiz->chapter_id == $chapter->id) ? 'selected' : ''); ?>><?php echo e($chapter->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label class="input-label"><?php echo e(trans('quiz.quiz_title')); ?></label>
                    <input type="text" value="<?php echo e(!empty($quiz) ? $quiz->title : old('title')); ?>" name="ajax[title]" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>  is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder=""/>
                    <?php $__errorArgs = ['title'];
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
                    <label class="input-label"><?php echo e(trans('public.time')); ?> <span class="braces">(<?php echo e(trans('public.minutes')); ?>)</span></label>
                    <input type="text" value="<?php echo e(!empty($quiz) ? $quiz->time : old('time')); ?>" name="ajax[time]" class="form-control <?php $__errorArgs = ['time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>  is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(trans('forms.empty_means_unlimited')); ?>"/>
                    <?php $__errorArgs = ['time'];
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
                    <label class="input-label"><?php echo e(trans('quiz.number_of_attemps')); ?></label>
                    <input type="text" name="ajax[attempt]" value="<?php echo e(!empty($quiz) ? $quiz->attempt : old('attempt')); ?>" class="form-control <?php $__errorArgs = ['attempt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>  is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(trans('forms.empty_means_unlimited')); ?>"/>
                    <?php $__errorArgs = ['attempt'];
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
                    <label class="input-label"><?php echo e(trans('quiz.pass_mark')); ?></label>
                    <input type="text" name="ajax[pass_mark]" value="<?php echo e(!empty($quiz) ? $quiz->pass_mark : old('pass_mark')); ?>" class="form-control <?php $__errorArgs = ['pass_mark'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>  is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder=""/>
                    <?php $__errorArgs = ['pass_mark'];
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

                <div class="form-group mt-4 d-flex align-items-center justify-content-between">
                    <label class="cursor-pointer" for="certificateSwitch"><?php echo e(trans('quiz.certificate_included')); ?></label>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="ajax[certificate]" class="custom-control-input" id="certificateSwitch" <?php echo e(!empty($quiz) && $quiz->certificate ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="certificateSwitch"></label>
                    </div>
                </div>

                <div class="form-group mt-4 d-flex align-items-center justify-content-between">
                    <label class="cursor-pointer" for="statusSwitch"><?php echo e(trans('quiz.active_quiz')); ?></label>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="ajax[status]" class="custom-control-input" id="statusSwitch" <?php echo e(!empty($quiz) && $quiz->status ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="statusSwitch"></label>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <?php if(!empty($quiz)): ?>
        <section class="mt-5">
            <div class="d-flex justify-content-between align-items-center pb-20">
                <h2 class="section-title after-line"><?php echo e(trans('public.questions')); ?></h2>
                <button id="add_multiple_question" type="button" class="btn btn-primary btn-sm ml-2 mt-3"><?php echo e(trans('quiz.add_multiple_choice')); ?></button>
                <button id="add_descriptive_question" type="button" class="btn btn-primary btn-sm ml-2 mt-3"><?php echo e(trans('quiz.add_descriptive')); ?></button>
            </div>
            <?php if($quizQuestions): ?>
                <?php $__currentLoopData = $quizQuestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="quiz-question-card d-flex align-items-center mt-4">
                        <div class="flex-grow-1">
                            <h4 class="question-title"><?php echo e($question->title); ?></h4>
                            <div class="font-12 mt-3 question-infos">
                                <span><?php echo e($question->type === App\Models\QuizzesQuestion::$multiple ? trans('quiz.multiple_choice') : trans('quiz.descriptive')); ?> | <?php echo e(trans('quiz.grade')); ?>: <?php echo e($question->grade); ?></span>
                            </div>
                        </div>

                        <div class="btn-group dropdown table-actions">
                            <button type="button" class="btn-transparent dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu text-left">
                                <button type="button" data-question-id="<?php echo e($question->id); ?>" class="edit_question btn btn-sm btn-transparent"><?php echo e(trans('public.edit')); ?></button>
                                <?php echo $__env->make('admin.includes.delete_button',['url' => '/admin/quizzes-questions/'. $question->id .'/delete', 'btnClass' => 'btn-sm btn-transparent' , 'btnText' => trans('public.delete')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </section>
    <?php endif; ?>

    <input type="hidden" name="ajax[is_webinar_page]" value="<?php if(!empty($inWebinarPage) and $inWebinarPage): ?> 1 <?php else: ?> 0 <?php endif; ?>">

    <div class="mt-20 mb-20">
        <button type="button" class="js-submit-quiz-form btn btn-sm btn-primary"><?php echo e(!empty($quiz) ? trans('public.save_change') : trans('public.create')); ?></button>

        <?php if(empty($quiz) and !empty($inWebinarPage)): ?>
            <button type="button" class="btn btn-sm btn-danger ml-10 cancel-accordion"><?php echo e(trans('public.close')); ?></button>
        <?php endif; ?>
    </div>
</div>

<?php if(!empty($quiz)): ?>
    <?php echo $__env->make('admin.quizzes.modals.multiple_question', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.quizzes.modals.descriptive_question', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php /**PATH /home1/lean0314/alllearn.com.br/public/resources/views/admin/quizzes/create_quiz_form.blade.php ENDPATH**/ ?>