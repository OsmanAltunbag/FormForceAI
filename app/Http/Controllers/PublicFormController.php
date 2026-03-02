<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Submission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class PublicFormController extends Controller
{
    public function show(string $slug): View
    {
        $form = Form::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.form', compact('form'));
    }

    public function submit(Request $request, string $slug): RedirectResponse
    {
        $form = Form::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $fields = data_get($form->schema, 'fields', []);
        $rules = [];

        foreach ($fields as $field) {
            if (!is_array($field)) {
                continue;
            }

            $name = $field['name'] ?? null;
            if (!$name) {
                continue;
            }

            $type = $field['type'] ?? 'text';
            $required = !empty($field['required']);
            $options = is_array($field['options'] ?? null) ? array_values($field['options']) : [];

            switch ($type) {
                case 'email':
                    $rules[$name] = array_filter([
                        $required ? 'required' : 'nullable',
                        'string',
                        'email',
                    ]);
                    break;

                case 'number':
                    $rules[$name] = array_filter([
                        $required ? 'required' : 'nullable',
                        'numeric',
                    ]);
                    break;

                case 'date':
                    $rules[$name] = array_filter([
                        $required ? 'required' : 'nullable',
                        'date',
                    ]);
                    break;

                case 'textarea':
                case 'text':
                    $rules[$name] = array_filter([
                        $required ? 'required' : 'nullable',
                        'string',
                    ]);
                    break;

                case 'select':
                case 'radio':
                    $baseRules = [$required ? 'required' : 'nullable', 'string'];
                    if (!empty($options)) {
                        $baseRules[] = Rule::in($options);
                    }
                    $rules[$name] = array_filter($baseRules);
                    break;

                case 'checkbox':
                    if (!empty($options)) {
                        $checkboxRules = [$required ? 'required' : 'nullable', 'array'];
                        if ($required) {
                            $checkboxRules[] = 'min:1';
                        }
                        $rules[$name] = array_filter($checkboxRules);
                        $rules["{$name}.*"] = [Rule::in($options)];
                    } else {
                        $rules[$name] = [$required ? 'accepted' : 'nullable'];
                    }
                    break;

                default:
                    $rules[$name] = array_filter([
                        $required ? 'required' : 'nullable',
                        'string',
                    ]);
                    break;
            }
        }

        $validated = $request->validate($rules);

        Submission::create([
            'form_id' => $form->id,
            'data' => $validated,
            'ip_address' => $request->ip(),
        ]);

        return redirect("/f/{$slug}/thank-you");
    }

    public function thankYou(string $slug): View
    {
        $form = Form::where('slug', $slug)->firstOrFail();

        return view('public.thank-you', compact('form'));
    }
}
