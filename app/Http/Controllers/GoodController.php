<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoodStoreRequest;
use App\Http\Requests\GoodUpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Good;
use App\Services\GoodService;
use App\Services\ImageService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class GoodController extends Controller
{
    const ON_PAGE= 30;
    private GoodService $goodService;
    private ImageService $imageService;

    public function __construct(GoodService $goodService, ImageService $imageService)
    {
        $this->goodService = $goodService;
        $this->imageService = $imageService;
    }

    public function index()
    {
        $goods = Good::filter()->with('brand', 'category')->paginate(self::ON_PAGE);

        return view('admin.goods.index', compact('goods'));
    }

    public function show($slug)
    {
        $good = Good::where('slug', $slug)->with('brand', 'category', 'images')->first();

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

        $response1 = Http::withHeaders([
            'Content-Type' => 'application/json; charset=utf-8'
        ])->withBasicAuth(
            Config::get('constants.credentials.login'),
            Config::get('constants.credentials.password')
        )->get(Config::get('constants.api.get_images'));

        if (!$response->successful() || !$response1->successful()) {
            return redirect()->back()->with('error', 'Ошибка при загрузки товаров!');
        }

        $goods = $response->json()['data'];
        $res = $this->goodService->get($goods);

        $images = $response1->json()['data'];
        $res1 = $this->imageService->get($images);

        if ($res && $res1) {
            return redirect()->back()->with('success', 'Товары успешно загружены!');
        }
    }

    public function goodsWithDefects()
    {
        $goods = Good::unFilter()->with('category')->get();//->paginate(self::ON_PAGE);

        return view('admin.goods.goods_with_defects', compact('goods'));
    }

    public function showGoodsWithDefects($slug)
    {
        $good = Good::where('slug', $slug)->with('category', 'brand', 'images')->first();

        return view('admin.goods.show_good_with_defects', compact('good'));
    }
}
