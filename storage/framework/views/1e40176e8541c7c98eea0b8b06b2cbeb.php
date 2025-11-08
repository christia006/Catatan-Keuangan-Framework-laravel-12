<form wire:submit.prevent="login">
    <div class="card mx-auto" style="max-width: 360px;">
        <div class="card-body">
            <div>
                <div class="text-center">
                   <img src="<?php echo e(asset('assets/logo.png')); ?>" alt="Logo">

                    <h2>Masuk</h2>
                </div>
                <hr>
                
                <div class="form-group mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" wire:model="email">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-danger"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                
                <div class="form-group mb-3">
                    <label>Kata Sandi</label>
                    <input type="password" class="form-control" wire:model="password">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-danger"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                
                <div class="form-group mt-3 text-end">
                    <button type="submit" class="btn btn-primary btn-block">Kirim</button>
                </div>

                <hr>
                <p class="text-center">Belum memiliki akun? <a href="<?php echo e(route('auth.register')); ?>">Daftar</a></p>
            </div>
        </div>
    </div>
</form><?php /**PATH C:\Users\ASUS\OneDrive\Pictures\CatatanKeuangan\resources\views/livewire/auth-login-livewire.blade.php ENDPATH**/ ?>