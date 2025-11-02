<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToeicRegistration;
use Carbon\Carbon;

class ToeicRegistrationController extends Controller
{

    public function index()
    {
        $registrations = ToeicRegistration::orderBy('registration_date', 'desc')->get();
        return view('toeic_registration.index', compact('registrations'));
    }

    public function create()
    {
        return view('toeic_registration.create');
    }

 public function store(Request $request)
{
    $validated = $request->validate([
        'nim' => 'required|string|max:20',
        'registration_date' => 'required|date',
    ]);

    $registration = ToeicRegistration::create([
        'nim' => $validated['nim'],
        'registration_date' => $validated['registration_date'],
        'status' => 'pending',
        'is_second_registration' => false,
    ]);

    return redirect()->route('toeic-registration.success', $registration->id);
}

    public function success($id)
    {
        $registration = ToeicRegistration::findOrFail($id);
        return view('toeic_registration.success', compact('registration'));
    }
}
