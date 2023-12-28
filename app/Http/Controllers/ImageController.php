<?php

namespace App\Http\Controllers;

use App\Models\Good;
use App\Models\Image;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    const ON_SELF = 30;
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $images = Image::with('good')->paginate(self::ON_SELF);

        return view('admin.images.index', compact('images', ));
    }

    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'good_id' => 'required',
            'image' => 'required|file'
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

    public function get()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=utf-8'
        ])->withBasicAuth(
            Config::get('constants.credentials.login'),
            Config::get('constants.credentials.password'),
        )->get(Config::get('constants.api.get_images'));

        if (!$response->successful()) {
            return redirect()->back()->with('error','Ошибка при загрузке!');
        }

        $res = $this->imageService->get($response->json()['data']);
        if ($res) {
            return redirect()->back()->with('success', 'Изображении успешно загружены!');
        } else {
            return redirect()->back()->with('error', $res);
        }
    }
}
