<div class="checkbox">
    <label>
        <input type="checkbox"
               id="{{ $field['name'] }}"
               name="{{ $field['name'] }}"
               value="1"
               @if (old($field['name']) || $entity->{$field['name']})
                   checked="checked"
               @endif
        >
        <strong>{{ $field['label'] }}</strong>
    </label>
</div>
