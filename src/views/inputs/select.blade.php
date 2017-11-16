<?php

if (old($field['name'])) {
    $selectedOption = old($field['name']);
} else {
    $selectedOption = $entity->{$field['name']};
}

?>

@include('crud-forms::inputs.label')

<select class="form-control select2" id="{{ $field['name'] }}" placeholder="Select..." name="{{ $field['name'] }}">
    @foreach($relationshipOptions["{$field['relationship']}"] as $key=>$val)
        <option value="{{ $key }}"
            @if ($key == $selectedOption)
                selected="selected"
            @endif
        >{{ $val }}</option>
    @endforeach
</select>
