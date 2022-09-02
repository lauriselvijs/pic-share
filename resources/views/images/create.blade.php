@extends("layout.index")
@section("title")
Add Image
@endsection

@section("content")
<x-card.logo>
    <x-slot name="heading">
        Upload new image
    </x-slot>
    <x-form method="POST" action="/images">
        @csrf
        <x-input label="Title" type="text" name="title" placeholder="My image title" required="" />
        @error("title")
        <x-message.error>
            {{ $message }}
        </x-message.error>
        @enderror

        <x-input label="Author" type="text" name="author" placeholder="Author name" required="" />
        @error("author")
        <x-message.error>
            {{ $message }}
        </x-message.error>
        @enderror


        <x-input label="Tags" type="text" name="tags" placeholder="History, Art, Forest" required="" />
        @error("tags")
        <x-message.error>
            {{ $message }}
        </x-message.error>
        @enderror

        {{-- <div class="w-full p-20 bg-sunset flex flex-col justify-center items-center gap-2"
            x-data="{ files: null }">
            <img class="w-6 h-6" src={{ asset("assets/images/upload-icon.svg") }} alt="Upload">
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
        </div> --}}
        <x-button type="submit">
            Save image
        </x-button>
    </x-form>
</x-card.logo>

@endsection