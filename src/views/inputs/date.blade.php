@include('crud-forms::inputs.label')

<div class="input-group date">
    <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
    </div>
    {{ Form::text($field['name'], $entity->{$field['name']}, ['class' => 'form-control datepicker', 'placeholder' => 'ΗΗ-ΜΜ-ΕΕΕΕ']) }}
</div>

