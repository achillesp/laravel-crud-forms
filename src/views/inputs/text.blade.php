@include('crudforms.inputs.label')

{!! Form::text($field['name'], $entity->{$field['name']}, ['class' => 'form-control']) !!}
