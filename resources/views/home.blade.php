@extends('layouts.admin')
@section('content-header', __('dashboard.title'))
@section('content')

<style>
html, body {
    height: 100%;
    overflow: hidden;
}
.content-wrapper {
    height: calc(100vh - 60px);
    overflow-y: auto;
}
</style>


    <!-- Summary Cards -->
    <div class="dashboard-cards">
        <div class="card shadow-sm border-0" style="border-radius:12px; background:#a084e8; color:#fff;">
            <div class="card-body text-center" style="padding:1.25rem;">
                <h2 class="fw-bold" style="font-size:1.75rem;">{{$orders_count}}</h2>
                <p style="margin:0.5rem 0 1rem;">{{ __('dashboard.Orders_Count') }}</p>
                <a href="{{route('orders.index')}}" class="btn btn-light btn-sm" style="color:#6c2eb7; font-weight:600; border-radius:8px; padding:0.4rem 0.8rem;">{{ __('common.More_info') }} <i class="fas fa-arrow-circle-right ml-1"></i></a>
            </div>
        </div>

        <div class="card shadow-sm border-0" style="border-radius:12px; background:#4caf50; color:#fff;">
            <div class="card-body text-center" style="padding:1.25rem;">
                <h2 class="fw-bold">{{config('settings.currency_symbol')}} {{number_format($income, 2)}}</h2>
                <p style="margin:0.5rem 0 1rem;">{{ __('dashboard.Income') }}</p>
                <a href="{{route('orders.index')}}" class="btn btn-light btn-sm" style="color:#4caf50; font-weight:600; border-radius:8px;">{{ __('common.More_info') }} <i class="fas fa-arrow-circle-right ml-1"></i></a>
            </div>
        </div>

        <div class="card shadow-sm border-0" style="border-radius:12px; background:#f44336; color:#fff;">
            <div class="card-body text-center" style="padding:1.25rem;">
                <h2 class="fw-bold">{{config('settings.currency_symbol')}} {{number_format($income_today, 2)}}</h2>
                <p style="margin:0.5rem 0 1rem;">{{ __('dashboard.Income_Today') }}</p>
                <a href="{{route('orders.index')}}" class="btn btn-light btn-sm" style="color:#f44336; font-weight:600; border-radius:8px;">{{ __('common.More_info') }} <i class="fas fa-arrow-circle-right ml-1"></i></a>
            </div>
        </div>

        <div class="card shadow-sm border-0" style="border-radius:12px; background:#ffc107; color:#fff;">
            <div class="card-body text-center" style="padding:1.25rem;">
                <h2 class="fw-bold">{{$customers_count}}</h2>
                <p style="margin:0.5rem 0 1rem;">{{ __('dashboard.Customers_Count') }}</p>
                <a href="{{ route('customers.index') }}" class="btn btn-light btn-sm" style="color:#ffc107; font-weight:600; border-radius:8px;">{{ __('common.More_info') }} <i class="fas fa-arrow-circle-right ml-1"></i></a>
            </div>
        </div>
    </div>

    <!-- Product Tables -->
    <div class="row" style="margin: 0 -0.25rem; flex:1; min-height:0;">
        @php
            $tables = [
                ['title' => 'Low Stock Product', 'data' => $low_stock_products],
                ['title' => 'Hot Products', 'data' => $current_month_products],
                ['title' => 'Hot Products of the Year', 'data' => $past_months_products],
                ['title' => 'Best Selling Products', 'data' => $best_selling_products],
            ];
        @endphp

        @foreach ($tables as $table)
        <div class="col-lg-6" style="margin-bottom:1rem; height:calc(50% - 0.5rem);">
            <div class="card shadow-sm border-0" style="border-radius:12px; height:100%;">
                <div class="card-header bg-white border-0" style="border-top-left-radius:16px; border-top-right-radius:16px;">
                    <h5 class="fw-bold" style="color:#6c2eb7;">{{ $table['title'] }}</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0 table-hover align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Barcode</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Status</th>
                                    <th>Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($table['data'] as $product)
                                    <tr>
                                        <td>{{$product->id}}</td>
                                        <td>{{$product->name}}</td>
                                        <td><img src="{{ Storage::url($product->image) }}" style="width:40px; height:40px; border-radius:6px;"></td>
                                        <td>{{$product->barcode}}</td>
                                        <td>{{config('settings.currency_symbol')}} {{number_format($product->price, 2)}}</td>
                                        <td>{{$product->quantity}}</td>
                                        <td>
                                            <span class="badge badge-{{ $product->status ? 'success' : 'danger' }}">
                                                {{$product->status ? __('common.Active') : __('common.Inactive') }}
                                            </span>
                                        </td>
                                        <td>{{$product->updated_at->format('d M Y')}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-3">No data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

@endsection
