<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Log in - {{ config('app.name', 'Laravel') }}</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-white text-gray-900">
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
        <!-- Left Panel -->
        <div class="hidden lg:flex flex-col justify-center px-12 bg-gradient-to-br from-slate-900 via-blue-900 to-indigo-900 text-white">
            <div class="max-w-md">
                <div class="text-4xl font-extrabold tracking-tight">FormForce AI</div>
                <p class="mt-4 text-lg text-blue-100">Build beautiful forms with the power of AI</p>

                <ul class="mt-8 space-y-3 text-blue-100">
                    <li class="flex items-start gap-3">
                        <span class="mt-1">✦</span>
                        <span>AI-generated forms in seconds</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-1">✦</span>
                        <span>No coding required</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-1">✦</span>
                        <span>Share with anyone instantly</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="flex items-center justify-center px-6 py-12 bg-white">
            <div class="w-full max-w-md">
                <h1 class="text-3xl font-bold text-slate-900">Welcome back</h1>
                <p class="mt-2 text-sm text-slate-600">
                    Don't have an account?
                    <a href="/register" class="font-semibold text-blue-700 hover:text-blue-800">Sign up</a>
                </p>

                <!-- Session Status -->
                @if ($errors->any())
                    <div class="mt-4 rounded-lg bg-red-50 p-3 text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form class="mt-8 space-y-5" method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="you@example.com"
                            value="{{ old('email') }}"
                            class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-200"
                        />
                        @if ($errors->get('email'))
                            <p class="mt-2 text-sm text-red-600">{{ implode(' ', $errors->get('email')) }}</p>
                        @endif
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="current-password"
                            placeholder="Your password"
                            class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-200"
                        />
                        @if ($errors->get('password'))
                            <p class="mt-2 text-sm text-red-600">{{ implode(' ', $errors->get('password')) }}</p>
                        @endif
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center gap-2">
                        <input
                            id="remember"
                            name="remember"
                            type="checkbox"
                            class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                        />
                        <label for="remember" class="text-sm text-slate-600">Remember me</label>
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-md transition hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-300"
                    >
                        Log in
                    </button>
                </form>

                @if (Route::has('password.request'))
                    <p class="mt-4 text-center text-sm text-slate-600">
                        <a href="{{ route('password.request') }}" class="font-semibold text-blue-700 hover:text-blue-800">Forgot your password?</a>
                    </p>
                @endif

                <p class="mt-10 text-center text-xs text-slate-500">Powered by FormForce AI</p>
            </div>
        </div>
    </div>
</body>
</html>
