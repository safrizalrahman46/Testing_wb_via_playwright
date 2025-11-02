@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <div class="container mx-auto p-4">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold text-center mb-6">
                @if ($existingRegistration)
                    Perbarui Informasi Pendaftaran
                @else
                    Lengkapi Informasi Pendaftaran
                @endif
            </h2>

            <div class="flex flex-col space-y-4">
                <div class="bg-blue-100 p-4 rounded-lg shadow-md">
                    <div class="flex items-center space-x-2">
                        <img src="https://img.icons8.com/ios/50/000000/edit.png" alt="Edit Icon" class="w-6 h-6">
                        <span class="font-semibold text-lg">Lengkapi Informasi Pendaftaran</span>
                    </div>
                    <p class="mt-2 text-gray-600">Tekan tombol ini untuk melengkapi informasi pendaftaran.</p>

                    <!-- Form untuk Lanjutkan Pendaftaran -->
                    <form action="{{ route('freeRegist.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if ($existingRegistration)
                            <p class="mt-2 text-gray-600">Status pendaftaran Anda saat ini:
                                <strong>{{ $existingRegistration->status }}</strong></p>
                            @if ($existingRegistration->is_second_registration)
                                <p class="mt-2 text-green-600">Anda sudah melakukan pendaftaran kedua.</p>
                            @else
                                <p class="mt-2 text-gray-600">Tekan tombol ini untuk memperbarui informasi pendaftaran.</p>
                                <button type="submit" class="mt-4 inline-block bg-blue-500 text-white py-2 px-4 rounded">Lanjutkan Pendaftaran</button>
                            @endif
                        @else
                            <button type="submit" class="mt-4 inline-block bg-blue-500 text-white py-2 px-4 rounded">Lanjutkan Pendaftaran</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
