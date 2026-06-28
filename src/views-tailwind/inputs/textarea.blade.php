@include('crud-forms::inputs.label')

<textarea id="{{ $field['name'] }}"
          class="block w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
          rows="4"
          name="{{ $field['name'] }}"
>{{ old($field['name']) ?: $entity->{$field['name']} }}</textarea>
