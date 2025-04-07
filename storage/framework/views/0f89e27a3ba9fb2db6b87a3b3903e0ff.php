

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Edit User</h4>
        </div>
        <div class="card-body">
            <form action="<?php echo e(url('/users/' . $user->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $user->name)); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo e(old('email', $user->email)); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="user" <?php echo e($user->role == 'user' ? 'selected' : ''); ?>>User</option>
                        <option value="admin" <?php echo e($user->role == 'admin' ? 'selected' : ''); ?>>Admin</option>
                    </select>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ago-system\resources\views/users/edit.blade.php ENDPATH**/ ?>