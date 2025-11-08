<!doctype html>
<html lang="id">

<head>
    
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    
    <link rel="icon" href="/logo.png" type="image/x-icon" />

    
    <title>Catatan Keuangan - Chrisjo</title>

    
    <link rel="stylesheet" href="/assets/vendor/bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>


    <style>
        * {
            font-family: 'Poppins', 'Segoe UI', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f0f4ff 0%, #f0fff5 100%);
            min-height: 100vh;
            background-attachment: fixed;
        }

        .card {
            border-radius: 12px;
            border: none;
        }

        .navbar {
            background: linear-gradient(90deg, #007bff 0%, #00bcd4 100%);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.2);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            color: white !important;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: linear-gradient(90deg, #007bff, #0056b3);
            border: none;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #0056b3, #003d82);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.3);
        }

        .badge {
            padding: 0.5rem 0.75rem;
            font-weight: 600;
            border-radius: 6px;
        }

        .table-striped tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 0.75rem 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .card.bg-gradient {
            color: white;
            position: relative;
            overflow: hidden;
        }

        .card.bg-gradient::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.25);
            z-index: 0;
        }

        .card.bg-gradient .card-body * {
            position: relative;
            z-index: 1;
        }

        .card-income {
            background: linear-gradient(135deg, #00c6ff, #0072ff);
        }

        .card-expense {
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
        }

        .card-balance {
            background: linear-gradient(135deg, #43e97b, #38f9d7);
        }
    </style>
</head>

<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-wallet"></i> Catatan Keuangan
            </a>
            <div class="d-flex align-items-center">
                <?php if(auth()->guard()->check()): ?>
                <span class="text-white me-3 d-none d-md-inline">Hai, <strong><?php echo e(Auth::user()->name); ?></strong></span>
                <form action="<?php echo e(route('auth.logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-warning btn-sm">Keluar</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    
    <div class="container-fluid mb-5">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    
    <script src="/assets/vendor/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>

    
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>


    
    <script>
        document.addEventListener('livewire:initialized', function () {

            // ✅ Modal Show/Hide
            Livewire.on('showModal', (data) => {
                const modalEl = document.getElementById(data.id);
                if (modalEl) new bootstrap.Modal(modalEl).show();
            });

            Livewire.on('closeModal', (data) => {
                const modalEl = document.getElementById(data.id);
                if (modalEl) {
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                }
            });

            // ✅ Lihat data (View)
            Livewire.on('openViewModal', () => {
                const modalEl = document.getElementById('viewTodoModal');
                if (modalEl) new bootstrap.Modal(modalEl).show();
            });

            // ✅ Event baru dari ViewTodoModal.php
Livewire.on('show-view-modal', () => {
    const modal = new bootstrap.Modal(document.getElementById('viewTodoModal'));
    modal.show();
});


            // ✅ Alert sukses & error
            Livewire.on('alertSuccess', (message) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: message,
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            });

            Livewire.on('alertError', (message) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: message,
                    toast: true,
                    position: 'top-end'
                });
            });
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\ASUS\OneDrive\Pictures\CatatanKeuangan\resources\views/layouts/app.blade.php ENDPATH**/ ?>