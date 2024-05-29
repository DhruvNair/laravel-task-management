<x-layout>
    <main class="mx-auto max-w-md space-y-6 py-12">
        <header class="space-y-2 text-center">
            <h1 class="text-3xl font-bold">Login</h1>
            <p class="text-gray-500 dark:text-gray-400">
                Enter your credentials to access your account. Don't have an account? <a class="" href="{{ route('register') }}">Register now!</a>
            </p>
        </header>
        <form class="space-y-4" action="{{route('api.login')}}" method="POST">
            @csrf
            <div class="space-y-2">
                <label htmlFor="email">
                    <span>Email</span>
                </label>
                <input
                    class="block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-950 dark:text-gray-50 dark:placeholder-gray-400"
                    id="email"
                    name="email"
                    placeholder="m@example.com"
                    required
                    type="email"
                />
            </div>
            <div class="space-y-2">
                <label htmlFor="password">
                    <span>Password</span>
                </label>
                <input
                    class="block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-950 dark:text-gray-50 dark:placeholder-gray-400"
                    id="password"
                    name="password"
                    placeholder="••••••••"
                    required
                    type="password"
                />
            </div>
            <button
                class="w-full rounded-md bg-indigo-600 px-4 py-2 text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-indigo-500 dark:hover:bg-indigo-600 dark:focus:ring-indigo-600"
                type="submit"
            >
                Register
            </button>
        </form>
    </main>
</x-layout>