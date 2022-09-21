@props(['action', 'post' => ''])

<form method='POST' action={{ $action }} enctype='multipart/form-data' class='space-y-4'>
    @csrf

    @if ($post)
    @method('PUT')
    @endif

    <x-input label='Title' type='text' name='title' placeholder='My post title' required='required'
        value="{{ $post ? $post->title : old('title') }}" />
    @error('title')
    <x-message.error>
        {{ $message }}
    </x-message.error>
    @enderror

    <x-input label='Tags' type='text' name='tags' placeholder='History, Art, Forest' required=''
        value="{{ $post ? $post->tags : old('tags') }}" />
    @error('tags')
    <x-message.error>
        {{ $message }}
    </x-message.error>
    @enderror

    {{-- TODO:
    [] - implement drag and drop file upload using jqueary --}}
    <div class='w-full p-20 bg-sunset flex flex-col justify-center items-center gap-2' x-data='{ files: null }'>
        <img class='w-6 h-6' src={{ asset('assets/images/upload-icon.svg') }} alt='Upload'>
        <p class='text-xs whitespace-nowrap font-medium text-black'>Drag picture to this
            drop
            zone.
            *.jpeg *.png</p>
        <label for='image'
            class='text-sm font-medium text-white bg-black px-2.5 py-2.5 text-center hover:bg-shadow cursor-pointer'>Upload
            your image</label>
        <input hidden aria-describedby='image' id='image' name='image' type='file' accept='image/png, image/jpeg'
            x-on:change='files = Object.values($event.target.files)'>
        <span title='Click to remove' class='text-base font-medium text-black cursor-pointer'
            x-text="files && files.map(file => file.name).join(' , ')" x-on:click='files = null'></span>
        @error('image')
        <x-message.error class='whitespace-nowrap'>
            {{ $message }}
        </x-message.error>
        @enderror

        @if ($post)
        <img class='h-full w-full' src={{ asset($post->image) }} alt='User image'>
        @endif

    </div>

    <x-button type='submit'>
        Save post
    </x-button>
</form>