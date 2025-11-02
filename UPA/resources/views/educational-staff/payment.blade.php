@extends('layouts.app')

@section('content')
<div class="text-center mt-5">
    <h4>Thank you, {{ $staff->name }}!</h4>
    <p>Your photo and ID have been successfully uploaded.</p>
    <a href="https://example.com/payment-link" class="btn btn-success" target="_blank">
        Proceed to Payment
    </a>
</div>
@endsection
