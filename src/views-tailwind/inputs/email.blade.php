@include('crud-forms::inputs.label')

<input type="email"
       id="{{ $field['name'] }}"
       class="block w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
       name="{{ $field['name'] }}"
       value="{{ old($field['name']) ?: $entity->{$field['name']} }}"
>
