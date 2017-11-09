<div class="checkbox">
    <label>
        {!! Form::checkbox( $field['name'], 1, $entity->{$field['name']}, ['class' => 'is-iCheck'] ) !!}
        <strong>{{ $field['label'] }}</strong>
    </label>
</div>
