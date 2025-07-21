@extends('layouts.app', ['pageTitle' => 'Settings'])

@section('title', 'Settings')

@push('styles')
    <link href="{{ asset('css/style_settings.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="settings-container">
        <div class="settings-card">
            <h2 class="settings-title">Kustomisasi Tampilan Website</h2>

            <div class="theme-options-grid">
                <div class="theme-option" data-theme="tema1">
                    <div class="theme-preview">
                        <div class="color-box" style="background-color: #78B3CE;"></div>
                        <div class="color-box" style="background-color: #F96E2A;"></div>
                        <div class="color-box" style="background-color: #FBF8EF;"></div>
                        <div class="color-box" style="background-color: #C9E6F0;"></div>
                    </div>
                    <p class="theme-name">Tema 1</p>
                </div>

                <div class="theme-option" data-theme="tema2">
                    <div class="theme-preview">
                        <div class="color-box" style="background-color: #A7C957;"></div>
                        <div class="color-box" style="background-color: #BC6C25;"></div>
                        <div class="color-box" style="background-color: #FEFAE0;"></div>
                        <div class="color-box" style="background-color: #E9F5DB;"></div>
                    </div>
                    <p class="theme-name">Tema 2</p>
                </div>

                <div class="theme-option" data-theme="tema3">
                    <div class="theme-preview">
                        <div class="color-box" style="background-color: #B80C09;"></div>
                        <div class="color-box" style="background-color: #F4A261;"></div>
                        <div class="color-box" style="background-color: #FFF2D8;"></div>
                        <div class="color-box" style="background-color: #FFE5B4;"></div>
                    </div>
                    <p class="theme-name">Tema 3</p>
                </div>

                <div class="theme-option" data-theme="tema4">
                    <div class="theme-preview">
                        <div class="color-box" style="background-color: #14213D;"></div>
                        <div class="color-box" style="background-color: #4A90E2;"></div>
                        <div class="color-box" style="background-color: #221F43;"></div>
                        <div class="color-box" style="background-color: #19133B;"></div>
                    </div>
                    <p class="theme-name">Tema 4</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/settings.js') }}"></script>
@endpush
