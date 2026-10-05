<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <section class="relative overflow-hidden border-b border-gray-200 dark:border-gray-800">
        <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_top,theme(colors.accent.100),transparent_60%)] dark:bg-[radial-gradient(ellipse_at_top,theme(colors.accent.950),transparent_60%)]"></div>
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 text-center">
            <p class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white/70 px-3 py-1 text-xs font-medium text-gray-600 dark:border-gray-800 dark:bg-gray-900/70 dark:text-gray-300">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                A friendly community for programmers
            </p>
            <h1 class="mt-6 text-4xl sm:text-6xl font-bold tracking-tight">
                Ask. Answer. <span class="text-accent-600 dark:text-accent-400">Level up.</span>
            </h1>
            <p class="mx-auto mt-4 max-w-xl text-lg text-gray-600 dark:text-gray-400">
                Get unstuck on C++, Python, JavaScript and more, and help others along the way.
            </p>

            <form action="<?php echo e(route('search')); ?>" method="GET" role="search" aria-label="Questions" class="mx-auto mt-8 flex max-w-xl flex-col gap-3 sm:flex-row">
                <label for="hero-search" class="sr-only">Search questions</label>
                <input id="hero-search" type="search" name="q" placeholder="Search questions…"
                    class="flex-1 rounded-lg border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-accent-500 focus:ring-accent-500 dark:border-gray-700 dark:bg-gray-900">
                <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['size' => 'lg']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['size' => 'lg']); ?>Search <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
            </form>
        </div>
    </section>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <section id="categories" class="py-12 scroll-mt-16" aria-labelledby="categories-heading">
            <div class="flex items-end justify-between">
                <div>
                    <h2 id="categories-heading" class="text-xl font-semibold tracking-tight">Browse categories</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Pick a topic to read questions or ask your own.</p>
                </div>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('categories.show', $category)); ?>"
                        class="group rounded-xl border border-gray-200 bg-white p-5 transition hover:-translate-y-0.5 hover:border-accent-300 hover:shadow-md dark:border-gray-800 dark:bg-gray-900 dark:hover:border-accent-500/50">
                        <div class="flex items-center justify-between">
                            <?php if (isset($component)) { $__componentOriginal99e3095fe204bf0a105d1301124943c8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal99e3095fe204bf0a105d1301124943c8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.category-icon','data' => ['category' => $category,'class' => 'group-hover:text-accent-600 dark:group-hover:text-accent-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('category-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['category' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($category),'class' => 'group-hover:text-accent-600 dark:group-hover:text-accent-400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal99e3095fe204bf0a105d1301124943c8)): ?>
<?php $attributes = $__attributesOriginal99e3095fe204bf0a105d1301124943c8; ?>
<?php unset($__attributesOriginal99e3095fe204bf0a105d1301124943c8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal99e3095fe204bf0a105d1301124943c8)): ?>
<?php $component = $__componentOriginal99e3095fe204bf0a105d1301124943c8; ?>
<?php unset($__componentOriginal99e3095fe204bf0a105d1301124943c8); ?>
<?php endif; ?>
                            <span class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($category->threads_count); ?> <?php echo e(Str::plural('thread', $category->threads_count)); ?></span>
                        </div>
                        <h3 class="mt-4 font-semibold"><?php echo e($category->name); ?></h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 line-clamp-2"><?php echo e($category->description); ?></p>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </section>

        <section class="pb-4" aria-labelledby="latest-heading">
            <h2 id="latest-heading" class="text-xl font-semibold tracking-tight">Latest questions</h2>
            <?php if($latestThreads->isEmpty()): ?>
                <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'No questions yet','class' => 'mt-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No questions yet','class' => 'mt-6']); ?>Pick a category above and be the first to ask. <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $attributes = $__attributesOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__attributesOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $component = $__componentOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__componentOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
            <?php else: ?>
                <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['class' => 'mt-6 px-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-6 px-5']); ?>
                    <ul class="divide-y divide-gray-200 dark:divide-gray-800">
                        <?php $__currentLoopData = $latestThreads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $thread): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if (isset($component)) { $__componentOriginal51ac405bb5b9f9af5c3873d242fb3480 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51ac405bb5b9f9af5c3873d242fb3480 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.thread-row','data' => ['thread' => $thread]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('thread-row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['thread' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($thread)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51ac405bb5b9f9af5c3873d242fb3480)): ?>
<?php $attributes = $__attributesOriginal51ac405bb5b9f9af5c3873d242fb3480; ?>
<?php unset($__attributesOriginal51ac405bb5b9f9af5c3873d242fb3480); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51ac405bb5b9f9af5c3873d242fb3480)): ?>
<?php $component = $__componentOriginal51ac405bb5b9f9af5c3873d242fb3480; ?>
<?php unset($__componentOriginal51ac405bb5b9f9af5c3873d242fb3480); ?>
<?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $attributes = $__attributesOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__attributesOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $component = $__componentOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__componentOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
            <?php endif; ?>
        </section>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /Users/nick/codingsols/resources/views/home.blade.php ENDPATH**/ ?>