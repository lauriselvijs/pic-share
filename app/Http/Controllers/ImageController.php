<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            "title" => "required|string",
            "author" => "required|string",
            "image" => "required|image|mimes:jpeg,png",
            "tags" => "string",
        ]);

        $imageName = Storage::disk("media")->put("images", $request->file("image"));
        $imagePath = parse_url(Storage::disk("media")->url($imageName))["path"];

        $formData["image"] = $imagePath;

        Image::create($formData);

        return redirect("/")->with("message",  array('msgTitle' => 'Success!', 'msgInfo' => 'Image has been added to PicShare successfully!'));
    }

    /**
     * Show edit image form
     *
     * @param App\Models\Image $image
     * @return \Illuminate\Routing\Redirector
     */
    public function edit(Image $image)
    {
        return view("images.edit", ["image" => $image]);
    }

    /**
     * Update existing image
     *
     * @param App\Models\Image $image
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Image $image, Request $request)
    {
        $formData = $request->validate([
            "title" => "required|string",
            "author" => "required|string",
            "image" => "sometimes|image|mimes:jpeg,png",
            "tags" => "string",
        ]);

        if ($request->hasFile("image")) {
            $imageName = Storage::disk("media")->put("images", $request->file("image"));
            $imagePath = parse_url(Storage::disk("media")->url($imageName))["path"];

            $formData["image"] = $imagePath;
        }

        $image->update($formData);

        return back()->with("message",  array('msgTitle' => 'Success!', 'msgInfo' => 'Image has been update!'));
    }

    /**
     * Remove image from DB
     *
     * @param App\Models\Image $image
     * @return \Illuminate\Routing\Redirector
     */
    public function delete(Image $image)
    {
        $image->delete();

        return redirect("/")->with("message",  array('msgTitle' => 'Success!', 'msgInfo' => 'Image has been deleted'));
    }
}
