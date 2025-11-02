<?php

namespace App\Http\Controllers;

use App\Models\ToeicRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class AdminRegistrationController extends Controller
{
    public function index()
    {
        $registrations = ToeicRegistration::orderBy('registration_date', 'desc')->get();
        return view('adminRegist.index', compact('registrations'));
    }

    public function edit($id)
    {
        // Ambil data pendaftaran TOEIC
        $registration = ToeicRegistration::findOrFail($id);

        // Ambil semua pengguna (atau filter sesuai kriteria) untuk dipilih
        $users = User::where('role_name', 'student')->get();

        return view('adminRegist.edit', compact('registration', 'users'));
    }

    public function update(Request $request, $id)
    {
        // Validation logic
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,cancelled',
            // other validation rules
        ]);

        // Find the registration
        $registration = ToeicRegistration::findOrFail($id);

        // Automatically set the user_ref_id to the authenticated user's ID
        $registration->user_ref_id = auth()->user()->id;

        // Update the status
        $registration->status = $request->status;
        $registration->save();

        // Redirect back to the registration list
        return redirect()->route('adminRegist.index')->with('success', 'Status updated successfully.');
    }


    // Metode lain (show, destroy, dsb) tetap sama
    public function destroy($id)
    {
        $registration = ToeicRegistration::findOrFail($id);
        $registration->delete();

        return response()->json(['success' => 'Registration deleted successfully.']);
    }

}
