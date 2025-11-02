@extends('layouts.app')

@section('content')
<div class="container">
    <h3>TOEIC Re-Registration (Paid)</h3>
    <form action="{{ route('toeic-registration.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nim" class="form-label">NIM ID</label>
            <input type="text" class="form-control" id="nim" name="nim" required>
        </div>

        <div class="mb-3">
            <label for="registration_date" class="form-label">Registration Date</label>
            <input type="date" class="form-control" id="registration_date" name="registration_date" required>
        </div>

        <button type="submit" class="btn btn-success">Register & Get Payment Link</button>
    </form>
</div>
@endsection
