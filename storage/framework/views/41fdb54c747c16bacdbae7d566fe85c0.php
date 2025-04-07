

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h2>Edit Entry</h2>

    <form action="<?php echo e(url('/entries/' . $entry->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-3">
            <label class="form-label">Date Release</label>
            <input type="date" name="date_release" class="form-control" 
                   value="<?php echo e($entry->date_release ? \Carbon\Carbon::parse($entry->date_release)->format('Y-m-d') : ''); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Received By</label>
            <input type="text" name="received_by" class="form-control" 
                   value="<?php echo e(old('received_by', $entry->received_by)); ?>" required>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Update Entry</button>
            <a href="<?php echo e(url('/entries')); ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ago-system\resources\views\entries\edit.blade.php ENDPATH**/ ?>