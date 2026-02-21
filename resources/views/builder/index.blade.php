<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FormForceAI Builder</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900">
    <nav class="sticky top-0 z-50 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center gap-8">
                    <a href="/dashboard" class="text-lg font-bold text-slate-900">⚡ FormForceAI</a>
                    <div class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-600">
                        <a href="/dashboard" class="hover:text-slate-900">Dashboard</a>
                        <a href="#" class="hover:text-slate-900">My Forms</a>
                        <a href="/builder" class="text-slate-900 border-b-2 border-slate-900 pb-1">Builder</a>
                    </div>
                </div>

                <div class="relative group">
                    <button class="flex items-center gap-2 text-sm font-semibold text-slate-700 hover:text-slate-900">
                        <span>{{ auth()->user()->name }}</span>
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.2l3.71-3.97a.75.75 0 111.08 1.04l-4.25 4.55a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="absolute right-0 mt-2 w-44 rounded-lg border border-slate-200 bg-white shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition">
                        <form method="POST" action="/logout" class="p-2">
                            @csrf
                            <button type="submit" class="w-full text-left rounded-md px-3 py-2 text-sm text-slate-700 hover:bg-slate-100">Log Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-10">
        <div class="text-center">
            <h1 class="text-3xl font-bold text-slate-900">Form Builder</h1>
            <p class="mt-2 text-slate-600">Coming soon</p>
        </div>
    </main>

    <footer class="bg-slate-100 text-center text-sm text-slate-500 py-6 mt-10">
        FormForceAI
    </footer>
</body>
</html>
