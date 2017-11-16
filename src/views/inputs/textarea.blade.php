@include('crud-forms::inputs.label')

<textarea id="{{ $field['name'] }}"
          class="form-control"
          rows="4" cols="50"
          name="{{ $field['name'] }}"
>
    {{ old($field['name']) ?: $entity->{$field['name']} }}
</textarea>