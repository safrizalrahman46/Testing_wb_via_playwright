<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ToeicRegistration;

class FreeRegistController extends Controller
{
    // Show the index page if registration exists, or redirect to create if not
    public function index()
    {
        // Ensure the user is authenticated
        if (Auth::check()) {
            $user = Auth::user(); // Get the authenticated user

            // Ensure nim exists for the user
            if (isset($user->nim)) {
                $nim = $user->nim;

                // Check if the user has a registration in the ToeicRegistration table
                $registration = ToeicRegistration::where('nim', $nim)->first();

                if ($registration) {
                    // If registration exists, show the index page with the user's registration details
                    return view('freeregist.index', compact('registration', 'nim'));
                } else {
                    // If no registration exists, redirect to the create page to fill out the form
                    return redirect()->route('freeRegist.create')->with('message', 'Please complete your registration.');
                }
            } else {
                // Handle the case where nim is not set for the authenticated user
                return redirect()->route('login')->with('error', 'User does not have a valid NIM.');
            }
        } else {
            // Redirect to login page if the user is not authenticated
            return redirect()->route('login');
        }
    }

    public function showKtp($id)
    {
        // Mencari data pendaftaran berdasarkan ID
        $registration = ToeicRegistration::findOrFail($id);

        // Mengembalikan hanya konten KTP untuk dimuat secara dinamis di dalam modal
        return view('partials.ktp', compact('registration'));
    }

    // Show the create registration form
    public function create()
    {
        $user = Auth::user();
        $nim = $user->nim;

        // Cek apakah pengguna sudah terdaftar sebelumnya
        $existingRegistration = ToeicRegistration::where('nim', $nim)->first();

        return view('freeRegist.create', compact('existingRegistration'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $nim = $user->nim;

        // Validasi input
        $validated = $request->validate([
            'status' => 'nullable|in:pending,approved,rejected,cancelled', // status bisa null, atau salah satu nilai yang ada
            'certificate_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:1024',
            'ktp_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:1024',
        ]);

        // Mengatur nilai status default jika tidak ada
        $status = $validated['status'] ?? 'pending';  // Jika tidak ada status yang dikirim, maka default 'pending'

        // Handle file uploads
        $ktp_path = $request->file('ktp_path') ? $request->file('ktp_path')->store('public/ktps') : null;

        // Cek apakah pengguna sudah terdaftar
        $existingRegistration = ToeicRegistration::where('nim', $nim)->first();

        if ($existingRegistration) {
            // Update pendaftaran yang ada
            $existingRegistration->status = $status; // Menggunakan status yang telah diatur
            $existingRegistration->registration_date = now();

            if ($ktp_path) {
                $existingRegistration->ktp_path = $ktp_path;
            }

            $existingRegistration->save();

            // Redirect setelah berhasil memperbarui pendaftaran
            return redirect()->route('freeRegist.index')->with('success', 'Pendaftaran berhasil diperbarui!');
        } else {
            // Pendaftaran baru
            ToeicRegistration::create([
                'nim' => $nim,
                'status' => $status, // Menggunakan status yang telah diatur
                'registration_date' => now(),
                'ktp_path' => $ktp_path,
            ]);

            // Redirect setelah berhasil menyimpan pendaftaran
            return redirect()->route('freeRegist.index')->with('success', 'Pendaftaran berhasil!');
        }
    }

    public function show($id)
    {
        $registration = ToeicRegistration::find($id);
        if (!$registration) {
            return redirect()->route('freeRegist.index')->with('error', 'Pendaftaran tidak ditemukan');
        }

        return view('freeRegist.show', compact('registration'));
    }
    
    // Method untuk memproses pendaftaran kedua kalinya
    public function createSecondRegistration(Request $request, $id)
    {
        // Mencari data pendaftaran berdasarkan ID
        $registration = ToeicRegistration::find($id);

        if (!$registration) {
            return redirect()->route('freeRegist.index')->with('error', 'Pendaftaran tidak ditemukan');
        }

        // Cek jika pendaftaran kedua sudah dilakukan
        if ($registration->is_second_registration) {
            return redirect()->route('freeRegist.index')->with('message', 'Anda sudah terdaftar kedua kalinya');
        }

        // Memperbarui status pendaftaran kedua
        $registration->is_second_registration = true;
        $registration->save();

        return redirect()->route('freeRegist.index')->with('success', 'Pendaftaran kedua berhasil');
    }

    // Show the edit registration form
    public function edit($id)
    {
        // Ensure the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();
            $nim = $user->nim;

            // Check if the registration exists for the given ID and user NIM
            $registration = ToeicRegistration::where('id', $id)->where('nim', $nim)->first();

            if ($registration) {
                // Show the edit form with the current registration data
                return view('freeregist.edit', compact('registration'));
            } else {
                // Redirect if registration does not exist
                return redirect()->route('freeRegist.index')->with('error', 'Registration not found.');
            }
        } else {
            // Redirect to login page if the user is not authenticated
            return redirect()->route('login');
        }
    }

    // Update the registration data
    public function update(Request $request, $id)
    {
        // Ensure the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();
            $nim = $user->nim;

            // Validate the input
            $validated = $request->validate([
                'status' => 'nullable|in:pending,approved,rejected,cancelled',
                'certificate_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:1024',
                'ktp_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:1024',
            ]);

            // Find the existing registration
            $registration = ToeicRegistration::where('id', $id)->where('nim', $nim)->first();

            if ($registration) {

                $status = $validated['status'] ?? 'pending';

                // Handle file uploads
                // $certificate_path = $request->file('certificate_path') ? $request->file('certificate_path')->store('certificates') : $registration->certificate_path;
                $ktp_path = $request->file('ktp_path') ? $request->file('ktp_path')->store('public/ktps') : $registration->ktp_path;

                // Update the registration with the new data
                $registration->status = $status;
                // $registration->certificate_path = $certificate_path;
                $registration->ktp_path = $ktp_path;
                $registration->registration_date = now();
                $registration->save();

                // Redirect after successfully updating the registration
                return redirect()->route('freeRegist.index')->with('success', 'Registration updated successfully!');
            } else {
                // Redirect if registration does not exist
                return redirect()->route('freeRegist.index')->with('error', 'Registration not found.');
            }
        } else {
            // Redirect to login page if the user is not authenticated
            return redirect()->route('login');
        }
    }
}
