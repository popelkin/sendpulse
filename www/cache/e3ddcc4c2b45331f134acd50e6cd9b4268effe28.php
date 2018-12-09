<?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <option value="<?php echo e($c->id); ?>"
        <?php if(isset($task->id)): ?>
            <?php if($task->id == $c->id): ?>
                hidden
            <?php endif; ?>
            <?php if($task->parent_id == $c->id): ?>
                selected
            <?php endif; ?>
        <?php endif; ?>
    >
        <?php echo $delimiter; ?>#<?php echo e($c->id); ?> (<?php echo e($c->title); ?>)
    </option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>