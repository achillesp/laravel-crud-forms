<?php

if (old($field['name'])) {
    $selectedOption = old($field['name']);
} else {
    $selectedOption = $entity->{$field['name']};
}

?>

@include('crud-forms::inputs.label')

@foreach($relationshipOptions["{$field['relationship']}"] as $key=>$val)
    <div class="radio">
        <label>
            <input type="radio"
                   name="{{ $field['name'] }}"
                   value="{{ $key }}"
                   @if ($key == $selectedOption)
                       checked="checked"
                   @endif
            >
            <strong>{{ $val }}</strong>
        </label>
    </div>
@endforeach