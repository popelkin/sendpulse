<div class="login">
    <?php $__env->startSection('content'); ?>
        <?php if($errors): ?>
            <p class="alert alert-danger">
                <?php $__currentLoopData = $errors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($e); ?><br />
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </p>
        <?php endif; ?>
        <h1>Ошибка 404</h1>
        <p>К сожалению, запрашиваемой Вами страницы не существует на сайте.</p>
        <a href="/">&laquo; на главную</a>
    <?php $__env->stopSection(); ?>
</div>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>