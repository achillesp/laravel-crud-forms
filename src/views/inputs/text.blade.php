@include('crud-forms::inputs.label')

{!! Form::text($field['name'], $entity->{$field['name']}, ['class' => 'form-control']) !!}
