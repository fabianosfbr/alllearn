<?php $__env->startPush('styles_top'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <section class="cart-banner position-relative text-center">
        <h1 class="font-30 text-white font-weight-bold"><?php echo e(trans('cart.checkout')); ?></h1>
        <span class="payment-hint font-20 text-white d-block"><?php echo e($currency . $total . ' ' .  trans('cart.for_items',['count' => $count])); ?></span>
    </section>

    <section class="container mt-45">
        <h2 class="section-title"><?php echo e(trans('financial.select_a_payment_gateway')); ?></h2>

        <form action="/payments/payment-request" method="post" class=" mt-25">
            <?php echo e(csrf_field()); ?>

            <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">

            <div class="row">
                <?php if(!empty($paymentChannels)): ?>
                    <?php $__currentLoopData = $paymentChannels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentChannel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-6 col-lg-4 mb-40 charge-account-radio">
                            <input type="radio" name="gateway" id="<?php echo e($paymentChannel->title); ?>" data-class="<?php echo e($paymentChannel->class_name); ?>" value="<?php echo e($paymentChannel->id); ?>">
                            <label for="<?php echo e($paymentChannel->title); ?>" class="rounded-sm p-20 p-lg-45 d-flex flex-column align-items-center justify-content-center">
                                <img src="<?php echo e($paymentChannel->image); ?>" width="120" height="60" alt="">

                                <p class="mt-30 mt-lg-50 font-weight-500 text-dark-blue">
                                    <?php echo e(trans('financial.pay_via')); ?>

                                    <span class="font-weight-bold font-14"><?php echo e($paymentChannel->title); ?></span>
                                </p>
                            </label>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

                <div class="col-6 col-lg-4 mb-40 charge-account-radio">
                    <input type="radio" <?php if(empty($userCharge) or ($total > $userCharge)): ?> disabled <?php endif; ?> name="gateway" id="offline" value="credit">
                    <label for="offline" class="rounded-sm p-20 p-lg-45 d-flex flex-column align-items-center justify-content-center">
                        <img src="/assets/default/img/activity/pay.svg" width="120" height="60" alt="">

                        <p class="mt-30 mt-lg-50 font-weight-500 text-dark-blue">
                            Pagar com
                            <span class="font-weight-bold">Saldo All Learn</span>
                        </p>

                        <span class="mt-5"><?php echo e(addCurrencyToPrice($userCharge)); ?></span>
                    </label>
                </div>
            </div>


            <div class="d-flex align-items-center justify-content-between mt-45">
                <span class="font-16 font-weight-500 text-gray"><?php echo e(trans('financial.total_amount')); ?> <?php echo e(addCurrencyToPrice($total)); ?></span>
                <button type="button" id="paymentSubmit" disabled class="btn btn-sm btn-primary"><?php echo e(trans('public.start_payment')); ?></button>
            </div>
        </form>

        <?php if(!empty($razorpay) and $razorpay): ?>
            <form action="/payments/verify/Razorpay" method="get">
                <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">

                <script src="https://checkout.razorpay.com/v1/checkout.js"
                        data-key="<?php echo e(env('RAZORPAY_API_KEY')); ?>"
                        data-amount="<?php echo e((int)($order->total_amount * 100)); ?>"
                        data-buttontext="product_price"
                        data-description="Rozerpay"
                        data-currency="<?php echo e(currency()); ?>"
                        data-image="<?php echo e($generalSettings['logo']); ?>"
                        data-prefill.name="<?php echo e($order->user->full_name); ?>"
                        data-prefill.email="<?php echo e($order->user->email); ?>"
                        data-theme.color="#43d477">
                </script>
            </form>
        <?php endif; ?>
    </section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts_bottom'); ?>
    <script src="/assets/default/js/parts/payment.min.js"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make(getTemplate().'.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/lean0314/alllearn.com.br/public/resources/views/web/default/cart/payment.blade.php ENDPATH**/ ?>