<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Models\m_user;
use App\Models\StudyProgram;
use App\Models\Major;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EducationalStaffController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role_name === 'educational_staff') {
            // Hanya melihat datanya sendiri berdasarkan username
            $staffs = \App\Models\User::where('role_name', 'educational_staff')
                ->where('username', $user->username)
                ->get();
        } else {
            // Admin melihat semua staff
            $staffs = \App\Models\User::where('role_name', 'educational_staff')->get();
        }

        return view('educational-staff.index', compact('staffs'));
    }
    public function create()
    {
        $programs = StudyProgram::all();
        $majors = Major::all();
        return view('educational-staff.create', compact('programs', 'majors'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'photo_path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'id_card_path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan file
        $photoPath = $request->file('photo_path')->store('photos', 'public');
        $idCardPath = $request->file('id_card_path')->store('id_cards', 'public');

        // Simpan data ke database
        $staff = new User();
        $staff->role_name = 'educational_staff';
        $staff->photo_path = $photoPath;
        $staff->id_card_path = $idCardPath;
        $staff->save();

        return redirect()->route('educational-staff.payment', ['id' => $staff->id]);
    }


    public function payment($id)
    {
        $staff = User::findOrFail($id);

        return view('educational-staff.payment', compact('staff'));
    }


    public function show($id)
    {
        $staff = m_user::with(['studyProgram', 'major'])
            ->where('role_name', 'educational_staff')
            ->findOrFail($id);
        return view('educational-staff.show', compact('staff'));
    }

    public function edit($id)
    {
        $staff = m_user::findOrFail($id);
        $programs = StudyProgram::all();
        $majors = Major::all();
        return view('educational-staff.edit', compact('staff', 'programs', 'majors'));
    }

    public function update(Request $request, $id)
    {
        $staff = m_user::findOrFail($id);
        $request->validate([
            'email' => 'required|email|unique:user,email,' . $id,
            'name' => 'required',
            'phone' => 'required',
            'origin_address' => 'required',
            'current_address' => 'required',
        ]);

        $staff->update($request->only([
            'email',
            'name',
            'phone',
            'origin_address',
            'current_address',
            'study_program_id',
            'major_id',
            'campus'
        ]));

        return redirect()->route('educational-staff.index')->with('success', 'Educational Staff updated.');
    }

    public function destroy($id)
    {
        $staff = m_user::findOrFail($id);
        $staff->delete();

        return redirect()->route('educational-staff.index')->with('success', 'Educational Staff deleted.');
    }
}
