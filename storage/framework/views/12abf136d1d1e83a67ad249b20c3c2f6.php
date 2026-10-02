<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['category']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['category']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
$path = resource_path('icons/brands/'.basename((string) $category->icon).'.svg');
$svg = $category->icon && is_file($path)
    ? preg_replace(['/<title>.*?<\/title>/', '/<svg /'], ['', '<svg aria-hidden="true" fill="currentColor" class="h-6 w-6" '], file_get_contents($path))
    : null;
?>

<span <?php echo e($attributes->merge(['class' => 'inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-700 ring-1 ring-inset ring-gray-200 dark:bg-gray-800 dark:text-gray-200 dark:ring-gray-700'])); ?>>
    <?php if($svg): ?>
        <?php echo $svg; ?>

    <?php else: ?>
        <span class="font-mono text-sm font-semibold" aria-hidden="true"><?php echo e(mb_substr($category->name, 0, 2)); ?></span>
    <?php endif; ?>
</span>
<?php /**PATH /Users/nick/codingsols/resources/views/components/category-icon.blade.php ENDPATH**/ ?>