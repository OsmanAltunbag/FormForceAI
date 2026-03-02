<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{ $form->title }} - FormForce AI</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900">
        <main class="mx-auto flex min-h-screen w-full max-w-3xl items-center px-4 py-10 sm:px-6">
            <div class="w-full rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <header class="mb-8 text-center">
                    <h1 class="text-2xl font-bold sm:text-3xl">{{ $form->title }}</h1>
                    @if($form->description)
                        <p class="mt-2 text-slate-600">{{ $form->description }}</p>
                    @endif
                </header>

                @if ($errors->any())
                    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        <p class="font-semibold">Please fix the highlighted errors and submit again.</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('public.forms.submit', $form->slug) }}" class="space-y-5">
                    @csrf

                    @foreach(data_get($form->schema, 'fields', []) as $field)
                        @php
                            $name = $field['name'] ?? '';
                            $label = $field['label'] ?? $name;
                            $type = $field['type'] ?? 'text';
                            $required = !empty($field['required']);
                            $placeholder = $field['placeholder'] ?? '';
                            $options = is_array($field['options'] ?? null) ? $field['options'] : [];
                        @endphp

                        @if($name)
                            <div class="space-y-2">
                                <label for="{{ $name }}" class="block text-sm font-medium text-slate-700">
                                    {{ $label }}
                                    @if($required)
                                        <span class="text-red-500">*</span>
                                    @endif
                                </label>

                                @if($type === 'textarea')
                                    <textarea
                                        id="{{ $name }}"
                                        name="{{ $name }}"
                                        rows="4"
                                        placeholder="{{ $placeholder }}"
                                        @required($required)
                                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none transition focus:border-slate-500"
                                    >{{ old($name) }}</textarea>

                                @elseif($type === 'select')
                                    <select
                                        id="{{ $name }}"
                                        name="{{ $name }}"
                                        @required($required)
                                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none transition focus:border-slate-500"
                                    >
                                        <option value="">Select an option</option>
                                        @foreach($options as $option)
                                            <option value="{{ $option }}" @selected(old($name) == $option)>{{ $option }}</option>
                                        @endforeach
                                    </select>

                                @elseif($type === 'checkbox')
                                    @if(!empty($options))
                                        <div class="space-y-2">
                                            @foreach($options as $option)
                                                <label class="flex items-center gap-2 text-sm text-slate-700">
                                                    <input
                                                        type="checkbox"
                                                        name="{{ $name }}[]"
                                                        value="{{ $option }}"
                                                        @checked(in_array($option, old($name, []), true))
                                                        class="h-4 w-4 rounded border-slate-300"
                                                    />
                                                    <span>{{ $option }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @else
                                        <label class="flex items-center gap-2 text-sm text-slate-700">
                                            <input
                                                id="{{ $name }}"
                                                type="checkbox"
                                                name="{{ $name }}"
                                                value="1"
                                                @checked(old($name))
                                                class="h-4 w-4 rounded border-slate-300"
                                            />
                                            <span>{{ $label }}</span>
                                        </label>
                                    @endif

                                @elseif($type === 'radio')
                                    <div class="space-y-2">
                                        @foreach($options as $option)
                                            <label class="flex items-center gap-2 text-sm text-slate-700">
                                                <input
                                                    type="radio"
                                                    name="{{ $name }}"
                                                    value="{{ $option }}"
                                                    @checked(old($name) == $option)
                                                    @required($required)
                                                    class="h-4 w-4 border-slate-300"
                                                />
                                                <span>{{ $option }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                @else
                                    <input
                                        id="{{ $name }}"
                                        type="{{ in_array($type, ['text', 'email', 'number', 'date'], true) ? $type : 'text' }}"
                                        name="{{ $name }}"
                                        value="{{ old($name) }}"
                                        placeholder="{{ $placeholder }}"
                                        @required($required)
                                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none transition focus:border-slate-500"
                                    />
                                @endif

                                @error($name)
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                    @endforeach

                    <button
                        type="submit"
                        class="w-full rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800"
                    >
                        Submit Form
                    </button>
                </form>

                <footer class="mt-8 text-center text-sm text-slate-500">
                    Powered by FormForce AI
                </footer>
            </div>
        </main>
    </body>
</html>
