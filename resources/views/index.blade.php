<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <meta name="description" content="{{ config('app.name', 'Laravel') }}"/>

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>

    @yield('styles')
</head>

<body class="bg-gray-800 text-white">
<div id="app" class="content-center p-1">
    <form action="{{ route('api.matches.reset') }}" method="post" class="text-center mt-5">
        @csrf
        @method('patch')
        <button
                class="bg-red-400 hover:bg-red-500 text-red-700 font-semibold hover:text-white py-1 px-2 border border-red-500 hover:border-transparent rounded"
                type="submit" class="">
            {{ __('Reset') }}
        </button>
    </form>
    <league-table
            :week-count="{{ $weekCount }}"
            :show-prediction-from="{{ $showPredictionFrom }}"
    ></league-table>
</div>

<script src="{{ asset('js/app.js') }}"></script>

@yield('scripts')

</body>

</html>
