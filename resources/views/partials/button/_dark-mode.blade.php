<div class='order-3 flex justify-end mx-4'>
    <template x-if='true'>
        <button class='fill-white hover:fill-sunset' aria-label='Dark mode' x-data='{darkMode: false}'
            x-on:click='darkMode = !darkMode'>
            <svg x-show='darkMode' width='24' height='24' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'>
                <title>Sun</title>
                <path
                    d='M11 3a1 1 0 0 1 2 0v2a1 1 0 0 1-2 0V3zm0 16a1 1 0 0 1 2 0v2a1 1 0 0 1-2 0v-2zm1-2a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-9-2a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2H3zm16 0a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2h-2zm-.707-8.707a1 1 0 0 1 1.414 1.414l-1.581 1.581a1 1 0 0 1-1.414-1.414l1.58-1.581zM5.707 19.707a1 1 0 1 1-1.414-1.414l1.581-1.581a1 1 0 1 1 1.414 1.414l-1.58 1.581zm-1.414-14a1 1 0 0 1 1.414-1.414l1.581 1.581a1 1 0 0 1-1.414 1.414l-1.581-1.58zm15.414 12.586a1 1 0 0 1-1.414 1.414l-1.581-1.581a1 1 0 0 1 1.414-1.414l1.581 1.58z' />
            </svg>
            <svg x-show='!darkMode' width='24' height='24' viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg'>
                <title>Moon</title>
                <path
                    d='M13.2 11.9c-4.5 0-8.1-3.6-8.1-8.1 0-1.4 0.3-2.7 0.9-3.8-3.4 0.9-6 4.1-6 7.9 0 4.5 3.6 8.1 8.1 8.1 3.1 0 5.8-1.8 7.2-4.4-0.6 0.2-1.3 0.3-2.1 0.3zM8.1 15c-3.9 0-7.1-3.2-7.1-7.1 0-2.5 1.3-4.7 3.3-6-0.2 0.6-0.2 1.2-0.2 1.9 0 5 4.1 9.1 9.1 9.2-1.4 1.2-3.2 2-5.1 2z'>
                </path>
            </svg>
        </button>
    </template>
</div>