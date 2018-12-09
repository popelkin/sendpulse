
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('nav', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <p>
        <br />
        <a class="btn btn-primary" href="/tasks/create/">+ Новая задача</a>
    </p>
    <form class="form-horizontal" method="post" action="/tasks/">
        <?php echo $__env->make('partials.form', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>