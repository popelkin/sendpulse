<div class="login">
    <?php $__env->startSection('content'); ?>
        <?php if($errors): ?>
            <p class="alert alert-danger">
                <?php $__currentLoopData = $errors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($e); ?><br />
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </p>
        <?php endif; ?>
        <!-- @delete  -->
        <div class="text-center">
            <form class="form-signin" method="post" action="/login/">
                <h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>
                <label for="inputEmail" class="sr-only">E-mail адрес</label>
                <input name="email" type="text" id="inputEmail" class="form-control" placeholder="E-mail адрес" autofocus>
                <label for="inputPassword" class="sr-only">Пароль</label>
                <input name="password" type="text" id="inputPassword" class="form-control" placeholder="Пароль" >
                <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
            </form>
        </div>
    <?php $__env->stopSection(); ?>
</div>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>