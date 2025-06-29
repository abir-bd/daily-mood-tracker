<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\Selection;
use Auth;
use Carbon\Carbon;

class SelectionController extends Controller
{
    public function submitForm(Request $request)
    {
        $today = Carbon::today();


        $existingSubmission = Selection::where('post_id', Auth::user()->id)
                                       ->whereDate('created_at', $today)
                                       ->first(); // Look for submissions on the same day

         if ($existingSubmission) {
            // If a submission exists, prevent the user from submitting and show an error message
            return back()->with('error', 'You have already submitted today.');
        }

        // Validate the input
        $request->validate([
            'mood' => 'required|string',
            'date' => 'required|date',
            'post_id' => 'required|integer',
        ]);

        // Store the data in the database
        Selection::create([
            'selection' => $request->input('mood'),
            'date' => $request->input('date'),
            'post_id' => $request->input('post_id'),
        ]);

        // Redirect with a success message
        return redirect()->back()->with('success', 'Your selection has been submitted!');
    }




    public function viewSelections()
    {

         // Get the start and end dates for the last 4 weeks
    $startDate = Carbon::now()->subWeeks(4)->startOfWeek(); // 4 weeks ago
    $endDate = Carbon::now()->endOfWeek(); // This week
        
        // Fetch all selections from the database
        $selections = Selection::where('post_id', Auth::user()->id)->orderBy('created_at', 'desc')->get(); // Retrieve all rows from the 'selections' table

        // Pass the data to the view
        return view('home', compact('selections'));

      // Get weekly mood counts (Happy, Sad, Angry)
        $weeklyMoods = Selection::selectRaw('YEARWEEK(created_at) as week, 
                                        selection, 
                                        count(*) as count')
                            ->where('post_id', Auth::id())
                            ->whereBetween('created_at', [$startDate, $endDate]) // Filter data by date range
                            ->groupBy('week', 'selection') // Group by week and mood type
                            ->orderBy('week', 'desc') // Order by the most recent week
                            ->get();

         // Format the data for the chart
    $moodData = [
        'labels' => [],
        'happy' => [],
        'sad' => [],
        'angry' => [],
    ];
     // Populate the mood data for each week
    foreach ($weeklyMoods as $mood) {
        $weekLabel = Carbon::now()->setISODate($mood->year, $mood->week)->format('Y-W');
        if (!in_array($weekLabel, $moodData['labels'])) {
            $moodData['labels'][] = $weekLabel;
        }

        if ($mood->selection == 'happy') {
            $moodData['happy'][] = $mood->count;
        } elseif ($mood->selection == 'sad') {
            $moodData['sad'][] = $mood->count;
        } elseif ($mood->selection == 'angry') {
            $moodData['angry'][] = $mood->count;
        }
    }

    // Return the data to the view
    return view('home', compact('moodData'));
    }


    // edit data

    public function edit($id)
    {
        // Find the selection by ID
         // Find the submission by ID and ensure it belongs to the authenticated user
        $selection = Selection::where('id', $id)
                              ->where('post_id', Auth::user()->id)  // Ensure it's the user's post
                              ->firstOrFail();

        // Return the edit view with the existing submission data
        return view('edit', compact('selection'));
    }


 // Method to handle the form submission (store or update)
   public function update(Request $request, $id)
{
    // Validate the incoming data
    $request->validate([
        'mood' => 'required|string|max:255',
        'date' => 'required|date',
    ]);

    // Find the selection by ID and ensure it belongs to the authenticated user
    $selection = Selection::where('id', $id)
                          ->where('post_id', Auth::user()->id)  // Ensure it's the user's post
                          ->firstOrFail();

    // Update the fields with the new data
    $selection->selection = $request->input('mood');
    $selection->date = $request->input('date');
    $selection->save(); // Save the updated data

    // Redirect with a success message
    return redirect()->route('view.selections')->with('success', 'Your submission has been updated.');
}


// delete

public function destroy($id)
{
    // Find the selection by ID and ensure it belongs to the authenticated user
    $selection = Selection::where('id', $id)
                          ->where('post_id', Auth::user()->id) // Ensure it's the user's post
                          ->firstOrFail();  // If not found, it will return a 404

    // Delete the selection
    $selection->delete();

    // Redirect with a success message
    return redirect()->route('view.selections')->with('success', 'Selection has been deleted successfully.');
}


}
