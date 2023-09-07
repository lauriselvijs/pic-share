@props(['action', 'post' => ''])

<form method='POST' action="{{ $action }}" enctype='multipart/form-data' class='space-y-4'>
    @csrf

    @if ($post)
    @method('PUT')
    @endif

    <x-input label="{{ __(' Title') }}" name='title' placeholder="{{ __(' My post title') }}" required
        value="{{ $post ? $post->title : old('title') }}" />

    <x-input label="{{ __(' Tags') }}" name='tags' placeholder="{{ __(' History, Art, Forest') }}"
        value="{{ $post ? $post->tags : old('tags') }}" />

    <x-input.number label="{{ __(' Price') }} (USD)" name='price' placeholder='$0.01' required
        value=" {{ $post ? $post->price : old('price') }}" />

    <div id='image-drop-box' class='w-full p-20 bg-sunset flex flex-col justify-center items-center gap-2'>
        <img role="img" class='w-6 h-6' src="{{ asset('assets/icons/upload-icon.svg') }}" alt="{{ __(' Upload') }}">
        <p class='text-xs whitespace-nowrap font-medium text-black'>{{ __('Drag picture to this drop zone')}}.
            *.jpeg,
            *.png (max 10mb)</p>
        <label for='image-drop-box-input' aria-describedby='image-drop-box-input'
            class='text-sm font-medium text-white bg-black px-2.5 py-2.5 text-center hover:bg-shadow cursor-pointer'>{{
            __('Upload your image') }}</label>
        <input hidden id='image-drop-box-input' name='image' type='file' accept='image/png, image/jpeg'>
        <div id="thumbnail-container"></div>
        <span id="image-drop-box-file-name" title='{{ __(' Click to remove') }}'
            aria-lable="{{ __('Click to remove') }}" class='text-base font-medium text-black cursor-pointer'></span>
        @error('image')
        <x-message.error class='whitespace-nowrap' aria-describedby="image-drop-box-input">
            {{ $message }}
        </x-message.error>
        @enderror

        @if ($post)
        <img id="old-post-image" class='h-full w-full' src="{{ $post->image }}" alt='{{ __(' User image') }}'>
        @endif

    </div>

    <x-button type='submit'>
        {{ __('Save post') }}
    </x-button>
</form>