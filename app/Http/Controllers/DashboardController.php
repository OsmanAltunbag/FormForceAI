<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $forms = Form::where('user_id', auth()->id())
            ->withCount('submissions')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalSubmissions = $forms->sum('submissions_count');

        return view('dashboard.index', compact('forms', 'totalSubmissions'));
    }
}
