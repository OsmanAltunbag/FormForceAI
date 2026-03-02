<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Thank You - FormForce AI</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900">
        <main class="mx-auto flex min-h-screen w-full max-w-2xl items-center justify-center px-4 py-10 sm:px-6">
            <div class="w-full rounded-2xl border border-slate-200 bg-white p-8 text-center shadow-sm">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-green-100 text-2xl text-green-600">
                    ✓
                </div>

                <h1 class="text-2xl font-bold">Thank you for your submission!</h1>
                <p class="mt-2 text-slate-600">Your response has been recorded successfully.</p>

                <a
                    href="{{ route('public.forms.show', $form->slug) }}"
                    class="mt-6 inline-block rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800"
                >
                    Fill the form again
                </a>
            </div>
        </main>
    </body>
</html>
