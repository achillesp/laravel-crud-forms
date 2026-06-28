<?php

if (old($field['name'])) {
    $selectedOption = old($field['name']);
} else {
    $selectedOption = $entity->{$field['name']};
}

?>

@include('crud-forms::inputs.label')

<div class="space-y-2">
    @foreach($relationshipOptions["{$field['relationship']}"] as $key=>$val)
        <label class="flex items-center gap-2">
            <input type="radio"
                   name="{{ $field['name'] }}"
                   value="{{ $key }}"
                   class="h-4 w-4 border-slate-300 accent-indigo-600"
                   @if ($key == $selectedOption)
                       checked="checked"
                   @endif
            >
            <span class="text-sm text-slate-700">{{ $val }}</span>
        </label>
    @endforeach
</div>
