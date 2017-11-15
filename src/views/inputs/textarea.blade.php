@include('crud-forms::inputs.label')

{!! Form::textarea($field['name'], $entity->{$field['name']}, ['class' => 'form-control', 'rows' => '4', 'cols' => '50']) !!}
