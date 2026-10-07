<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.categories.index', [
            'categories' => Category::withCount('threads')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.form', ['category' => new Category, 'icons' => $this->icons()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Category::create($this->validated($request));

        return redirect()->route('admin.categories.index')->with('flash', 'Category created.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.form', ['category' => $category, 'icons' => $this->icons()]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $category->update($this->validated($request, $category));

        return redirect()->route('admin.categories.index')->with('flash', 'Category updated.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        // Deleting would cascade to every question in it, so require it to be empty.
        if ($category->threads()->exists()) {
            return redirect()->route('admin.categories.index')
                ->with('flash', "\"{$category->name}\" still has questions, so it can't be deleted.");
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('flash', 'Category deleted.');
    }

    /**
     * @return array{name: string, slug: string, description: string, icon: string|null}
     */
    private function validated(Request $request, ?Category $category = null): array
    {
        $request->merge(['slug' => Str::slug($request->input('slug') ?: $request->input('name'))]);

        return $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'slug' => ['required', 'string', 'max:60', Rule::unique('categories')->ignore($category)],
            'description' => ['required', 'string', 'max:500'],
            'icon' => ['nullable', Rule::in($this->icons())],
        ]);
    }

    /**
     * Brand icons bundled in resources/icons/brands.
     *
     * @return list<string>
     */
    private function icons(): array
    {
        return collect(glob(resource_path('icons/brands/*.svg')))
            ->map(fn (string $path) => basename($path, '.svg'))
            ->sort()
            ->values()
            ->all();
    }
}
