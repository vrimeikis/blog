<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Requests\CategoryStoreRequest;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\View\View;

/**
 * Class CategoryController
 * @package App\Http\Controllers\Admin
 */
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $categoriesPaginated = Category::paginate();

        return view('admin.category.list', [
            'categories' => $categoriesPaginated,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryStoreRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryStoreRequest $request): RedirectResponse
    {
        Category::create([
            'title' => $request->getTitle(),
            'slug' => $request->getSlug(),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('status', 'Category created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return View
     */
    public function edit(Category $category): View
    {
        return view('admin.category.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryStoreRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(CategoryStoreRequest $request, Category $category): RedirectResponse
    {
        $category->title = $request->getTitle();
        $category->slug = $request->getSlug();
        $category->save();

        return redirect()->route('admin.categories.index')
            ->with('status', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return RedirectResponse se
     * se
     * @throws Exception
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();
    }
}
