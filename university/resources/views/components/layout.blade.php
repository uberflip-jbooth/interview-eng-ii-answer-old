<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="/css/app.css" rel="stylesheet">
        <title>{{ $title ?? 'University Domains List' }}</title>
    </head>
    <body>
        <div class="container mx-auto px-4">
            <h1><img src="uberflip.png" class="w-16 h-16 mr-4 float-left mb-2" alt="Logo" />{{ $title ?? 'University Domains List'}}</h1>
            {{ $slot }}
        </div>
    </body>
</html>