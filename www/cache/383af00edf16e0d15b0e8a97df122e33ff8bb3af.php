
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('nav', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <p>
        <br />
        <a class="btn btn-primary" href="/tasks/create/">+ Новая задача</a>
    </p>
    <?php if(count($tasks)): ?>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">
                        <a href="/tasks/?s=<?php echo e($sort == 'ASC' ? 'd' : 'a'); ?>">
                            Дата <i class="fas fa-sort-<?php echo e($sort == 'ASC' ? 'up' : 'down'); ?>"></i>
                        </a>
                    </th>
                    <th scope="col">Заголовок</th>
                    <th scope="col">Тело</th>
                    <th scope="col">Выполнена</th>
                    <th scope="col">Родительская задача</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr <?php if($task->done): ?> class="done" <?php endif; ?>>
                        <td><?php echo e($task->id); ?></td>
                        <td><?php echo e($task->date); ?></td>
                        <td><?php echo e($task->title); ?></td>
                        <td><?php echo e($task->body); ?></td>
                        <td><?php echo e($task->done ? 'Да' : 'Нет'); ?></td>
                        <td><?php echo e($task->parent_id ? '#' . "{$task->parent_id} ({$task->parent()->title})" : ''); ?></td>
                        <td>
                            <form method="post" onsubmit="return confirm('Удалить?');" action="/tasks/<?php echo e($task->id); ?>/" class="inline-block">
                                <input type="hidden" name="_method" value="delete" />
                                <a class="btn clear" href="/tasks/<?php echo e($task->id); ?>/edit/" title="Редактировать">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button type="submit" class="btn clear" title="Удалить">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                            <?php if(!$task->done): ?>
                                <form method="post" onsubmit="return confirm('Пометить как выполненную?');" action="/tasks/<?php echo e($task->id); ?>/" class="inline-block">
                                    <input type="hidden" name="_method" value="put" />
                                    <input type="hidden" name="done" value="1" />
                                    <button type="submit" class="btn clear" title="Пометить как выполненную">
                                        <i class="far fa-check-square"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
            </tbody>
        </table>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>