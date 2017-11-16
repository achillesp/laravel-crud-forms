@include('crud-forms::inputs.label')

<input type="url"
       id="{{ $field['name'] }}"
       class="form-control"
       name="{{ $field['name'] }}"
       value="{{ old($field['name']) ?: $entity->{$field['name']} }}"
>