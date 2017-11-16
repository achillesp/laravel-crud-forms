@include('crud-forms::inputs.label')

<div class="input-group date">
    @if (config('crud-forms.button_icons'))
        <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
        </div>
    @endif
    <input type="text"
           id="{{ $field['name'] }}"
           class="form-control datepicker"
           placeholder="YYYY-MM-DD"
           name="{{ $field['name'] }}"
           value="{{ old($field['name']) ?: $entity->{$field['name']} }}"
    >
</div>

