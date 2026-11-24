<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <style>
        body { font-family: system-ui, sans-serif; margin: 0; color: #1f2328; background: #fafafa; }
        main { max-width: 40rem; margin: 4rem auto; padding: 0 1rem; line-height: 1.6; }
        .muted { color: #6e7781; font-size: 0.875rem; }
        @media (prefers-color-scheme: dark) {
            body { color: #e6edf3; background: #0d1117; }
            a { color: #58a6ff; }
            .muted { color: #8b949e; }
        }
    </style>
</head>
<body>
    <main>
        <h1>Laravel starter</h1>
        <p>Laravel {{ app()->version() }} on PHP {{ PHP_VERSION }}, deployed on <a href="https://containify.net">Containify</a>.</p>
        <p>This page has been visited <strong>{{ $visits }}</strong> {{ $visits === 1 ? 'time' : 'times' }}.</p>
        <p class="muted">{{ $database }}</p>
        <p>Edit <code>resources/views/home.blade.php</code> and push to deploy.</p>
    </main>
</body>
</html>
