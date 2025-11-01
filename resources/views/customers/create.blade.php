@extends('layouts.admin')

@section('content-header', 'Create Customer (removed)')
@section('content')
    <div class="card">
        <div class="card-body">
            <p class="text-muted">Customer creation has been removed. Use the POS cart to enter a customer name during checkout.</p>
            <a href="{{ route('home') }}" class="btn btn-primary">Back to dashboard</a>
        </div>
    </div>
@endsection
