<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Pastikan ini ada jika menggunakan model User

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile');
    }

    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'origin_address' => 'nullable|string',
            'current_address' => 'nullable|string',
            'photo' => 'nullable|image|max:2048', // Validasi foto
        ]);

        // Menyimpan foto jika ada yang diupload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('public/photos'); // Menyimpan file foto di folder 'ktps'
            $user->photo_path = $photo; // Menyimpan path foto ke kolom photo_path
        }

        // Mengupdate data pengguna yang lain
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->origin_address = $request->origin_address;
        $user->current_address = $request->current_address;
        
        // Menyimpan perubahan data pengguna
        $user->save();

        // Mengarahkan pengguna ke halaman profile dengan pesan sukses
        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }

    public function editPassword()
    {
        return view('profile.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        // Mengecek apakah password yang dimasukkan benar
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Incorrect current password']);
        }

        $user = Auth::user();
        $user->password = Hash::make($request->new_password); // Enkripsi password baru
        $user->save(); // Simpan password baru

        return redirect()->route('profile.show')->with('success', 'Password changed successfully.');
    }
}
