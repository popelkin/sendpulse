
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
                <h1 class="h3 mb-3 font-weight-normal">Вход</h1>
                <label for="inputEmail" class="sr-only">E-mail</label>
                <input name="email" type="text" value="<?php echo e($_POST['email'] ?? ''); ?>" id="inputEmail" class="form-control" placeholder="Валидный E-mail"  autofocus>
                <label for="inputPassword" class="sr-only">Пароль</label>
                <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Пароль не должен быть пустым">
                <input name="password_confirm" type="password" id="inputPasswordConfirm" class="form-control <?php if(!$_POST['signup']): ?> hidden <?php endif; ?>" placeholder="Повторите пароль">
                <label class="form-check-label mt-10 mb-10 display-block">
                    <input class="form-check-input" type="checkbox" name="signup" value="1" <?php if($_POST['signup']): ?> checked <?php endif; ?>> хочу зарегистрироваться
                </label>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
            </form>
        </div>
    <?php $__env->stopSection(); ?>
</div>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>