<?php

if (old($field['name'])) {
    $selectedOption = old($field['name']);
} else {
    $selectedOption = $entity->{$field['name']};
}

?>

@include('crud-forms::inputs.label')

<select class="select2 block w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
        id="{{ $field['name'] }}"
        name="{{ $field['name'] }}"
>
    @foreach($relationshipOptions["{$field['relationship']}"] as $key=>$val)
        <option value="{{ $key }}"
            @if ($key == $selectedOption)
                selected="selected"
            @endif
        >{{ $val }}</option>
    @endforeach
</select>
