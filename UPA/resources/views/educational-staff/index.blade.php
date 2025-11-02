@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Educational Staff</h4>
    <a href="{{ route('educational-staff.create') }}" class="btn btn-success">+ Add Staff</a>
</div>

<div class="table-responsive">
    <table class="table table-bordered bg-white shadow-sm">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Name</th>
                <th>Email</th>
                <th>NIK</th>
                <th>Origin Address</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($staffs as $index => $staff)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $staff->username }}</td>
                <td>{{ $staff->name }}</td>
                <td>{{ $staff->email }}</td>
                <td>{{ $staff->nik }}</td>
                <td>{{ $staff->origin_address }}</td>
                  {{--  <td>{{ $staff->current_address }}</td>  --}}

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
