<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\RedirectResponse;

class FormController extends Controller
{
    /**
     * Soft delete a form (verify ownership first).
     */
    public function destroy(Form $form): RedirectResponse
    {
        // Verify the form belongs to the authenticated user
        if ($form->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $form->delete();

        return redirect()->back()->with('success', 'Form deleted successfully.');
    }

    /**
     * Toggle the is_active status of a form.
     */
    public function toggle(Form $form): RedirectResponse
    {
        // Verify the form belongs to the authenticated user
        if ($form->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $form->is_active = !$form->is_active;
        $form->save();

        $status = $form->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()->with('success', "Form {$status} successfully.");
    }
}
