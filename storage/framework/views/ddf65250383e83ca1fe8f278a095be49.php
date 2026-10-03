<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['user', 'size' => 'md']));

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

foreach (array_filter((['user', 'size' => 'md']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
$palette = ['bg-indigo-500', 'bg-sky-500', 'bg-emerald-500', 'bg-amber-500', 'bg-rose-500', 'bg-violet-500', 'bg-teal-500', 'bg-fuchsia-500'];
$color = $palette[crc32((string) $user?->id) % count($palette)];
$initials = collect(explode(' ', trim($user?->name ?? '?')))->filter()->take(2)->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))->join('');
$sizes = ['sm' => 'h-8 w-8 text-xs', 'md' => 'h-10 w-10 text-sm', 'lg' => 'h-14 w-14 text-lg'];
?>

<span <?php echo e($attributes->merge(['class' => "inline-flex shrink-0 select-none items-center justify-center rounded-full font-semibold text-white {$color} {$sizes[$size]}"])); ?> aria-hidden="true">
    <?php echo e($initials ?: '?'); ?>

</span>
<?php /**PATH /Users/nick/codingsols/resources/views/components/avatar.blade.php ENDPATH**/ ?>