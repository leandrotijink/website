<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->currentLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1"/>
    <link href="https://fonts.googleapis.com/css?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet" type="text/css"/>

    <title>{{ config('registry.about.name') }}</title>

    <x-mailable.layout.styling/>
</head>
<body style="background: #F2F2F2;">
    <span style="display: none; height: 0; font-size: 0">
        {{ $summary }}
    </span>

    <div class="container">

        <img src="{{ Storage::url('interface/branding/256x256.png') }}" alt="{{ __('Logo') }}">

        <div class="card">
            {{ $slot }}
        </div>
    
        <div class="footer">
            <p>
                <a href="{{ route('public.legal.terms-of-service') }}" target="_blank" rel="noreferrer">{{ __('Terms of Service') }}</a>
                •
                <a href="{{ route('public.legal.privacy-policy') }}" target="_blank" rel="noreferrer">{{ __('Privacy Policy') }}</a>
            </p>
        </div>
    </div>
</body>
</html>