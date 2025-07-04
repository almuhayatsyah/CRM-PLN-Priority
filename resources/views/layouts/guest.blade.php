<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CRM PLN UID ACEH') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            font-family: 'Figtree', sans-serif;
            background-color: #ffffff;
        }

        .login-page-container {
            min-height: 100vh;
            display: flex;
            align-items: stretch;
            justify-content: center;
            padding: 0;
        }

        .login-split-card {
            display: flex;
            width: 100%;
            height: 100vh;
            background-color: white;
        }

        .left-panel {
            flex: 1;
            background-color: #ffffff;
            /* Background abu muda */
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            /* agar form di tengah horizontal */
            text-align: left;
            box-shadow: rgba(0, 0, 0, 0.05) 2px 2px 8px;
            border-radius: 16px 0 0 16px;
            /* Rounded kiri atas & bawah */
        }

        .right-panel {
            flex: 1;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }

        .right-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 0;
        }

        .right-panel span {
            position: relative;
            z-index: 1;
            padding: 10px 20px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 5px;
            color: rgb(255, 255, 255);
            font-weight: bold;
            font-size: 1.5rem;
        }

        @media (max-width: 768px) {
            .login-split-card {
                flex-direction: column;
                height: auto;
            }

            .left-panel {
                border-radius: 0;
                padding: 2rem 1.5rem;
            }

            .right-panel {
                min-height: 200px;
                border-radius: 0 0 16px 16px;
            }
        }
    </style>
</head>

<body>
    <div class="login-page-container">
        <div class="login-split-card">
            {{-- Panel Kiri (Form Login) --}}
            <div class="left-panel">
                {{ $slot }}
            </div>

            {{-- Panel Kanan (Gambar) --}}
            @php
            $bgImage = asset('images/foto_pln.png');
            @endphp

            <div class="right-panel" style="background-image: url('{{ $bgImage }}');"></div>
        </div>
    </div>
</body>

</html>