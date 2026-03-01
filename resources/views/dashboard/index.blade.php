<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Forms - FormForge AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-white">
    <!-- Navigation -->
    <nav class="bg-slate-800 border-b border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-bold bg-gradient-to-r from-blue-400 to-indigo-500 bg-clip-text text-transparent">⚡ FormForge AI</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-slate-400">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-3 py-1 text-sm border border-white text-white rounded-lg hover:bg-white hover:text-slate-950 transition duration-200">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-b from-slate-800 to-slate-950 border-b border-slate-700 px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h2 class="text-4xl sm:text-5xl font-bold text-white">My Forms</h2>
            <a href="{{ route('builder.index') }}" 
               class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold py-3 px-8 rounded-xl shadow-lg transition duration-200">
                + Create New Form
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-slate-800 rounded-xl border border-slate-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-900 bg-opacity-40 rounded-lg p-4">
                        <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-slate-400">Total Forms</p>
                        <p class="text-3xl font-bold text-white">{{ $forms->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800 rounded-xl border border-slate-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-900 bg-opacity-40 rounded-lg p-4">
                        <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-slate-400">Total Submissions</p>
                        <p class="text-3xl font-bold text-white">{{ $totalSubmissions }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-900 bg-opacity-30 border border-green-700 text-green-300 px-4 py-3 rounded-lg mb-6">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if($forms->count() > 0)
            <!-- Forms Table -->
            <div class="bg-slate-800 rounded-xl border border-slate-700 overflow-hidden">
                <table class="min-w-full divide-y divide-slate-700">
                    <thead class="bg-slate-950">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                Form Title
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                Submissions
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                Created At
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700">
                        @foreach($forms as $form)
                            <tr class="bg-slate-800 hover:bg-slate-700 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-white">{{ $form->title }}</div>
                                    @if($form->description)
                                        <div class="text-xs text-slate-400">{{ Str::limit($form->description, 50) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="text-sm font-semibold text-white">{{ $form->submissions_count }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($form->is_active)
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-950 text-green-300">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-slate-700 text-slate-300">
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                    {{ $form->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                    <a href="/forms/{{ $form->id }}/submissions" 
                                       class="px-3 py-1 border border-blue-500 text-blue-400 rounded-full hover:bg-blue-500 hover:text-white transition duration-200">
                                        View
                                    </a>
                                    
                                    <button onclick="copyToClipboard('{{ url('/f/' . $form->slug) }}')" 
                                            class="px-3 py-1 border border-slate-500 text-slate-400 rounded-full hover:bg-slate-500 hover:text-white transition duration-200">
                                        Copy Link
                                    </button>
                                    
                                    <form action="{{ route('forms.toggle', $form) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1 border border-yellow-600 text-yellow-400 rounded-full hover:bg-yellow-600 hover:text-white transition duration-200">
                                            {{ $form->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('forms.destroy', $form) }}" method="POST" class="inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this form? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 border border-red-600 text-red-400 rounded-full hover:bg-red-600 hover:text-white transition duration-200">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-slate-800 rounded-xl border border-slate-700 p-16 text-center">
                <div class="text-6xl mb-4">📋</div>
                <h3 class="text-2xl font-bold text-white mb-2">No forms yet</h3>
                <p class="text-slate-400 mb-8">Share your form link to start collecting responses</p>
                <a href="{{ route('builder.index') }}" 
                   class="inline-flex items-center bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold py-3 px-8 rounded-xl shadow-lg transition duration-200">
                    Create my first form →
                </a>
            </div>
        @endif
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Link copied to clipboard!');
            }, function() {
                alert('Failed to copy link');
            });
        }
    </script>
</body>
</html>
