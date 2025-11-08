
<!doctype html>
<html lang="id">

<head>
    
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    
    <link rel="icon" href="/logo.png" type="image/x-icon" />

    
    <title>Laravel Todolist</title>

    
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <link rel="stylesheet" href="/assets/vendor/bootstrap-5.3.8-dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container-fluid mt-5">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <link rel="stylesheet" href="/assets/vendor/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js">
</body>

</html><?php /**PATH C:\Users\ASUS\OneDrive\Pictures\CatatanKeuangan\resources\views/layouts/auth.blade.php ENDPATH**/ ?>