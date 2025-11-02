@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-3">{{ $announcement->title }}</h3>
    <p class="text-muted">{{ $announcement->created_at->diffForHumans() }}</p>
    <div>{{ $announcement->content }}</div>
</div>
@endsection
