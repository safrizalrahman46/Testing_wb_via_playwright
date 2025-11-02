<!-- Title Field -->
<div class="mb-3">
    <label for="title">Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
</div>

<!-- Content Field -->
<div class="mb-3">
    <label for="content">Content</label>
    <textarea name="content" class="form-control" rows="5" required>{{ old('content') }}</textarea>
</div>

<!-- Type Field -->
<div class="mb-3">
    <label for="type">Type</label>
    <select name="type" class="form-control" id="type" required>
        @foreach (['test_schedule', 'test_result', 'certificate', 'general'] as $type)
            <option value="{{ $type }}" {{ old('type') === $type ? 'selected' : '' }}>
                {{ ucfirst(str_replace('_', ' ', $type)) }}
            </option>
        @endforeach
    </select>
</div>

<!-- Target Audience Field -->
<div class="mb-3">
    <label for="target_audience">Target Audience</label>
    <select name="target_audience" class="form-control" required>
        @foreach (['student', 'admin', 'all'] as $target)
            <option value="{{ $target }}" {{ old('target_audience') === $target ? 'selected' : '' }}>
                {{ ucfirst($target) }}
            </option>
        @endforeach
    </select>
</div>

<!-- Event Date Field -->
<div class="mb-3">
    <label for="event_date">Event Date</label>
    <input type="date" name="event_date" class="form-control" id="event_date" value="{{ old('event_date') }}">
</div>

<!-- Pickup Certificate Field -->
<div class="mb-3">
    <label for="pickup_certificate">Pickup Certificate</label>
    <input type="date" name="pickup_certificate" class="form-control" id="pickup_certificate"
        value="{{ old('pickup_certificate') }}">
</div>
