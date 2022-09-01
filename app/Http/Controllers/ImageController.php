<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{

    /**
     * Undocumented function
     *
     * @return \Illuminate\Contracts\View\View
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
     * @param App\Models\Image $image
     * @return \Illuminate\Contracts\View\View
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


    /**
     * Show create form
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view("images.create");
    }

    /**
     * Store new image in DB
     *
     * @param Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $request->validate([
            "image-title" => "sometimes|required|unique:products",
            "tags" => "string",

        ]);
    }
}
