@extends('layouts.app')
@section('content')
<form action="{{ route('educational-staff.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="photo_path">Foto Diri</label>
        <input type="file" name="photo_path" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="id_card_path">Foto KTP</label>
        <input type="file" name="id_card_path" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection
