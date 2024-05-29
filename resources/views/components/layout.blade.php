<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <!-- Styles -->
        @vite('resources/css/app.css')
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/80">
        @session('access-token')
            <div class="fixed top-4 right-4 z-50 flex flex-col gap-2 alert">
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                    <p class="font-bold">Access Token</p>
                    <p>{{ session('access-token') }}</p>
                </div>
            </div>
        @endsession
        @session('message')
            <div class="fixed bottom-4 right-4 z-50 flex flex-col gap-2 alert">
                <div class="bg-gray-950 text-gray-50 rounded-lg shadow-lg p-4 flex items-center gap-3 animate-slide-in-bottom">
                    <div class="bg-gray-800 rounded-full p-2">
                        <svg
                            class="w-5 h-5"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            strokeWidth="2"
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            >
                            <circle cx="12" cy="12" r="10" />
                            <path d="m9 12 2 2 4-4" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-400">{{ session('message') }}</p>
                    </div>
                    <button class="text-gray-400 hover:text-gray-50 transition-colors" onclick="this.closest('.alert').remove()">
                        <svg
                            class="w-5 h-5"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            strokeWidth="2"
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            >
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        @endsession
        {{ $slot }}
    </body>
</html>
