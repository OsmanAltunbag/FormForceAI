<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\View\View;

class SubmissionController extends Controller
{
    public function index(Form $form): View
    {
        if ($form->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $submissions = $form->submissions()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('submissions.index', compact('form', 'submissions'));
    }
}
