{{-- resources/views/educational-staff/confirmation.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Konfirmasi</h2>
    <p>Halo, {{ $user->name }}. Dokumen Anda berhasil diunggah.</p>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('educational-staff.index') }}" class="btn btn-primary">Kembali ke Dashboard</a>
</div>
@endsection
