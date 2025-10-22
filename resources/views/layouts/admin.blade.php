<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', config('app.name'))</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @yield('css')

    <script>
        window.APP = @json([
            'currency_symbol' => config('settings.currency_symbol'),
            'warning_quantity' => config('settings.warning_quantity'),
        ]);
    </script>

    <style>
        html, body {
            height: 100%;
            margin: 0;
            background: #f8f9fc;
            font-family: 'Source Sans Pro', sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        /* Layout utama */
        .layout {
            display: flex;
            height: 100vh;
            width: 100%;
            overflow: hidden;
            margin: 0;
            padding: 0;
        }

        /* Sidebar kiri */
        .sidebar {
            width: 220px;
            min-width: 220px;
            max-width: 220px;
            background: #6c2eb7;
            border-right: none;
            box-shadow: none;
            margin: 0;
            padding: 0;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 1000;
            /* Perbaikan CSS sebelumnya dipindahkan ke sini untuk kerapihan */
            color: #fff;
            display: flex;
            flex-direction: column;
        }

        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            margin-left: 220px;
        }

        .navbar {
            background: linear-gradient(90deg, #6c2eb7, #8a3cff);
            color: #fff;
            padding: 0.8rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 60px;
            flex-shrink: 0;
            position: fixed;
            width: calc(100% - 220px);
            top: 0;
            right: 0;
            z-index: 999;
        }

        .navbar h1, .navbar a {
            color: #fff !important;
        }

        .content-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 1rem;
            background: #f8f9fc;
            min-height: 0;
            margin-top: 60px;
            width: 100%;
            overflow-y: auto;
            align-items: center; /* center inner content horizontally */
        }

        /* Inner content wrapper to center layout and constrain width */
        .content-inner {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 0.5rem; /* small side padding to avoid touching edges */
        }

        /* Card styling */
        /* Dashboard cards container */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 1200px) {
            .dashboard-cards { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .dashboard-cards { grid-template-columns: repeat(1, 1fr); }
        }

        .card {
            border-radius: 8px;
            border: none;
            box-shadow: 0 2px 4px rgba(108,46,183,0.05);
            height: fit-content;
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #f0f0f0;
            padding: 1rem 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Table styling */
        .table {
            margin-bottom: 0;
        }

        .table th {
            border-top: none;
            background: #f8f9fc;
            font-weight: 600;
            padding: 0.6rem 0.8rem;
        }

        .table td {
            padding: 0.45rem 0.8rem;
            vertical-align: middle;
            white-space: normal;
            word-break: break-word;
        }

        /* Table container: allow horizontal scroll only if content truly overflows */
        .table-responsive {
            overflow-x: auto;
        }

        /* Button styling */
        .btn {
            padding: 0.5rem 1rem;
            font-weight: 600;
            border-radius: 6px;
        }

        .btn-primary {
            background: #6c2eb7;
            border-color: #6c2eb7;
        }

        .btn-primary:hover {
            background: #5b28a0;
            border-color: #5b28a0;
        }

        /* Scrollbar halus */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(0,0,0,0.15);
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="layout">
        {{-- Sidebar --}}
        @include('layouts.partials.sidebar')

        {{-- Wrapper kanan --}}
        <div class="main-wrapper">
            {{-- Navbar --}}
            @include('layouts.partials.navbar')

            {{-- Konten utama --}}
            <div class="content-area">
                {{-- Page header removed - navbar already shows the page title --}}

                <div class="content-inner">
                    @include('layouts.partials.alert.success')
                    @include('layouts.partials.alert.error')
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    @yield('js')
    @yield('model')
</body>
</html>