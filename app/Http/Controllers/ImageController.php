<?php

namespace App\Http\Controllers;

use App\Models\Good;
use App\Models\Image;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $images = Image::all();
        $goods = Good::all();

        return view('admin.images.index', compact('images', 'goods'));
    }

    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'good_id' => 'required',
            'image' => 'required'
        ]);

        $this->imageService->store($data->validated());

        return redirect()->back()->with('success', 'Успешно добавлено!');
    }

    public function update(Request $request, Image $image)
    {
        $data = Validator::make($request->all(), [
            'good_id' => 'required',
            'image' => 'file'
        ]);

        $this->imageService->update($data->validated(), $image);

        return redirect()->back()->with('success', 'Успешно обновлено!');
    }

    public function destroy(Image $image)
    {
        $photo = str_replace('good_img/', 'public/good_img/', $image->image);
        Storage::delete($photo);
        $image->delete();

        return redirect()->back()->with('success', 'Успешно удалено!');
    }
}
