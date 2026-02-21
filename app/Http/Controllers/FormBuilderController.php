<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class FormBuilderController extends Controller
{
    public function index(): View
    {
        return view('builder.index');
    }
}
