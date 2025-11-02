@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">TOEIC Registration List</h3>
            <a href="{{ route('adminRegist.create') }}" class="btn btn-success">
                + Add Registration
            </a>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Status</th>
                    <th>Registration Date</th>
                    <th>Score</th>
                    <th>Certificate</th>
                    <th>Action</th> <!-- Added Action Column -->
                </tr>
            </thead>
            <tbody>
                @foreach ($registrations as $reg)
                    <tr>
                        <td>{{ $reg->nim }}</td>
                        <td>{{ ucfirst($reg->status) }}</td>
                        <td>{{ $reg->registration_date }}</td>
                        <td>{{ $reg->score ?? '-' }}</td>
                        <td>
                            @if ($reg->certificate_path)
                                <a href="{{ asset('storage/' . $reg->certificate_path) }}" target="_blank">Lihat</a>
                            @else
                                Belum Ada
                            @endif
                        </td>
                        <td> <!-- Action Column with Buttons -->
                            <form action="{{ route('adminRegist.update', $reg->id) }}" method="POST">
                                @csrf
                                @method('PUT') <!-- Use PUT method instead of PATCH -->
                                <div class="btn-group">
                                    <button type="submit" name="status" value="approved" class="btn btn-success">Approve</button>
                                    <button type="submit" name="status" value="rejected" class="btn btn-danger">Reject</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
