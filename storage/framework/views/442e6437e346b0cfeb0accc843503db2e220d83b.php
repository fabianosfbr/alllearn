<?php $__env->startSection('content'); ?>
    <section class="section">
        <div class="section-header">
            <h1>Solicitações de retiradas</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/admin/"><?php echo e(trans('admin/main.dashboard')); ?></a>
                </div>
                <div class="breadcrumb-item"><?php echo e(trans('admin/main.payouts')); ?></div>
            </div>
        </div>


        <div class="section-body">

            <section class="card">
                <div class="card-body">
                    <form method="get" class="mb-0">
                        <input type="hidden" name="payout" value="<?php echo e(request()->get('payout')); ?>">

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label"><?php echo e(trans('admin/main.search')); ?></label>
                                    <input type="text" class="form-control text-center" name="search" value="<?php echo e(request()->get('search')); ?>">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label"><?php echo e(trans('admin/main.start_date')); ?></label>
                                    <div class="input-group">
                                        <input type="date" id="fsdate" class="text-center form-control" name="from" value="<?php echo e(request()->get('from')); ?>" placeholder="Start Date">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label"><?php echo e(trans('admin/main.end_date')); ?></label>
                                    <div class="input-group">
                                        <input type="date" id="lsdate" class="text-center form-control" name="to" value="<?php echo e(request()->get('to')); ?>" placeholder="End Date">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label"><?php echo e(trans('admin/main.role')); ?></label>
                                    <select name="role_id" data-plugin-selectTwo class="form-control populate">
                                        <option value=""><?php echo e(trans('admin/main.all_roles')); ?></option>
                                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($role->id); ?>" <?php if($role->id == request()->get('role_id')): ?> selected <?php endif; ?>><?php echo e($role->caption); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label"><?php echo e(trans('admin/main.user')); ?></label>
                                    <select name="user_ids[]" multiple="multiple" class="form-control search-user-select2"
                                            data-placeholder="Procurar usuário">

                                        <?php if(!empty($users) and $users->count() > 0): ?>
                                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user_filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($user_filter->id); ?>" selected><?php echo e($user_filter->full_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label"><?php echo e(trans('admin/main.bank')); ?></label>
                                    <select name="account_type" data-plugin-selectTwo class="form-control populate">
                                        <option value=""><?php echo e(trans('admin/main.all_banks')); ?></option>
                                        <?php if(!empty(getOfflineBanksTitle()) and count(getOfflineBanksTitle())): ?> {
                                        <?php $__currentLoopData = getOfflineBanksTitle(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($accountType); ?>" <?php if(request()->get('account_type') == $accountType): ?> selected <?php endif; ?>><?php echo e($accountType); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label"><?php echo e(trans('admin/main.filters')); ?></label>
                                    <select name="sort" data-plugin-selectTwo class="form-control populate">
                                        <option value="">Selecione um filtro</option>
                                        <option value="amount_asc" <?php if(request()->get('sort') == 'amount_asc'): ?> selected <?php endif; ?>>Valor ascentende</option>
                                        <option value="amount_desc" <?php if(request()->get('sort') == 'amount_desc'): ?> selected <?php endif; ?>>Valor descentente</option>
                                        <option value="created_at_asc" <?php if(request()->get('sort') == 'created_at_asc'): ?> selected <?php endif; ?>>Data ascendente</option>
                                        <option value="created_at_desc" <?php if(request()->get('sort') == 'created_at_desc'): ?> selected <?php endif; ?>>Data descendente</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label mb-4"> </label>
                                    <input type="submit" class="text-center btn btn-primary w-100" value="<?php echo e(trans('admin/main.show_results')); ?>">
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </section>

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin_payouts_export_excel')): ?>
                                <a href="/admin/financial/payouts/excel?<?php echo e(http_build_query(request()->all())); ?>" class="btn btn-primary"><?php echo e(trans('admin/main.export_xls')); ?></a>
                            <?php endif; ?>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th>Requisitante</th>
                                        <th><?php echo e(trans('admin/main.role')); ?></th>
                                        <th><?php echo e(trans('admin/main.payout_amount')); ?></th>
                                      
                                        <th>Conta para depósito</th>
                                    
                                        <th><?php echo e(trans('admin/main.phone')); ?></th>
                                        <th width="180px">Último pagamento</th>

                                        <?php if(request()->get('payout') == 'history'): ?>
                                            <th><?php echo e(trans('admin/main.status')); ?></th>
                                        <?php endif; ?>

                                        <?php if(request()->get('payout') == 'requests'): ?>
                                            <th width="150px"><?php echo e(trans('admin/main.actions')); ?></th>
                                        <?php endif; ?>
                                    </tr>

                                    <?php if($payouts->count() > 0): ?>
                                        <?php $__currentLoopData = $payouts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payout): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <tr>
                                                <td class="text-left">
                                                    <span class="d-block"><?php echo e($payout->user->full_name); ?></span>
                                                </td>

                                                <td><?php echo e($payout->user->role->caption); ?></td>

                                                <td><?php echo e(addCurrencyToPrice($payout->amount)); ?></td>

                                          

                                                <td><?php echo e($payout->user->account_id); ?></td>

                                        

                                                <td><?php echo e($payout->user->mobile); ?></td>

                                                <td><?php echo e(dateTimeFormat($payout->created_at, 'Y/m/j-H:i')); ?></td>

                                                <?php if(request()->get('payout') == 'history'): ?>
                                                    <td>
                                                        <span class="<?php echo e(($payout->status == 'done') ? 'text-success' : 'text-danger'); ?>"><?php echo e(trans('public.'.$payout->status)); ?></span>
                                                    </td>
                                                <?php endif; ?>

                                                <?php if(request()->get('payout') == 'requests'): ?>
                                                    <td width="150px">
                                                        <div class="">
                                                            <?php if($payout->status === \App\Models\Payout::$waiting): ?>

                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin_payouts_payout')): ?>
                                                                    <?php echo $__env->make('admin.includes.delete_button',[
                                                                            'url' => '/admin/financial/payouts/'. $payout->id .'/payout',
                                                                            'tooltip' => trans('admin/main.payout'),
                                                                            'btnIcon' => 'fa-credit-card'
                                                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                <?php endif; ?>

                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin_payouts_reject')): ?>
                                                                    <?php echo $__env->make('admin.includes.delete_button',[
                                                                            'url' => '/admin/financial/payouts/'. $payout->id .'/reject',
                                                                            'tooltip' => trans('public.reject'),
                                                                            'btnIcon' => 'fa-times-circle',
                                                                            'btnClass' => 'ml-2',
                                                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>

                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            <?php echo e($payouts->appends(request()->input())->links()); ?>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="card">
        <div class="card-body">
            <div class="section-title ml-0 mt-0 mb-3"><h5><?php echo e(trans('admin/main.hints')); ?></h5></div>
            <div class="row">
                <div class="col-md-6">
                    <div class="media-body">
                        <div class="text-primary mt-0 mb-1 font-weight-bold"><?php echo e(trans('admin/main.payout_list_hint_title_1')); ?></div>
                        <div class=" text-small font-600-bold"><?php echo e(trans('admin/main.payout_list_hint_description_1')); ?></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="media-body">
                        <div class="text-primary mt-0 mb-1 font-weight-bold"><?php echo e(trans('admin/main.payout_list_hint_title_2')); ?></div>
                        <div class=" text-small font-600-bold"><?php echo e(trans('admin/main.payout_list_hint_description_2')); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/lean0314/alllearn.com.br/public/resources/views/admin/financial/payout/lists.blade.php ENDPATH**/ ?>