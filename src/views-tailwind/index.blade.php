@extends( $bladeLayout ?: config('crud-forms.blade_layout'))

@section(config('crud-forms.blade_section'))

<div class="overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-slate-200">
    <div class="flex items-center justify-between gap-4 border-b border-slate-200 px-6 py-4">
        <h1 class="text-lg font-semibold text-slate-900">{{ \Illuminate\Support\Str::plural($title) }} Index</h1>
        <a href="{{ route("$route.create") }}"
           class="inline-flex items-center gap-1.5 rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            Add New {{ $title }}
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="data-table min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50">
                <tr>
                    @foreach ($fields as $field)
                        <th class="px-6 py-3 text-left font-medium text-slate-500">{{ $field['label'] }}</th>
                    @endforeach
                    @if ($withTrashed)
                        <th class="px-6 py-3 text-left font-medium text-slate-500">Deleted On</th>
                    @endif
                    <th class="px-6 py-3 text-right font-medium text-slate-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($entities as $entity)
                    <tr class="hover:bg-slate-50">
                        @foreach ($fields as $field)
                            <td class="whitespace-nowrap px-6 py-3 text-slate-700">@include( "crud-forms::displays.{$field['type']}")</td>
                        @endforeach

                        @if ($withTrashed)
                            <td class="whitespace-nowrap px-6 py-3 text-slate-500">{{ !empty($entity->deleted_at) ? $entity->deleted_at : '' }}</td>
                        @endif

                        <td class="whitespace-nowrap px-6 py-3">
                            <div class="flex items-center justify-end gap-2">
                                @if (empty($entity->deleted_at))
                                    {{-- Show --}}
                                    <a href="{{ route("$route.show", $entity->id) }}"
                                       class="inline-flex items-center gap-1 rounded-md bg-sky-50 px-2.5 py-1.5 text-xs font-medium text-sky-700 ring-1 ring-inset ring-sky-200 transition hover:bg-sky-100">
                                        @if (config('crud-forms.button_icons'))
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                            <span class="sr-only">Show</span>
                                        @else
                                            Show
                                        @endif
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route("$route.edit", $entity->id) }}"
                                       class="inline-flex items-center gap-1 rounded-md bg-amber-50 px-2.5 py-1.5 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-200 transition hover:bg-amber-100">
                                        @if (config('crud-forms.button_icons'))
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" /></svg>
                                            <span class="sr-only">Edit</span>
                                        @else
                                            Edit
                                        @endif
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route("$route.destroy", $entity->id) }}" method="POST" class="inline-block">
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <button type="submit"
                                                class="delete-btn inline-flex items-center gap-1 rounded-md bg-red-50 px-2.5 py-1.5 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-200 transition hover:bg-red-100">
                                            @if (config('crud-forms.button_icons'))
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                                <span class="sr-only">Delete</span>
                                            @else
                                                Delete
                                            @endif
                                        </button>
                                    </form>
                                @elseif ($withTrashed)
                                    {{-- Restore SoftDeleted --}}
                                    <form action="{{ '/' . request()->path() . '/' . $entity->id . '/restore' }}" method="POST" class="inline-block">
                                        {{ method_field('PUT') }}
                                        {{ csrf_field() }}
                                        <button type="submit"
                                                class="restore-btn inline-flex items-center gap-1 rounded-md bg-emerald-50 px-2.5 py-1.5 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-200 transition hover:bg-emerald-100">
                                            @if (config('crud-forms.button_icons'))
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" /></svg>
                                            @endif
                                            Restore
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
