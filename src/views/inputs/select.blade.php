@include('crudforms.inputs.label')

{!! Form::select($field['name'],
    $relationshipOptions["{$field['relationship']}"],
    $entity->{$field['name']},
    ['class' => 'form-control select2', 'placeholder' => 'Select...'])
!!}
