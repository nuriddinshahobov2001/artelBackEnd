<?php

namespace App\Http\Controllers;

use App\Models\SlidersAndBanners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlidersAndBannersController extends Controller
{
    public function sliders()
    {
        $sliders = SlidersAndBanners::where('type', SlidersAndBanners::SLIDER)->get();

        return view('admin.sliders_and_banners.slider', compact('sliders'));
    }

    public function add_slider(Request $request) {
        $file = Storage::disk('public')->put('sliders_and_banners', $request->image);

        SlidersAndBanners::create([
            'image' => $file,
            'type' => SlidersAndBanners::SLIDER
        ]);

        return redirect()->back()->with('success', 'Успешно добавлено!');
    }

    public function banner()
    {
        $images = SlidersAndBanners::whereIn('type',
            [SlidersAndBanners::HIT,SlidersAndBanners::SALE,SlidersAndBanners::SEASONAL ])->get();

        return view('admin.sliders_and_banners.banner', compact('images'));
    }

    public function add_banner(Request $request)
    {
        $file = Storage::disk('public')->put('sliders_and_banners', $request->image);
        SlidersAndBanners::create([
            'image' => $file,
            'type' => $request->type
        ]);

        return redirect()->back()->with('success', 'Успешно добавлено!');
    }

    public function footer()
    {
        $images = SlidersAndBanners::where('type', SlidersAndBanners::FOOTER)->get();

        return view('admin.sliders_and_banners.footer', compact('images'));
    }

    public function add_footer(Request $request)
    {
        $file = Storage::disk('public')->put('sliders_and_banners', $request->image);
        SlidersAndBanners::create([
            'image' => $file,
            'type' => SlidersAndBanners::FOOTER
        ]);

        return redirect()->back()->with('success', 'Успешно добавлено!');
    }

    public function destroy($id, Request $request)
    {
        $path = 'public/' . $request->image;

        Storage::delete($path);

        SlidersAndBanners::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Успешно удалено!');
    }
}
