<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Services\BrandService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class BrandController extends Controller
{
    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function index()
    {
        $brands = Brand::all();

        return view('admin.brands.index', compact('brands'));
    }

    public function store(BrandRequest $request)
    {
        $data = $request->validated();

        $this->brandService->store($data);

        return redirect()->back()->with('success', 'Данные успешно добавлены!');
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        $data = $request->validated();

        $this->brandService->update($data, $brand);

        return redirect()->back()->with('success', 'Успешно обновлено!');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->back()->with('success', 'Успешно удалено!');
    }

    public function get()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=utf-8'
        ])->withBasicAuth(
            Config::get('constants.credentials.login'),
            Config::get('constants.credentials.password')
        )->get(Config::get('constants.api.get_brands'));

        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Ошибка при загрузке товара!');
        }

        $brands = $response->json()['data'];
        $res = $this->brandService->get($brands);

        if ($res) {
            return redirect()->back()->with('success', 'Успешно загружено!');
        } else {
            return redirect()->back()->with('error', $res);
        }
    }
}
