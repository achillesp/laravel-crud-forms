@extends( $bladeLayout ?: config('crud-forms.blade_layout'))

@section(config('crud-forms.blade_section'))

<div class="mx-auto max-w-3xl overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-slate-200">
    <div class="border-b border-slate-200 px-6 py-4">
        <h1 class="text-lg font-semibold text-slate-900">Add New {{ $title }}</h1>
    </div>

    <div class="px-6 py-6">
        @include('crud-forms::_errors')

        <form action="{{ route("$route.store") }}" method="POST">
            {{ csrf_field() }}

            @include('crud-forms::form')

            <div class="mt-6 flex items-center gap-3 border-t border-slate-200 pt-6">
                {{-- Back to resource index --}}
                <a href="{{ route("$route.index") }}"
                   class="inline-flex items-center gap-1.5 rounded-md bg-white px-4 py-2 text-sm font-medium text-slate-700 ring-1 ring-inset ring-slate-300 transition hover:bg-slate-50">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
                    Back
                </a>

                {{-- Submit --}}
                <button type="submit"
                        class="ml-auto inline-flex items-center gap-1.5 rounded-md bg-emerald-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                    Submit Form
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
