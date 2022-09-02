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
            "images" => Image::latest()->filter(request(["tag", "search"]))->paginate(9)
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
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $formData = $request->validate([
            "title" => "string|required",
            "author" => "required|string",
            "tags" => "string",
        ]);

        Image::create($formData);

        return redirect("/")->with("message",  array('msgTitle' => 'Success!', 'msgInfo' => 'Image has been added to PicShare successfully!'));
    }
}
