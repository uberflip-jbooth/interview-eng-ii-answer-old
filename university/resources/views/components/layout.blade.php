<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title ?? 'University Domains List' }}</title>

    </head>
    <body>
        <h1>{{ $title ?? 'University Domains List'}}</h1>
        <hr />
        {{ $slot }}
    </body>
</html>