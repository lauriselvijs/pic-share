@extends("layout")
@section("title")
Add Image
@endsection

@section("content")

<div class="bg-sunset">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto">
        <a href="/" class="flex items-center mb-6 text-2xl font-bold text-black">
            <img class="w-8 h-8 mr-2" src={{ asset("images/logo.png") }} alt="logo">
            PicShare
        </a>
        <div class="w-full bg-white shadow  sm:max-w-md">
            <div class="p-6 space-y-4 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Upload new image
                </h1>
                <form class="space-y-4" action="#">
                    <div>
                        <label for="image-title" class="block mb-2 text-base font-medium text-black">Image title</label>
                        <input type="text" name="image-title" id="image-title"
                            class="bg-white border border-black text-black text-sm block w-full p-2.5"
                            placeholder="My image title" required="">
                    </div>
                    <div>
                        <label for="tags" class="block mb-2 text-base font-medium text-black">Tags <span
                                class="font-light">(comma seperated
                                values)</span></label>
                        <input type="text" name="tags" id="tags" placeholder="History, Art, Forest"
                            class="bg-white border border-black text-black text-base block w-full p-2.5" required="">
                    </div>
                    <div class="w-full p-20 bg-sunset flex flex-col justify-center items-center gap-2"
                        x-data="{ files: null }">
                        <img class="w-6 h-6" src={{ asset("images/upload-icon.svg") }} alt="Upload">
                        <p class="text-xs whitespace-nowrap font-medium text-black">Drag profile picture to this drop
                            zone.
                            *.jpeg *.png</p>
                        <label for="image"
                            class="text-sm font-medium text-white bg-black px-2.5 py-2.5 text-center hover:bg-shadow cursor-pointer">Upload
                            your image</label>
                        <input hidden aria-describedby="image" id="image" type="file" accept="image/png, image/jpeg"
                            x-on:change="files = Object.values($event.target.files)">
                        <span title="Click to remove" class="text-base font-medium text-black cursor-pointer"
                            x-text="files && files.map(file => file.name).join(', ')" @click="files = null"></span>
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-black hover:bg-shadow focus:ring-4 focus:outline-none focus:ring-sunset font-medium text-base px-5 py-2.5 text-center">Save
                        image</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection