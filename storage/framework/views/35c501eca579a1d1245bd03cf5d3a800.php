<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<meta name="description" content="Codingsols is a community forum where programmers ask questions, share answers and help each other level up.">

<title><?php echo e($title ? $title.' · ' : ''); ?><?php echo e(config('app.name', 'Codingsols')); ?></title>

<link rel="icon" href="<?php echo e(asset('favicon.svg')); ?>" type="image/svg+xml">

<script>
    try {
        const theme = localStorage.getItem('theme');
        if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    } catch (e) {}
</script>

<?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
<?php /**PATH /Users/nick/codingsols/resources/views/layouts/partials/head.blade.php ENDPATH**/ ?>