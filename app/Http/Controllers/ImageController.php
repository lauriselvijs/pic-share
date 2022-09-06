<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $images = Image::latest()->filter(request(["tag", "search"]))->paginate(9);

        foreach ($images as $image) {
            $image["author"] = Image::getUserNameOfImage($image->id);
        }

        return view("images.index", [
            "images" => $images
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
        $image["author"] = Image::getUserNameOfImage($image->id);

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
            "image" => "required|image|mimes:jpeg,png",
            "tags" => "string",
        ]);

        $imageName = Storage::disk("media")->put("images", $request->file("image"));
        $imagePath = parse_url(Storage::disk("media")->url($imageName))["path"];

        $formData["image"] = $imagePath;
        $formData["user_id"] = auth()->id();

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
        $image["author"] = Image::getUserNameOfImage($image->id);

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
        //Check if user have rights
        if ($image->user_id !== auth()->id()) {
            abort(403, "Unauthorized action");
        }

        $formData = $request->validate([
            "title" => "required|string",
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
        //Check if user have rights
        if ($image->user_id !== auth()->id()) {
            abort(403, "Unauthorized action");
        }


        $image->delete();

        return redirect("/")->with("message",  array('msgTitle' => 'Success!', 'msgInfo' => 'Image has been deleted'));
    }

    public function userImages()
    {
        $images = Image::latest()->where("user_id", auth()->id())->filter(request(["tag", "search"]))->paginate(9);

        foreach ($images as $image) {
            $image["author"] = Image::getUserNameOfImage($image->id);
        }

        return view("images.index", [
            "images" => $images
        ]);
    }
}
