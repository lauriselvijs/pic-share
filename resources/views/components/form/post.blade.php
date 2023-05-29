@props(['action', 'post' => ''])

<form method='POST' action="{{ $action }}" enctype='multipart/form-data' class='space-y-4'>
    @csrf

    @if ($post)
    @method('PUT')
    @endif

    <x-input label='Title' type='text' name='title' placeholder='{{ __(' My post title') }}' required='required'
        value="{{ $post ? $post->title : old('title') }}" />
    @error('title')
    <x-message.error>
        {{ $message }}
    </x-message.error>
    @enderror

    <x-input label='Tags' type='text' name='tags' placeholder='{{ __(' History, Art, Forest') }}' required=''
        value="{{ $post ? $post->tags : old('tags') }}" />
    @error('tags')
    <x-message.error>
        {{ $message }}
    </x-message.error>
    @enderror

    <x-input label='Price (USD)' type='number' name='price' placeholder='{{ __(' $0.01') }}' required=''
        value="{{ $post ? $post->price : old('price') }}" />
    @error('price')
    <x-message.error>
        {{ $message }}
    </x-message.error>
    @enderror

    {{--
    TODO:
    [ ] - add progress bar
    --}}
    <div id='image-drop-box' class='w-full p-20 bg-sunset flex flex-col justify-center items-center gap-2'>
        <img role="img" class='w-6 h-6' src="{{ asset('assets/icons/upload-icon.svg') }}" alt='{{ __(' Upload') }}'>
        <p class='text-xs whitespace-nowrap font-medium text-black'>{{ __('Drag picture to this drop zone. *.jpeg
            *.png') }}</p>
        <label for='image-drop-box-input' aria-describedby='image-drop-box-input'
            class='text-sm font-medium text-white bg-black px-2.5 py-2.5 text-center hover:bg-shadow cursor-pointer'>{{
            __('Upload your image') }}</label>
        <input hidden id='image-drop-box-input' name='image' type='file' accept='image/png, image/jpeg'>
        <span id="image-drop-box-file-name" title='{{ __(' Click to remove') }}'
            aria-lable="{{ __('Click to remove') }}" class='text-base font-medium text-black cursor-pointer'></span>
        @error('image')
        <x-message.error class='whitespace-nowrap'>
            {{ $message }}
        </x-message.error>
        @enderror

        {{--
        TODO:
        [ ] - change dynamically image so it's dependent on the image that is uploaded
        [ ] - add loading bar when uploading image
        --}}
        @if ($post)
        <img class='h-full w-full' src="{{ $post->image }}" alt='{{ __(' User image') }}'>
        @endif

    </div>

    <x-button type='submit'>
        {{ __('Save post') }}
    </x-button>
</form>