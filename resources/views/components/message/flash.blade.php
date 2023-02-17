@if (session('message'))
<div id='flash-msg'
    class='fixed top-8 z-10 p-4 mx-auto left-6 right-6  sm:left-1/4 sm:right-1/4 border-black border shadow-lg shadow-black rounded-lg bg-sunset/80 backdrop-blur-md'
    role='alert'>
    <div class='flex items-center'>
        <h2 class='text-2xl font-medium text-black'> {{ session('message')['msg_title'] }}</h2>
        <x-button.close id='close-flash-msg-btn' />
    </div>
    <p class='mt-2 mb-4 text-base text-black'>
        {{ session('message')['msg_info'] }}
    </p>
</div>
</template>
@endif