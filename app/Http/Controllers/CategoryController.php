<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = Category::all();

        return view('admin.category.index', compact('categories'));
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();

        $this->categoryService->store($data);

        return redirect()->back()->with('success', 'Данные успешно добавлены!');
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        $this->categoryService->update($data, $category);

        return redirect()->back()->with('success', 'Успешно обновлено!');
    }

    public function destroy(Category $category)
    {
        $photo = str_replace('category_img/', 'public/category_img/', $category->image);
        Storage::delete($photo);
        $category->delete();

        return redirect()->back()->with('success', 'Успешно удалено!');
    }
}
