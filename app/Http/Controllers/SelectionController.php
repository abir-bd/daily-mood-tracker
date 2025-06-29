<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\Selection;

class SelectionController extends Controller
{
    public function submitForm(Request $request)
    {
        // Validate the input
        $request->validate([
            'mood' => 'required|string',
            'date' => 'required|date',
        ]);

        // Store the data in the database
        Selection::create([
            'selection' => $request->input('mood'),
            'date' => $request->input('date'),
        ]);

        // Redirect with a success message
        return redirect()->back()->with('success', 'Your selection has been submitted!');
    }
}
