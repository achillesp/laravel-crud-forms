@include('crud-forms::inputs.label')

{{ Form::select(
    "{$field['name']}[]",
    $relationshipOptions["{$field['relationship']}"],
    $entity->{$field['name']}->pluck('id')->toArray(),
    ['multiple' => true, 'class' => 'form-control select2', 'placeholder' => 'Select...']
) }}
