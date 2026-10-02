
<div class="rounded-xl border border-gray-300 bg-white shadow-sm focus-within:border-accent-500 focus-within:ring-1 focus-within:ring-accent-500 dark:border-gray-700 dark:bg-gray-900"
    x-init="$watch('tab', async (value) => {
        if (value !== 'preview') return;
        $refs.preview.innerHTML = '<p class=&quot;text-gray-500&quot;>Rendering…</p>';
        const response = await fetch('<?php echo e(route('markdown.preview')); ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'text/html', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
            body: JSON.stringify({ body }),
        });
        $refs.preview.innerHTML = response.ok ? await response.text() : '<p class=&quot;text-red-600&quot;>Preview failed.</p>';
        window.highlightCode($refs.preview);
    })">
    <div class="flex items-center gap-1 border-b border-gray-200 px-2 pt-2 dark:border-gray-800" role="tablist">
        <button type="button" role="tab" @click="tab = 'write'" :aria-selected="(tab === 'write').toString()"
            :class="tab === 'write' ? 'border-accent-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'"
            class="-mb-px border-b-2 px-3 py-2 text-sm font-medium">Write</button>
        <button type="button" role="tab" @click="tab = 'preview'" :aria-selected="(tab === 'preview').toString()"
            :class="tab === 'preview' ? 'border-accent-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'"
            class="-mb-px border-b-2 px-3 py-2 text-sm font-medium">Preview</button>
        <span class="ml-auto hidden pb-2 text-xs text-gray-400 sm:block">Markdown supported</span>
    </div>

    <div x-show="tab === 'write'">
        <label for="<?php echo e($name); ?>" class="sr-only"><?php echo e($label ?? 'Body'); ?></label>
        <textarea id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" x-model="body" rows="<?php echo e($rows ?? 8); ?>" required
            placeholder="<?php echo e($placeholder); ?>"
            class="block w-full resize-y border-0 bg-transparent font-mono text-sm focus:ring-0"></textarea>
    </div>
    <div x-show="tab === 'preview'" x-cloak class="min-h-[10rem] p-4">
        <div x-ref="preview" class="prose prose-zinc prose-sm dark:prose-invert max-w-none"></div>
    </div>
</div>
<?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get($name),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get($name)),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php /**PATH /Users/nick/codingsols/resources/views/threads/partials/editor.blade.php ENDPATH**/ ?>