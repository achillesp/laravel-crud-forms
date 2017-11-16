<?php

if (old($field['name'])) {
    $selectedOptions = old($field['name']);
} else {
    $selectedOptions = $entity->{$field['name']}->pluck('id')->toArray();
}

?>

@include('crud-forms::inputs.label')

<select class="form-control select2"
        multiple="multiple"
        id="{{ $field['name'] }}[]"
        placeholder="Select..."
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

