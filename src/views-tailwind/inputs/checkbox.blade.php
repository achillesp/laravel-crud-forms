<label class="inline-flex items-center gap-2">
    <input type="checkbox"
           id="{{ $field['name'] }}"
           name="{{ $field['name'] }}"
           value="1"
           class="h-4 w-4 rounded border-slate-300 accent-indigo-600"
           @if (old($field['name']) || $entity->{$field['name']})
               checked="checked"
           @endif
    >
    <span class="text-sm font-medium text-slate-700">{{ $field['label'] }}</span>
</label>
