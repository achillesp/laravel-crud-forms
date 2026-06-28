@if (count($errors) > 0)
    <div id="validationErrors" class="mb-6 rounded-md border border-red-300 bg-red-50 p-4 text-sm text-red-800">
        <p class="font-semibold">Form submit failed. Errors found:</p>
        <ul class="mt-2 list-inside list-disc space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
