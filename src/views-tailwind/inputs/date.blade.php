@include('crud-forms::inputs.label')

<div class="relative">
    @if (config('crud-forms.button_icons'))
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
        </div>
    @endif
    <input type="text"
           id="{{ $field['name'] }}"
           class="datepicker block w-full rounded-md border border-slate-300 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 {{ config('crud-forms.button_icons') ? 'pl-10 pr-3' : 'px-3' }}"
           placeholder="YYYY-MM-DD"
           name="{{ $field['name'] }}"
           value="{{ old($field['name']) ?: $entity->{$field['name']} }}"
    >
</div>
