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
        <?php echo $delimiter; ?><?php echo e($c->title); ?>

    </option>
    <?php if(count($children = $c->children) > 0): ?>
        <?php echo $__env->make('partials.tasks', [
            'tasks' => $children,
            'delimiter'  => ' - ' . $delimiter
        ], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>