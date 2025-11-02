@extends('layouts.app')

@section('content')
<h4>Edit Announcement</h4>

<form action="{{ route('announcement.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @include('announcement.form', ['announcement' => $announcement])

    <!-- File upload field for annopath -->
    <div class="mb-3">
        <label>Announcement Image</label>
        <input type="file" name="annopath" class="form-control" accept="image/*">
    </div>

    @if($announcement->annopath)
        <!-- If there is already a file uploaded, show the link to the existing image -->
        <div class="mb-3">
            <label>Current Image</label>
            <a href="{{ asset('storage/' . $announcement->annopath) }}" target="_blank">View Current Image</a>
        </div>
    @endif

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('announcement.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('type');
    const eventDate = document.getElementById('event_date');
    const pickupCert = document.getElementById('pickup_certificate');

    function toggleFields() {
        const selectedType = typeSelect.value;

        if (selectedType === 'certificate') {
            eventDate.disabled = true;
            pickupCert.disabled = false;
        } else {
            eventDate.disabled = false;
            pickupCert.disabled = true;
        }
    }

    toggleFields();
    typeSelect.addEventListener('change', toggleFields);
});
</script>
@endpush
