<!-- @delete  -->

<?php if($errors): ?>
    <p class="alert alert-danger">
        <?php $__currentLoopData = $errors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo e($e); ?><br />
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </p>
<?php endif; ?>

<label for="">Дата</label>
<input type="text" class="form-control" name="date" placeholder="Дата" value="<?php echo e($task->date ?? date('Y-m-d H:i:s')); ?>"   />
<br />

<label for="">Заголовок</label>
<input type="text" class="form-control" name="title" placeholder="Заголовок" value="<?php echo e($task->title ?? ''); ?>"  />
<br />

<label for="">Тело</label>
<textarea class="form-control" name="body" placeholder="Тело" rows="5" ><?php echo e($task->body ?? ''); ?></textarea>
<br />

<label for="">Выполнена</label>
<select class="form-control" name="done">
    <option value="0" <?php if(isset($task->id) && !$task->done): ?> selected <?php endif; ?>>Нет</option>
    <option value="1" <?php if(isset($task->id) && $task->done): ?> selected <?php endif; ?>>Да</option>
</select>
<br />

<label for="">Родительская задача</label>
<select class="form-control" name="parent_id">
    <option value="0">-- без родительской задачи --</option>
    <?php echo $__env->make('partials.tasks', [
        'categories' => $categories
    ], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</select>

<hr />

<input class="btn btn-success" type="submit" value="Сохранить" />