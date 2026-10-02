<footer class="border-t border-gray-200 dark:border-gray-800 mt-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col sm:flex-row gap-4 items-center justify-between text-sm text-gray-500 dark:text-gray-400">
        <div class="flex items-center gap-2">
            <?php if (isset($component)) { $__componentOriginal8892e718f3d0d7a916180885c6f012e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8892e718f3d0d7a916180885c6f012e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.application-logo','data' => ['class' => 'h-5 w-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('application-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-5 w-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $attributes = $__attributesOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $component = $__componentOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__componentOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
            <span>&copy; <?php echo e(date('Y')); ?> Codingsols. Built by developers, for developers.</span>
        </div>
        <nav class="flex gap-6" aria-label="Footer">
            <a href="<?php echo e(route('about')); ?>" class="hover:text-gray-900 dark:hover:text-white">About</a>
            <a href="<?php echo e(route('contact')); ?>" class="hover:text-gray-900 dark:hover:text-white">Contact</a>
            <a href="https://github.com/nevil-codes/codingsols" class="hover:text-gray-900 dark:hover:text-white">GitHub</a>
        </nav>
    </div>
</footer>
<?php /**PATH /Users/nick/codingsols/resources/views/layouts/footer.blade.php ENDPATH**/ ?>