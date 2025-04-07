

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="<?php echo e(url('/entries/create')); ?>" class="btn btn-success shadow-sm">
            <i class="fas fa-plus-circle"></i> Add New Entry
        </a>
    </div>

    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-list"></i> All Entries</h5>
        </div>
        <div class="card-body">
            <?php if($entries->isEmpty()): ?>
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> No entries found.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover table-striped text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Date Received</th>
                                <th>Branch</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                                <th>Total</th>
                                <th>Date Release</th>
                                <th>Received By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(\Carbon\Carbon::parse($entry->date_received)->format('m-d-Y')); ?></td>
                                <td><?php echo e($entry->branch); ?></td>
                                <td><?php echo e($entry->description); ?></td>
                                <td><?php echo e($entry->quantity); ?></td>
                                <td class="text-success fw-bold">₱<?php echo e(number_format($entry->amount, 2)); ?></td>
                                <td class="text-danger fw-bold">₱<?php echo e(number_format($entry->total, 2)); ?></td>
                                <td>
                                    <?php if($entry->date_release): ?>
                                        <?php echo e(\Carbon\Carbon::parse($entry->date_release)->format('m-d-Y')); ?>

                                    <?php else: ?>
                                        <span class="badge bg-secondary">N/A</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($entry->received_by == "Pending"): ?>
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    <?php else: ?>
                                        <?php echo e($entry->received_by); ?>

                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo e(url('/entries/' . $entry->id . '/edit')); ?>" class="btn btn-sm btn-warning shadow-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(url('/entries/' . $entry->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger shadow-sm"
                                            onclick="return confirm('Are you sure you want to delete this entry?');">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ago-system\resources\views\entries\index.blade.php ENDPATH**/ ?>