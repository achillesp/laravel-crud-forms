<?php

if (old($field['name'])) {
    $selectedOptions = old($field['name']);
} else {
    $selectedOptions = $entity->{$field['name']}->pluck('id')->toArray();
}

?>

@include('crud-forms::inputs.label')

@foreach($relationshipOptions["{$field['relationship']}"] as $key=>$val)
    <div class="checkbox">
        <label>
            <input type="checkbox"
                   name="{{ $field['name'] }}[]"
                   value="{{ $key }}"
                   @if (in_array($key, $selectedOptions))
                        checked="checked"
                   @endif
            >
            <strong>{{ $val }}</strong>
        </label>
    </div>
@endforeach


