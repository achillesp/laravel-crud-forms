@foreach ($fields as $field)

    <div class="form-group">
        @include( "crud-forms::inputs.{$field['type']}")
    </div>

@endforeach