<?php

if (old($field['name'])) {
    $selectedOptions = old($field['name']);
} else {
    $selectedOptions = $entity->{$field['name']}->pluck('id')->toArray();
}

?>

@include('crud-forms::inputs.label')

<select class="select2 block w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
        multiple="multiple"
        id="{{ $field['name'] }}"
        name="{{ $field['name'] }}[]"
>
    @foreach($relationshipOptions["{$field['relationship']}"] as $key=>$val)
        <option value="{{ $key }}"
            @if (in_array($key, $selectedOptions))
                selected="selected"
            @endif
        >{{ $val }}</option>
    @endforeach
</select>
