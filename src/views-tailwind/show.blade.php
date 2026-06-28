@extends( $bladeLayout ?: config('crud-forms.blade_layout'))

@section(config('crud-forms.blade_section'))

<div class="mx-auto max-w-3xl overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-slate-200">
    <div class="border-b border-slate-200 px-6 py-4">
        <h1 class="text-lg font-semibold text-slate-900">{{ $title }} Details</h1>
    </div>

    <div class="px-6 py-2">
        <dl class="divide-y divide-slate-100">
            @foreach ($fields as $field)
                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-slate-500">{{ $field['label'] }}</dt>
                    <dd class="text-sm text-slate-800 sm:col-span-2">@include( "crud-forms::displays.{$field['type']}")</dd>
                </div>
            @endforeach
        </dl>
    </div>

    <div class="flex flex-wrap items-center gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4">
        {{-- Back to resource index --}}
        <a href="{{ route("$route.index") }}"
           class="inline-flex items-center gap-1.5 rounded-md bg-white px-4 py-2 text-sm font-medium text-slate-700 ring-1 ring-inset ring-slate-300 transition hover:bg-slate-50">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            Back to Index
        </a>

        {{-- Edit resource --}}
        <a href="{{ route("$route.edit", $entity->id) }}"
           class="ml-auto inline-flex items-center gap-1.5 rounded-md bg-amber-50 px-4 py-2 text-sm font-medium text-amber-700 ring-1 ring-inset ring-amber-200 transition hover:bg-amber-100">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" /></svg>
            Edit {{ $title }}
        </a>

        {{-- Delete resource --}}
        <form action="{{ route("$route.destroy", $entity->id) }}" method="POST" class="inline-block">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <button type="submit"
                    class="delete-btn inline-flex items-center gap-1.5 rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                Delete {{ $title }}
            </button>
        </form>
    </div>
</div>

@endsection
