<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Services\BrandService;

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
}
