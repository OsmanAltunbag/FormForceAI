<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FormForceAI Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900">
    <nav class="sticky top-0 z-50 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center gap-8">
                    <a href="/dashboard" class="text-lg font-bold text-slate-900">⚡ FormForceAI</a>
                    <div class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-600">
                        <a href="/dashboard" class="text-slate-900 border-b-2 border-slate-900 pb-1">Dashboard</a>
                        <a href="#" class="hover:text-slate-900">My Forms</a>
                        <a href="/builder" class="hover:text-slate-900">Builder</a>
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

    <header class="bg-gradient-to-r from-slate-900 to-slate-800">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="flex flex-col gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white">Welcome back, {{ auth()->user()->name }} 👋</h1>
                    <p class="mt-2 text-slate-200 text-lg">Ready to build something amazing?</p>
                </div>
                <div>
                    <a href="/builder" class="inline-flex items-center justify-center rounded-full bg-blue-500 px-6 py-3 text-white font-semibold shadow-lg hover:bg-blue-600 transition">
                        ✦ Create New Form with AI
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-10">
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-md p-6 flex items-center gap-4">
                <div class="h-12 w-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M6 2a2 2 0 00-2 2v14a2 2 0 002 2h8l6-6V4a2 2 0 00-2-2H6zm8 16v-4h4l-4 4z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Total Forms</p>
                    <p class="text-2xl font-bold text-slate-900">0</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 flex items-center gap-4">
                <div class="h-12 w-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M4 4a2 2 0 00-2 2v10a2 2 0 002 2h4l4 4 4-4h4a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h16v10H15.17L12 19.17 8.83 16H4V6z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Total Submissions</p>
                    <p class="text-2xl font-bold text-slate-900">0</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 flex items-center gap-4">
                <div class="h-12 w-12 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm4.3 7.3l-4.7 4.7a1 1 0 01-1.4 0l-2.5-2.5a1 1 0 011.4-1.4l1.8 1.8 4-4a1 1 0 011.4 1.4z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Active Forms</p>
                    <p class="text-2xl font-bold text-slate-900">0</p>
                </div>
            </div>
        </section>

        <section class="mt-10">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-slate-900">Your Forms</h2>
                <a href="/builder" class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                    New Form
                </a>
            </div>

            <div class="mt-6 bg-white rounded-2xl shadow-sm border border-slate-200 p-10">
                <div class="flex flex-col items-center text-center gap-3">
                    <div class="text-5xl">📋</div>
                    <h3 class="text-lg font-semibold text-slate-900">No forms yet</h3>
                    <p class="text-slate-500">Create your first AI-powered form in seconds</p>
                    <a href="/builder" class="mt-2 inline-flex items-center rounded-full bg-slate-900 px-5 py-2.5 text-white font-semibold hover:bg-slate-800">
                        Create my first form →
                    </a>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-slate-100 text-center text-sm text-slate-500 py-6">
        FormForceAI
    </footer>
</body>
</html>
