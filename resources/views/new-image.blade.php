@extends("layout.index")
@section("title")
Add Image
@endsection

@section("content")
<x-card.logo>
    <x-slot name="heading">
        Upload new image
    </x-slot>
    <x-form action="#">
        <x-input label="Image title" type="text" name="image-title" placeholder="My image title" required="true" />
        <x-input label="Tags" type="text" name="tags" placeholder="History, Art, Forest" required="false" />
        <div class="w-full p-20 bg-sunset flex flex-col justify-center items-center gap-2" x-data="{ files: null }">
            <img class="w-6 h-6" src={{ asset("images/upload-icon.svg") }} alt="Upload">
            <p class="text-xs whitespace-nowrap font-medium text-black">Drag profile picture to this
                drop
                zone.
                *.jpeg *.png</p>
            <label for="image"
                class="text-sm font-medium text-white bg-black px-2.5 py-2.5 text-center hover:bg-shadow cursor-pointer">Upload
                your image</label>
            <input hidden aria-describedby="image" id="image" type="file" accept="image/png, image/jpeg"
                x-on:change="files = Object.values($event.target.files)">
            <span title="Click to remove" class="text-base font-medium text-black cursor-pointer"
                x-text="files && files.map(file => file.name).join(', ')" x-on:click="files = null"></span>
        </div>
        <button type="submit"
            class="w-full text-white bg-black hover:bg-shadow focus:ring-4 focus:outline-none focus:ring-sunset font-medium text-base px-5 py-2.5 text-center">Save
            image</button>
    </x-form>
</x-card.logo>

@endsection