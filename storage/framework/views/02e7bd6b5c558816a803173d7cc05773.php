<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['body']));

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

foreach (array_filter((['body']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div <?php echo e($attributes->merge(['class' => 'prose prose-zinc dark:prose-invert max-w-none prose-a:text-accent-600 dark:prose-a:text-accent-400 prose-pre:rounded-lg'])); ?>>
    <?php echo Str::markdown($body, ['html_input' => 'escape', 'allow_unsafe_links' => false, 'max_nesting_level' => 20]); ?>

</div>
<?php /**PATH /Users/nick/codingsols/resources/views/components/markdown.blade.php ENDPATH**/ ?>