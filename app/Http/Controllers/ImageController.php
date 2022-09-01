<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{

    /**
     * Undocumented function
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {

        return view("images.index", [
            "images" => Image::latest()->filter(request(["tag", "search"]))->get()
        ]);
    }

    /**
     * Show single image
     *
     * @param Image $image
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show(Image $image)
    {
        return view(
            "images.show",
            [
                "image" => $image
            ]
        );
    }
}
