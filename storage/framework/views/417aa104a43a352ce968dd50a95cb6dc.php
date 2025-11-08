<div wire:ignore.self class="modal fade" id="viewTodoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            
            <div class="modal-header">
                <h5 class="modal-title">Detail Catatan Keuangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            
            <div class="modal-body">
                <!--[if BLOCK]><![endif]--><?php if($transaction): ?>
                    
                    <!--[if BLOCK]><![endif]--><?php if($transaction->image_url): ?>
                        <div class="text-center mb-3">
                            <img src="<?php echo e($transaction->image_url); ?>" 
                                 alt="Gambar Transaksi" 
                                 class="img-fluid rounded shadow-sm" 
                                 style="max-height: 250px;">
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center">Tidak ada gambar untuk transaksi ini.</p>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    
                    <h5><?php echo e($transaction->title); ?></h5>
                    <p><?php echo e($transaction->description); ?></p>
                    <p><strong>Jumlah:</strong> Rp <?php echo e(number_format($transaction->amount, 2, ',', '.')); ?></p>
                    <p><strong>Tipe:</strong> <?php echo e(ucfirst($transaction->type)); ?></p>
                    <p><strong>Tanggal:</strong> <?php echo e($transaction->date->format('d M Y')); ?></p>

                    
                    <div class="mt-3">
                        <label for="newImage" class="form-label">Ganti Gambar</label>
                        <input type="file" wire:model="newImage" class="form-control">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['newImage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        <button wire:click="updateImage" class="btn btn-primary mt-2">Perbarui Gambar</button>
                    </div>
                <?php else: ?>
                    <p class="text-center text-muted">Tidak ada data transaksi.</p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>

        </div>
    </div>
</div>
<?php /**PATH C:\Users\ASUS\OneDrive\Pictures\CatatanKeuangan\resources\views/livewire/modals/view-todo-modal.blade.php ENDPATH**/ ?>