<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create your account - {{ config('app.name', 'Laravel') }}</title>

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
                <h1 class="text-3xl font-bold text-slate-900">Create your account</h1>
                <p class="mt-2 text-sm text-slate-600">
                    Already have an account?
                    <a href="/login" class="font-semibold text-blue-700 hover:text-blue-800">Log in</a>
                </p>

                <form class="mt-8 space-y-5" method="POST" action="{{ route('register') }}">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700">Name</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="First and last name"
                            value="{{ old('name') }}"
                            class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-200"
                        />
                        @if ($errors->get('name'))
                            <p class="mt-2 text-sm text-red-600">{{ implode(' ', $errors->get('name')) }}</p>
                        @endif
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            required
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
                            autocomplete="new-password"
                            placeholder="At least 8 characters"
                            class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-200"
                        />
                        @if ($errors->get('password'))
                            <p class="mt-2 text-sm text-red-600">{{ implode(' ', $errors->get('password')) }}</p>
                        @endif
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Confirm Password</label>
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            required
                            autocomplete="new-password"
                            placeholder="Repeat your password"
                            class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-200"
                        />
                        @if ($errors->get('password_confirmation'))
                            <p class="mt-2 text-sm text-red-600">{{ implode(' ', $errors->get('password_confirmation')) }}</p>
                        @endif
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-md transition hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-300"
                    >
                        Create account
                    </button>
                </form>

                <p class="mt-10 text-center text-xs text-slate-500">Powered by FormForce AI</p>
            </div>
        </div>
    </div>
</body>
</html>
