

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-green-50 via-white to-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-green-700/80 font-medium">Aether & Leaf.Co</p>
                <h1 class="text-3xl font-extrabold text-slate-900">My Complaints</h1>
                <p class="text-slate-600 mt-1">Senarai aduan yang anda buat.</p>
            </div>

            <a href="<?php echo e(url('/complaints')); ?>"
               class="rounded-xl bg-slate-900 text-white px-4 py-2 font-semibold hover:bg-black transition">
                Admin/Seller View
            </a>
        </div>

        <div class="mt-6 rounded-2xl bg-white border border-slate-100 shadow-sm p-5">
            <?php if($complaints->count() === 0): ?>
                <p class="text-slate-600">Tiada aduan lagi.</p>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php $__currentLoopData = $complaints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('complaints.show', $c->complaint_id)); ?>"
                           class="block rounded-2xl border border-slate-100 p-4 hover:shadow-md transition bg-white">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-xs text-slate-500">Complaint #<?php echo e($c->complaint_id); ?></p>
                                    <p class="font-bold text-slate-900 mt-1 line-clamp-1">
                                        <?php echo e($c->complaint_message ?? 'No message'); ?>

                                    </p>
                                </div>

                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                                    <?php echo e(($c->status ?? '') === 'open' ? 'bg-green-50 text-green-700 border border-green-100' : 'bg-slate-100 text-slate-700 border border-slate-200'); ?>">
                                    <?php echo e(strtoupper($c->status ?? 'OPEN')); ?>

                                </span>
                            </div>

                            <p class="text-xs text-slate-500 mt-3">Order ID: <?php echo e($c->order_id ?? '-'); ?></p>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="mt-6">
                    <?php echo e($complaints->links()); ?>

                </div>
            <?php endif; ?>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\new xampp\Selfdesk-laravel\resources\views/complaints/buyer-index.blade.php ENDPATH**/ ?>