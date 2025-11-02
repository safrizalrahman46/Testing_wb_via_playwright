@extends('layouts.app')

@section('content')
    <div class="card p-4">
        <div class="d-flex flex-column align-items-center text-center">
            {{-- Menampilkan foto profil dengan gambar default jika tidak ada foto --}}
            <img src="{{ Storage::url(auth()->user()->photo_path ?? 'public/default-avatar.jpg') }}" alt="Avatar"
                class="rounded-circle mb-3 shadow-sm" style="width: 150px; height: 150px; object-fit: cover;">
            <h5 class="mb-1">{{ auth()->user()->name }}</h5>
            <p class="text-muted">{{ ucfirst(auth()->user()->role_name) }} | {{ auth()->user()->email }}</p>
            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-pencil me-1"></i> Edit Profile
                </a>
                <a href="{{ route('profile.change-password') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-lock me-1"></i> Change Password
                </a>
            </div>
        </div>
    </div>

    <div class="card mt-4 p-4">
        <h6 class="mb-3 fw-bold">Profile Information</h6>
        <div class="row mb-2">
            <div class="col-md-6">
                <strong>Full Name:</strong>
                <p>{{ auth()->user()->name }}</p>
            </div>
            <div class="col-md-6">
                <strong>Email:</strong>
                <p>{{ auth()->user()->email }}</p>
            </div>
            <div class="col-md-6">
                <strong>Role:</strong>
                <p>{{ ucfirst(auth()->user()->role_name) }}</p>
            </div>
            <div class="col-md-6">
                <strong>Joined:</strong>
                <p>{{ auth()->user()->created_at->format('F Y') }}</p>
            </div>
        </div>
    </div>
@endsection
