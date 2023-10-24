<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoodStoreRequest;
use App\Http\Requests\GoodUpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Good;
use App\Services\GoodService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class GoodController extends Controller
{
    public function __construct(GoodService $goodService)
    {
        $this->goodService = $goodService;
    }

    public function index()
    {
        $goods = Good::all();

        return view('admin.goods.index', compact('goods'));
    }

    public function show(Good $good)
    {
        return view('admin.goods.show', compact('good'));
    }

    public function create()
    {
        $brands = Brand::all();
        $categories = Category::all();

        return view('admin.goods.create', compact('brands', 'categories'));
    }

    public function store(GoodStoreRequest $request)
    {
        $data = $request->validated();

        $this->goodService->store($data);

        return redirect()->route('good.index')->with('success', 'Данные успешно добавлены!');
    }

    public function edit(Good $good)
    {
        $brands = Brand::all();
        $categories = Category::all();

        return view('admin.goods.edit', compact('good', 'brands', 'categories'));
    }

    public function update(GoodUpdateRequest $request, Good $good)
    {
        $this->goodService->update($request, $good);

        return redirect()->route('good.index')->with('success', 'Данные успешно обновлены!');
    }

    public function destroy(Good $good)
    {
        $good->delete();

        return redirect()->back()->with('success', 'Данные успешно удалены!');
    }

    public function get()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=utf-8'
        ])->withBasicAuth(
            Config::get('constants.credentials.login'),
            Config::get('constants.credentials.password')
        )->get(Config::get('constants.api.get_goods'));

        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Ошибка при загрузки товаров!');
        }

        $goods = $response->json()['data'];
        $res = $this->goodService->get($goods);

        if ($res) {
            return redirect()->back()->with('success', 'Успешно загружено!');
        }
    }
}
