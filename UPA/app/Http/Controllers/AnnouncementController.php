<?php
namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->get();
        return view('announcement.index', compact('announcements'));
    }

    public function create()
    {
        return view('announcement.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user

        // Validate incoming request
        $validated = $request->validate([
            'title' => 'required|max:100',
            'content' => 'required',
            'type' => 'required|in:test_schedule,test_result,certificate,general',
            'target_audience' => 'required|in:student,admin,all',
            'event_date' => 'nullable|date',
            'pickup_certificate' => 'nullable|date',
            'annopath' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image upload
        ]);

        // Handle file uploads (annopath) - If the file exists, store it, else keep it null
        $annopath = $request->file('annopath') ? $request->file('annopath')->store('public/annopaths') : null;

        // Create the announcement and associate the user who created it
        $announcement = new Announcement($validated);
        $announcement->created_by = $user->id;  // Automatically set the user who created the announcement
        $announcement->annopath = $annopath;    // Store the file path for the image

        // Save the announcement
        $announcement->save();

        return redirect()->route('announcement.index')->with('success', 'Announcement created successfully.');
    }




    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('announcement.edit', compact('announcement'));
    }

    public function update(Request $request, $id)
    {
        // Validate incoming request
        $request->validate([
            'title' => 'required|max:100',
            'content' => 'required',
            'type' => 'required|in:test_schedule,test_result,certificate,general',
            'target_audience' => 'required|in:student,admin,all',
            'event_date' => 'nullable|date',
            'pickup_certificate' => 'nullable|date',
            'annopath' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image upload
        ]);

        // Find the announcement
        $announcement = Announcement::findOrFail($id);

        // Handle the image upload (annopath)
        if ($request->hasFile('annopath')) {
            // Delete the old image if it exists
            if ($announcement->annopath) {
                Storage::disk('public')->delete($announcement->annopath);
            }

            // Store the new image
            $announcement->annopath = $request->file('annopath')->store('announcement_images', 'public/annopaths');
        }

        // Update the announcement with new data
        $announcement->update($request->all());

        return redirect()->route('announcement.index')->with('success', 'Announcement updated successfully.');
    }

    public function destroy($id)
    {
        // Find and delete the announcement
        $announcement = Announcement::findOrFail($id);

        // Delete the associated image if it exists
        if ($announcement->annopath) {
            Storage::disk('public')->delete($announcement->annopath);
        }

        $announcement->delete();
        return back()->with('success', 'Announcement deleted.');
    }


    public function show($id)
{
    $announcement = \App\Models\Announcement::findOrFail($id);

    return view('announcement.show', compact('announcement'));
}
}
