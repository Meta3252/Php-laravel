@extends('layouts.app')

@section('title', 'TEMPLE BY REGION')

@push('head')
    <link rel="stylesheet" href="{{ asset('css/UxTester.css') }}">
@endpush

@section('content')
    <div class="container">
        <div class="header-container">
            <h1 class="main-title">TEMPLE BY REGION</h1>
            <p class="sub-title">ค้นหาข้อมูลวัดตามภูมิภาค</p>

            <div class="controls">
                <label>
                    จำนวนคอลัมน์:
                    <select id="columnsSelect">
                        <option value="2">2</option>
                        <option value="3" selected>3</option>
                        <option value="4">4</option>
                    </select>
                </label>
                <label>
                    <input type="checkbox" id="autoPlayToggle" />
                    Auto Play
                </label>
            </div>

            <div class="wat" id="imageContainer"></div>
            <div class="bullet-container" id="bulletContainer"></div>
        </div>
    </div>

    <script>
        window.appData = {
            images: @json($images),
            regionNames: @json($regionNames)
        };
    </script>
@endsection

@push('scripts')
    <script src="{{ asset('js/UxTester.js') }}"></script>
@endpush
