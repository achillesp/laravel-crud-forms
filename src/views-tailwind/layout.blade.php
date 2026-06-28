<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{--
        This bundled layout pulls Tailwind from the Play CDN so the published
        views look styled out of the box. For production, either:
          - set `crud-forms.blade_layout` to your own app layout that loads your
            compiled Tailwind CSS, or
          - publish & edit this layout to reference your built assets.
    --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800 antialiased">
    <div class="mx-auto max-w-5xl px-4 py-10">
        @yield(config('crud-forms.blade_section', 'content'))
    </div>
</body>
</html>
