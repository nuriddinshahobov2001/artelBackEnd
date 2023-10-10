<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConvertPhotoController extends Controller
{
    public function convert(Request $request)
    {
        $base64 = $request->base64;

        $decode = base64_decode($base64);
        $fileName = uniqid() . '.png';
        $filePath = storage_path('app/public/good_img/' . $fileName);
        file_put_contents($filePath, $decode);

        $imageUrl = url('storage/good_img/' . $fileName);

        return response()->json([
            'image' => $imageUrl
        ]);
    }

    public function destroy(Request $request)
    {
        $path = 'public/good_img/' . $request->image;

        Storage::delete($path);

        return response()->json([
            'message' => 'Успешно удалено!',
        ]);
    }
}
