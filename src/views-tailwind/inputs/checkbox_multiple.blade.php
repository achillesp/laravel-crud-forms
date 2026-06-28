<?php

if (old($field['name'])) {
    $selectedOptions = old($field['name']);
} else {
    $selectedOptions = $entity->{$field['name']}->pluck('id')->toArray();
}

?>

@include('crud-forms::inputs.label')

<div class="space-y-2">
    @foreach($relationshipOptions["{$field['relationship']}"] as $key=>$val)
        <label class="flex items-center gap-2">
            <input type="checkbox"
                   name="{{ $field['name'] }}[]"
                   value="{{ $key }}"
                   class="h-4 w-4 rounded border-slate-300 accent-indigo-600"
                   @if (in_array($key, $selectedOptions))
                        checked="checked"
                   @endif
            >
            <span class="text-sm text-slate-700">{{ $val }}</span>
        </label>
    @endforeach
</div>
