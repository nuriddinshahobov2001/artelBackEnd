<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    const ON_SELF = 30;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = Category::paginate(self::ON_SELF);

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

    public function get()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=utf-8'
        ])->withBasicAuth(
            Config::get('constants.credentials.login'),
            Config::get('constants.credentials.password')
        )->get(Config::get('constants.api.get_categories'));

        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Ошибка при загрузке!');
        }

        $res = $this->categoryService->get($response->json()['data']);
        if ($res) {
            return redirect()->back()->with('success', 'Категории успешно загружены!');
        } else {
            return redirect()->back()->with('error', $res);
        }
    }
}
