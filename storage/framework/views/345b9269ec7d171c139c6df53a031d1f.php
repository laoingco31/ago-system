<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><i class="fas fa-home"></i> Dashboard</h4>
                </div>

                <div class="card-body">
                    <?php if(session('status')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> <?php echo e(session('status')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <h5 class="mb-3"><i class="fas fa-clock"></i> Pending Entries</h5>

                    <?php if($pendingEntries->isEmpty()): ?>
                        <p class="text-muted text-center">No pending entries found.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped text-center align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Date Received</th>
                                        <th>Branch</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $pendingEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($entry->date_received); ?></td>
                                            <td><?php echo e($entry->branch); ?></td>
                                            <td><?php echo e($entry->description); ?></td>
                                            <td class="fw-bold"><?php echo e($entry->quantity); ?></td>
                                            <td>
                                                <a href="<?php echo e(url('/entries/' . $entry->id)); ?>" class="btn btn-sm btn-info shadow-sm">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
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
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ago-system\resources\views\home.blade.php ENDPATH**/ ?>