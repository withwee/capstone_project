@extends('layouts.admin')

@section('title', __('customer.Update_Customer'))
@section('content-header', __('customer.Update_Customer'))

@section('content')

    <div class="card">
        <div class="card-body">

    <div class="card">
        <div class="card-body">
            <p class="text-muted">Customer edit has been removed. Use the POS cart to enter a customer name during checkout.</p>
            <a href="{{ route('home') }}" class="btn btn-primary">Back to dashboard</a>
        </div>
    </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            bsCustomFileInput.init();
        });
    </script>
@endsection
