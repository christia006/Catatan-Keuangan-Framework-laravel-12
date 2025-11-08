<form wire:submit.prevent="addTodo" enctype="multipart/form-data">
    <div class="modal fade" id="addTodoModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Catatan Keuangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                
                <div class="modal-body">

                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul</label>
                        <input type="text" class="form-control" wire:model.defer="addTodoTitle"
                            placeholder="Masukkan judul catatan...">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['addTodoTitle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger small"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea class="form-control" rows="4" wire:model.defer="addTodoDescription"
                            placeholder="Tuliskan deskripsi pemasukan/pengeluaran..."></textarea>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['addTodoDescription'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger small"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jumlah</label>
                        <input type="number" step="0.01" class="form-control" wire:model.defer="addTodoAmount"
                            placeholder="Masukkan jumlah (contoh: 250000)">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['addTodoAmount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger small"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold d-block">Tipe</label>
                        <div class="d-flex gap-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="incomeRadio"
                                    value="income" wire:model.defer="addTodoType">
                                <label class="form-check-label fw-medium" for="incomeRadio">💰 Pemasukan</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="expenseRadio"
                                    value="expense" wire:model.defer="addTodoType">
                                <label class="form-check-label fw-medium" for="expenseRadio">💸 Pengeluaran</label>
                            </div>
                        </div>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['addTodoType'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger small"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal</label>
                        <input type="date" class="form-control" wire:model.defer="addTodoDate">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['addTodoDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger small"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Upload Cover</label>
                        <input type="file" class="form-control" wire:model="addTodoCover" accept="image/*">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['addTodoCover'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger small"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->

                        
                        <!--[if BLOCK]><![endif]--><?php if($addTodoCover): ?>
                            <div class="mt-3">
                                <p class="mb-1 fw-semibold">Preview:</p>
                                <img src="<?php echo e($addTodoCover->temporaryUrl()); ?>" class="rounded shadow-sm" width="120">
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        
                        <div wire:loading wire:target="addTodoCover" class="text-muted small mt-2">
                            Mengunggah gambar...
                        </div>
                    </div>
                </div>

                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <span wire:loading.remove wire:target="addTodo">Simpan</span>
                        <span wire:loading wire:target="addTodo">Menyimpan...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>


<script>
document.addEventListener('livewire:load', () => {
    const modal = document.getElementById('addTodoModal');
    modal.addEventListener('hidden.bs.modal', () => {
        Livewire.dispatch('resetAddTodoForm');
    });
});
</script>
<?php /**PATH C:\Users\ASUS\OneDrive\Pictures\CatatanKeuangan\resources\views/livewire/add-todo-modal.blade.php ENDPATH**/ ?>